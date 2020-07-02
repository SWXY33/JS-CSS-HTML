package com.guet.alipay;

import java.util.Iterator;
import java.util.Map;
import java.util.Set;

import com.alipay.api.AlipayApiException;
import com.alipay.api.AlipayClient;
import com.alipay.api.DefaultAlipayClient;
import com.alipay.api.request.AlipayTradePrecreateRequest;
import com.alipay.api.response.AlipayTradePrecreateResponse;
import com.guet.utils.StringUtils;

public class PayTest {
	public static void main(String[] args) {
		String alipayPublicKey = "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDDI6d306Q8fIfCOaTXyiUeJHk" +
				"rIvYISRcc73s3vF1ZT7XN8RNPwJxo8pWaJMmvyTn9N4HQ632qJBVHf8sxHi/fEsra" +
				"prwCtzvzQETrNRwVxLO5jVmRGi60j8Ue1efIlzPXV9je9mkjzOmdssymZkh2QhUrC" +
				"mZYI/FCEa3/cNMW0QIDAQAB";
		String privateKey = "MIICeAIBADANBgkqhkiG9w0BAQEFAASCAmIwggJeAgEAAoGBAMWYgxHhXDOt34UB"
				+"OicsBXeH8qpKqomG0jKxURi8pVlJVz+ylTCMY0nywbnJpJc+rAlixMYJT6S3V3kt"
				+"E615jjPXsHQeNuNHFeqxc+aXUVN1uRI7Bw7bXaE3CbV09I1Z9skOKvUoFyQoD7cV"
				+"RQuAOP0lnu7rLI9zUFWbnwk074hdAgMBAAECgYEAkyOopo3sfMdDJOXvCfBr+cCQ"
				+"YWLMbzCoIfuMaiE/96b3g4VWNxqzbQOKYvDW0ZFnxm14Hggc+IlWZ/O7LXjQ/FbK"
				+"/p3y3dqE6rxy7mtxeV1tJDg8OGK/iNSlT1jeF5YTsrpo6urjjc4KdH3y4G+vwlUt"
				+"ZQFEwzF2CFZ+jZvjAPkCQQDnrPIKZQLz0526+qOOyR9FHAKBzipKqHcPzM9jVo7g"
				+"TtS7avW7Ln76pRuGGNWsJXBZ7lgAXDE3lHJHOSPjXpW/AkEA2leOvv1CVr+ibciH"
				+"tTh5xkKDIcQ3Cxm3WGD1JNx9IE4HUpLQn9o3SEtBstNgttX8i3vpUCFenB9LeYsW"
				+"T59A4wJBANThOdcLUlcyEDGLtVaywCUEw9j61Cmd+yltjPM+yjKavScp9Xp2Ev/F"
				+"TzE9CLoR/NbmB77s99yWbxu7CZsXgokCQQC4NOSGd26Pd2/XBTaRCouaW6T8SOlT"
				+"YSfQ1UQdDDQ4m/wLizedlWHMiUltUG4o8tH0796ALxb9yl1HtrNlC2uXAkBshCwY"
				+"UqvmeBpjzeGwYxSJN/6WmNnBFzEfISNN0K/qQeUsg9J4E5feutnRI0HgwFMu8iXz"
				+"bh5fj66jDfOI0LjE";
		//实例化客户端
		AlipayClient alipayClient = new DefaultAlipayClient("https://openapi.alipay.com/gateway.do",
				"2016051601408113",privateKey,"json","GBK",alipayPublicKey);
		//实例化具体API对应的request类,类名称和接口名称对应
		AlipayTradePrecreateRequest request = new AlipayTradePrecreateRequest();
		//SDK已经封装掉了公共参数，这里只需要传入业务参数
		request.setBizContent("{"
				+ "\"out_trade_no\":\"" + StringUtils.genUUID() + "\","
				+ "\"total_amount\":0.01,"
				+ "\"subject\":\"莉莉外卖订单\""
				+ "}");
		try {
			AlipayTradePrecreateResponse response = alipayClient.execute(request);
			System.out.println(response.getMsg());
			System.out.println(response.getSubCode());
			Map<String, String> map = response.getParams();
			for (Map.Entry<String, String> entry : map.entrySet()) {
				System.out.println(entry.getKey() + ":" + entry.getValue());
			}
			System.out.println(response.getQrCode());
			System.out.println(response.getOutTradeNo());
		} catch (AlipayApiException e) {
			e.printStackTrace();
		}
	}
}
