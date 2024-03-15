package com.highcharts.export.controller;

import java.io.ByteArrayOutputStream;
import java.io.FileInputStream;
import java.io.IOException;
import java.util.NoSuchElementException;
import java.util.concurrent.TimeoutException;

import javax.annotation.Resource;
import javax.servlet.ServletContext;
import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.apache.commons.io.IOUtils;
import org.apache.log4j.Logger;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpHeaders;
import org.springframework.http.HttpStatus;
import org.springframework.http.MediaType;
import org.springframework.http.ResponseEntity;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.ExceptionHandler;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.ResponseBody;
import org.springframework.web.servlet.ModelAndView;

import com.highcharts.export.converter.SVGConverter;
import com.highcharts.export.converter.SVGConverterException;
import com.highcharts.export.pool.PoolException;
import com.highcharts.export.util.MimeType;

@Controller
@RequestMapping("/")
public class ExportController {
	
	private static final long serialVersionUID = 1L;
	private static final Float MAX_WIDTH = 2000.0F;
	private static final Float MAX_SCALE = 4.0F;
	private static final String SVG_DOCTYPE = "<?xml version=\"1.0\" standalone=\"no\"?><!DOCTYPE svg PUBLIC \"-//W3C//DTD SVG 1.1//EN\" \"http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd\">";
	protected static Logger logger = Logger.getLogger("exporter");

	@Autowired
	private SVGConverter converter;

	@Autowired
	private ServletContext servletContext;

	@RequestMapping(value = "/test/{fileName}", method = RequestMethod.GET)
	@ResponseBody
	public ResponseEntity<byte[]> staticImagesDownload(
	                 @PathVariable("fileName") String fileName) throws IOException {

	    String imageLoc = servletContext.getRealPath("WEB-INF/benchmark");
	    FileInputStream fis = new FileInputStream(imageLoc + "/" + fileName + ".png");

        ByteArrayOutputStream bos = new ByteArrayOutputStream();
        byte[] buf = new byte[1024];
        try {
            for (int readNum; (readNum = fis.read(buf)) != -1;) {
                bos.write(buf, 0, readNum);
            }
        } catch (IOException ex) {
            // nothing here
        } finally {
        	fis.close();
        }

	    HttpHeaders responseHeaders = httpHeaderAttachment("TEST-" + fileName,  MimeType.PNG,
				bos.size());
		return new ResponseEntity<byte[]>(bos.toByteArray(),
				responseHeaders, HttpStatus.OK);
	}

	private HttpHeaders httpHeaderAttachment(final String filename,
			final MimeType mime, final int fileSize) {
		HttpHeaders responseHeaders = new HttpHeaders();
		responseHeaders.set("charset", "utf-8");
		responseHeaders
				.setContentType(MediaType.parseMediaType(mime.getType()));
		responseHeaders.setContentLength(fileSize);
		responseHeaders.set("Content-disposition", "attachment; filename=\""
				+ filename + "." + mime.name().toLowerCase() + "\"");
		return responseHeaders;
	}

	private String getFilename(String name) {
		name = sanitize(name);
		return (name != null) ? name : "chart";
	}

	private static MimeType getMime(String mime) {
		MimeType type = MimeType.get(mime);
		if (type != null) {
			return type;
		}
		return MimeType.PNG;
	}

	private static String sanitize(String parameter) {
		if (parameter != null && !parameter.trim().isEmpty() && !(parameter.compareToIgnoreCase("undefined") == 0)) {
			return parameter.trim();
		}
		return null;
	}

	private static Float widthToFloat(String width) {
		width = sanitize(width);
		if (width != null) {
			Float parsedWidth = Float.valueOf(width);
			if (parsedWidth.compareTo(MAX_WIDTH) > 0) {
				return MAX_WIDTH;
			}
			if (parsedWidth.compareTo(0.0F) > 0) {
				return parsedWidth;
			}
		}
		return null;
	}

	private static Float scaleToFloat(String scale) {
		scale = sanitize(scale);
		if (scale != null) {
			Float parsedScale = Float.valueOf(scale);
			if (parsedScale.compareTo(MAX_SCALE) > 0) {
				return MAX_SCALE;
			} else if (parsedScale.compareTo(0.0F) > 0) {
				return parsedScale;
			}
		}
		return null;
	}

	@RequestMapping(method = RequestMethod.POST)
	public @ResponseBody byte[] exporter(
			
