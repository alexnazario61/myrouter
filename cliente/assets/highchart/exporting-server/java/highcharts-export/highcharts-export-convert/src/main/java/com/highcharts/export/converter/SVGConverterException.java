/**
 * @license Highcharts JS v2.3.3 (2012-11-02)
 *
 * (c) 20012-2014
 * 
 * Author: Gert Vaartjes
 *
 * License: www.highcharts.com/license
 */
package com.highcharts.export.converter;

public class SVGConverterException extends Exception {

    private static final long serialVersionUID = -5110552374074051446L;
    private String errorMessage;

    public SVGConverterException() {
        this("Unknown error");
    }

    public SVGConverterException(String err) {
        super(err); // call super class constructor
        this.errorMessage = err; // save message
    }

    public String getErrorMessage() {
        return errorMessage;
    }

    public void setErrorMessage(String errorMessage) {
        this.errorMessage = errorMessage;
    }

}
