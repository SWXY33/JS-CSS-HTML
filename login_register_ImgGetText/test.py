# encoding:utf-8

import requests
import base64

from flask import json

'''
通用文字识别
'''


request_url = "https://aip.baidubce.com/rest/2.0/ocr/v1/general_basic"
# 二进制方式打开图片文件
f = open('test.jpeg', 'rb')
img = base64.b64encode(f.read())

params = {"image": img}
host = 'https://aip.baidubce.com/oauth/2.0/token?grant_type=client_credentials&client_id=wWhMTtGSw94YdyulpdEUBl8n&client_secret=oxa52U6DUti5P6FwlxhGLFsrHeTBO8RE'
response = requests.get(host)
if response:
    dict_str = json.loads(response.text)  # 转换成json格式
    dic_data = dict_str["refresh_token"]
print(dic_data)
access_token = "24.28f34e60607a77af4a5166b38c45d2a9.2592000.1589532214.282335-19439106"
print(access_token)
request_url = request_url + "?access_token=" + access_token
headers = {'content-type': 'application/x-www-form-urlencoded'}
print(request_url)
response = requests.post(request_url, data=params, headers=headers)

if response:
    print(response.json())