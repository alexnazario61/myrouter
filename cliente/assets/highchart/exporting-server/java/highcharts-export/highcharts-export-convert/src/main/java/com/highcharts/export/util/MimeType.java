/**
 * @license Highcharts JS v2.3.3 (2012-11-02)
 *
 * (c) 2012-2014
 *
 * Author: Gert Vaartjes
 *
 * License: www.highcharts.com/license
 */
package com.highcharts.export.util;

import java.util.EnumSet;
import java.util.HashMap;
import java.util.Map;

/**
 * An enumeration representing various MIME types supported for image export.
 * Each enumerated value represents a specific MIME type and its corresponding file extension.
 */
public enum MimeType {
	PNG("image/png", "png"), // PNG image format
	JPEG("image/jpeg", "jpeg"), // JPEG image format
	PDF("application/pdf", "pdf"), // PDF document format
	SVG("image/svg+xml", "svg"); // Scalable Vector Graphics format

	/**
	 * A static map for quick lookups of MIME types based on their type or extension.
	 */
	private static final Map<String, MimeType> lookup = new HashMap<String, MimeType>();

	static {
		// Initialize the lookup map with all enumerated values
		for (MimeType m : EnumSet.allOf(MimeType.class)) {
			lookup.put(m.getType(), m);
			lookup.put(m.getExtension(), m);
		}
	}

	/**
	 * The actual MIME type string.
	 */
	private String type;

	/**
	 * The file extension associated with the MIME type.
	 */
	private String extension;

	/**
	 * Constructor for the MimeType enumeration.
	 *
	 * @param type    The MIME type string.
	 * @param extension The file extension associated with the MIME type.
	 */
	private MimeType(String type, String extension) {
		this.type = type
