/**
 * @license Highcharts JS v2.3.3 (2012-11-02)
 *
 * (c) 2012-2014
 *
 * Author: Gert Vaartjes
 *
 * License: www.highcharts.com/license
 */
package com.highcharts.export.converter;

import java.io.ByteArrayOutputStream;
import java.io.File;
import java.io.FileOutputStream;
import java.io.FileUtils;
import java.io.IOException;
import java.io.OutputStream;
import java.net.SocketTimeoutException;
import java.util.Base64;
import java.util.HashMap;
import java.util.Map;
import java.util.NoSuchElementException;
import java.util.Random;
import java.util.concurrent.BlockingQueue;
import java.util.concurrent.LinkedBlockingQueue;
import java.util.concurrent.TimeUnit;

import org.apache.commons.codec.binary.Base64;
import org.apache.commons.io.FileUtils;
import org.apache.commons.lang3.RandomStringUtils;
import org.apache.log4j.Logger;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.google.gson.Gson;
import com.highcharts.export.pool.PoolException;
import com.highcharts.export.pool.Server;
import com.highcharts.export.util.MimeType;

@Service("svgConverter")
public class SVGConverter implements Serializable {

    private static final long serialVersionUID = 1L;

    @Autowired
    private BlockingQueue<Server> serverPool;

    protected static final Logger logger = Logger.getLogger("converter");

    public SVGConverter() {
        if (serverPool == null) {
            serverPool = new LinkedBlockingQueue<>();
        }
    }

    public ByteArrayOutputStream convert(String input, MimeType mime, String constructor, String callback, Float width, Float scale) throws SVGConverterException, IOException, PoolException, NoSuchElementException, TimeoutException {
        return this.convert(input, null, null, null, mime, constructor, callback, width, scale);
    }

    public ByteArrayOutputStream convert(String input, String globalOptions, String dataOptions, String customCode, MimeType mime, String constructor, String callback, Float width, Float scale) throws SVGConverterException, IOException, PoolException, NoSuchElementException, TimeoutException {
        ByteArrayOutputStream stream = null;

        // get filename
        String extension = mime.name().toLowerCase();
        String outFilename = createUniqueFileName("." + extension);

        Map<String, String> params = new HashMap<>();
        Gson gson = new Gson();

        params.put("infile", input);
        params.put("outfile", outFilename);

        if (constructor != null && !constructor.isEmpty()) {
            params.put("constr", constructor);
        }

        if (callback != null && !callback.isEmpty()) {
            params.put("callback", callback);
        }

        if (globalOptions != null && !globalOptions.isEmpty()) {
            params.put("globaloptions", globalOptions);
        }

        if (dataOptions != null && !dataOptions.isEmpty()) {
            params.put("dataoptions", dataOptions);
        }

        if (customCode != null && !customCode.isEmpty()) {
            params.put("customcode", customCode);
        }

        if (width != null) {
            params.put("width", String.valueOf(width));
        }

        if (scale != null) {
            params.put("scale", String.valueOf(scale));
        }

        String json = gson.toJson(params);
        String output = requestServer(json);

        // check for errors
        if (output.startsWith("error")) {
            logger.debug("received error from phantomjs: " + output);
            throw new SVGConverterException("received error from phantomjs: " + output);
        }

        stream = new ByteArrayOutputStream();
        if (output.equalsIgnoreCase(outFilename)) {
            // in case of pdf, phantom cannot base64 on pdf files
            stream.write(FileUtils.readFileToByteArray(new File(outFilename)));
        } else {
            // assume phantom is returning SVG or a base64 string for images
            if (extension.equals("svg")) {
                stream.write(output.getBytes());
            } else {
                stream.write(Base64.getDecoder().decode(output));
            }
        }
        return stream;
    }

    public String requestServer(String params) throws SVGConverterException, TimeoutException, NoSuchElementException, PoolException {
        Server server = null;

        try {
            server = serverPool.poll(10, TimeUnit.SECONDS);
            if (server == null) {
                throw new NoSuchElementException("No server available in the pool.");
            }
            String response = server.request(params);

            return response;
        } catch (InterruptedException e) {
            Thread.currentThread().interrupt();
            throw new TimeoutException("Interrupted while waiting for a server from the pool.");
        } catch (SocketTimeoutException ste) {
            throw new TimeoutException(ste.getMessage());
        } catch (PoolException nse) {
            logger.error("POOL EXHAUSTED!!");
            throw new PoolException(nse.getMessage());
        } catch (Exception e) {
            logger.error(e.getMessage(), e);
            throw new SVG
