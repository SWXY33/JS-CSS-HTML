package com.guet.servlet;

import javax.servlet.http.HttpServlet;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.net.HttpURLConnection;
import java.net.URL;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.springframework.stereotype.Component;

@SuppressWarnings("serial")
@Component
public class JsProxyServlet extends HttpServlet {

    protected void doGet(HttpServletRequest request,
            HttpServletResponse response) throws ServletException, IOException {
        processRequest(request, response);
    }

    protected void doPost(HttpServletRequest request,
            HttpServletResponse response) throws ServletException, IOException {
        processRequest(request, response);
    }

    private void processRequest(HttpServletRequest request,
            HttpServletResponse response) throws ServletException, IOException {

        HttpURLConnection connection = null;
        InputStream istream = null; // input to proxy
        OutputStream ostream = null; // output from proxy
        InputStream connectionIstream = null; // output for the target is
        // input for the connection
        OutputStream connectionOstream = null; // input for the target is
        // output for the connection

        String remoteHost = request.getRemoteHost(); // get host address of
        // client - for checking
        // allowedHosts
        boolean allowedHost = isAllowedHost(remoteHost); // The allowedHosts
        try {
            String uri = request.getQueryString();
            if (uri == null || uri.isEmpty()) {
                response.sendError(403,
                        "This proxy does not support empty parameters.");
                return;
            }
            // easy way to ignore case of param?
            if (uri != null && uri != "" && allowedHost) {

                // HTTPUrlConnection looks at http.proxyHost and http.proxyPort
                // system properties.
                // Make sure these properties are set these if you are behind a
                // proxy.

                // step 1: initialize
                String requestMethod = request.getMethod();

                URL targetURL = new URL(uri);
                connection = (HttpURLConnection) targetURL.openConnection();
                connection.setRequestMethod(requestMethod);
                transferHTTPRequestHeaders(connection, request);

                // step 2: proxy requests
                if (requestMethod.equals("GET")) {
                    // default for setDoInput is true
                    connectionIstream = connection.getInputStream();
                }
                
                if (requestMethod.equals("POST")) {
                    transferHTTPRequestHeadersForPOST(connection, request);
                    int clength = request.getContentLength();// clength is

                    if (clength > 0) {
                        istream = request.getInputStream();
                        connection.setDoOutput(true);// for POST we need to
                        // write to connection
                        connection.setRequestProperty("Content-Length",
                                Integer.toString(clength)); // only valid for
                                                            // POST
                        // request
                        connectionOstream = connection.getOutputStream();
                        // copy the request body to remote outputStream
                        copy(istream, connectionOstream);
                    }
                    connectionIstream = connection.getInputStream();
                }

                // step 3: return output
                // can output be the same for GET/POST? or different return
                // headers?
                // servlet may return 3 things: status code, response headers,
                // response body
                // status code and headers have to be set before response body
                String contentType= connection.getContentType();
                //由于查询WFS的返回结果乱码，因此重新设置内容编码
                contentType = contentType.indexOf("charset") == -1 ?  "html/xml;charset=utf-8" :contentType;
                response.setContentType(contentType);
                ostream = response.getOutputStream();
                copy(connectionIstream, ostream);
            }
            
        } catch (Exception e) {
            sendErrorResponse(response, e); 
            //e.printStackTrace();
        } finally {
            if (istream != null) {
                istream.close();
            }
            if (ostream != null) {
                ostream.close();
            }
            if (connectionIstream != null) {
                connectionIstream.close();
            }
            if (connectionOstream != null) {
                connectionOstream.close();
            }
        }

    }

    private void copy(InputStream istream, OutputStream ostream)
            throws Exception {
        int bufferSize = 4 * 4 * 1024;// same buffer size as in Jetty utils
        // (2*8192)
        byte[] buffer = new byte[bufferSize];
        int read;
        while ((read = istream.read(buffer)) != -1) {
            ostream.write(buffer, 0, read);
        }
    }

    private void transferHTTPRequestHeaders(HttpURLConnection connection,
            HttpServletRequest request) {
        // TODO make sure all headers are copied to target, see for HTTP headers
        // http://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html
        // Do request.getProperties to get request properties
        if (request.getHeader("Accept") != null) {
            connection.setRequestProperty("Accept", request.getHeader("Accept"));
        }
        if (request.getHeader("Accept-Charset") != null) {
            connection.setRequestProperty("Accept-Charset",
                    request.getHeader("Accept-Charset"));
        }
        if (request.getHeader("Accept-Encoding") != null) {
            // TODO browsers accept gzipped, should proxy accept gzip and how to
            // handle it?
            // connection.setRequestProperty("Accept-Encoding",
            // request.getHeader("Accept-Encoding"));
        }
        if (request.getHeader("Authorization") != null) {
            connection.setRequestProperty("Authorization",
                    request.getHeader("Authorization"));
        }
        if (request.getHeader("Connection") != null) {
            // TODO HTTP/1.1 proxies MUST parse the Connection header field
            // before a message is forwarded and, for each connection-token in
            // this field, remove any header field(s) from the message with the
            // same name as the connection-token.
            // connection.setRequestProperty("Connection",
            // request.getHeader("Connection"));
        }

        // set de-facto standard proxy headers (x-forwarded-for, others?s)
        if (request.getHeader("X-Forwarded-For") != null) {
            connection.setRequestProperty("X-Forwarded-For",
                    request.getHeader("X-Forwarded-For"));// TODO append IP                                                            
        } else {
            connection.setRequestProperty("X-Forwarded-For",
                    request.getRemoteAddr());// TODO append IP proxy
        }
    }

    private void transferHTTPRequestHeadersForPOST(
            HttpURLConnection connection, HttpServletRequest request) {
        if (request.getHeader("Content-Type") != null) {
            connection.setRequestProperty("Content-Type",
                    request.getContentType());
        } else {
            // throw exception?
        }
    }

    private boolean isAllowedHost(String remoteHost) {
        // TODO checking of host
        return true;
    }

        private static void sendErrorResponse(HttpServletResponse response, Exception exp) throws IOException{
        try{
             String message = "{" +
                        "\"error\": {" +
                        "\"code\": " + 500 + "," +
                        ", \"message\": \"" + exp.getMessage() + "\"}}";

                response.setStatus(500);
                OutputStream output = response.getOutputStream();
                output.write(message.getBytes());
                output.flush(); 
        }
        catch(Exception e){     
            response.sendError(500,"This proxy has happened something wrong.");
        }
    }

}