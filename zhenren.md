# GM-Ag API 文档 (Zhenren)

## 文档说明

本文档基于 GM-Ag API Guide，参考链接：
- [GM-Ag API Guide](https://globaltllc.atlassian.net/wiki/spaces/GAG1/pages/1243546629)
- [创建玩家](https://globaltllc.atlassian.net/wiki/spaces/GAG1/pages/1243546629)
- [获取打开游戏令牌](https://globaltllc.atlassian.net/wiki/spaces/GAG1/pages/1243546648)
- [查询玩家余额](https://globaltllc.atlassian.net/wiki/spaces/GAG1/pages/1243546661)
- [玩家上分](https://globaltllc.atlassian.net/wiki/spaces/GAG1/pages/1243546674)
- [玩家下分](https://globaltllc.atlassian.net/wiki/spaces/GAG1/pages/1243546687)
- [查询交易信息](https://globaltllc.atlassian.net/wiki/spaces/GAG1/pages/1243546700)
- [编码信息](https://globaltllc.atlassian.net/wiki/spaces/GAG1/pages/1243513252/Code+Information)
- [加密代码示例](https://globaltllc.atlassian.net/wiki/spaces/GAG1/pages/1243546890/6.)

## 接口地址说明

GM-Ag API 有两个不同的接口地址：

1. **游戏接口地址** (`gmag_api_url`)：用于玩家操作、支付等
   - 创建玩家、获取令牌、查询余额、上分下分等

2. **游戏数据接口地址** (`gmag_game_data_url`)：用于拉取游戏数据、历史记录等
   - 拉取游戏交易信息、游戏历史、游戏报表等

## 签名验证

所有 API 请求都需要在请求参数中包含 `hash` 字段，用于验证请求的合法性。

### 签名生成规则

1. 排除 `hash` 字段，对剩余参数按 key 进行字典序排序
2. 将参数拼接成字符串：`key1=value1&key2=value2&...`
3. 如果 value 是数组，需要转换为 JSON 字符串（不转义斜杠）
4. 处理 unicode 字符
5. 将最后一个 `&` 替换为 `secretKey`，然后计算 MD5

### 签名验证示例代码

#### PHP

```php
class PhpExampleCode {
  private static function checkMD5($request): bool {
    $key = 'secretKey';
    $data = $request->except('hash');
    $string = '';
    ksort($data);
    foreach ($data as $k => $v) {
      if (is_array($v)) {
        $v = json_encode($v, JSON_UNESCAPED_SLASHES);
      }
      $string .= $k . '=' . $v . '&';
    }
    // unicode string replace
    $string = preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($match) {
      return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
    }, $string);
    return $request->hash === md5(Str::replaceLast('&', $key, $string));
  }
}
```

#### C#

```csharp
class Program {
  static void Main(string[] args) {
    Dictionary<String, dynamic> dict = new Dictionary<string, dynamic>();
    dict.Add("param1", 1);
    dict.Add("param3", new string[] { "a1", "a2" });
    dict.Add("param2", "param2");
    Console.WriteLine(EncryptString(ExceptHashAndSort(dict) + "1234"));
  }

  public static String ExceptHashAndSort(Dictionary<string, dynamic> requestDict) {
    requestDict.Remove("hash");
    Dictionary<String, dynamic> sortedDict = requestDict.OrderBy(o => o.Key).ToDictionary(o => o.Key, p => p.Value);
    String plain = "";
    foreach(KeyValuePair<string, dynamic> dict in sortedDict){
      plain += dict.Key + "=";
      if (dict.Value is Array) {
        plain += System.Text.Json.JsonSerializer.Serialize(dict.Value);
      } else {
        plain += dict.Value;
      }
      plain += "&";
    }
    return plain.Substring(0, plain.Length - 1);
  }

  public static string EncryptString(string str) {
    MD5 md5 = MD5.Create();
    byte[] byteOld = Encoding.UTF8.GetBytes(str);
    byte[] byteNew = md5.ComputeHash(byteOld);
    StringBuilder sb = new StringBuilder();
    foreach (byte b in byteNew) {
      sb.Append(b.ToString("x2"));
    }
    return sb.ToString();
  }
}
```

#### Java

```java
package com.example.demo.util;

import java.util.List;
import java.util.Map;
import java.util.TreeMap;
import com.example.demo.util.MD5Util;
import org.springframework.util.StringUtils;

public class HashExampleCode {
  private static Map<String, Object> objToSortedMap(Object object) {
    Map<String, Object> objMap = JsonUtil.obj2Map(object);
    Map<String, Object> sortedMap = new TreeMap<>();
    for (Map.Entry<String, Object> entry : objMap.entrySet()) {
      if (!StringUtils.isEmpty(entry.getKey()) && !entry.getKey().equals("hash")) {
        sortedMap.put(entry.getKey(), entry.getValue());
      }
    }
    return sortedMap;
  }

  public static String getSign(Object object, String secretKey) {
    Map<String, Object> sortedMap = objToSortedMap(object);
    StringBuilder sb = new StringBuilder();
    for (Map.Entry<String, Object> entry : sortedMap.entrySet()) {
      sb.append("&").append(entry.getKey()).append("=");
      if (entry.getValue() instanceof List) {
        sb.append(JsonUtil.object2Json(entry.getValue()));
      } else {
        sb.append(entry.getValue().toString());
      }
    }
    String params = sb.toString().replaceFirst("&", "");
    return MD5Util.MD5Encode(params + secretKey);
  }
}
```

---

## 1. 创建玩家

**URL**: `https://{{gmag_api_url}}/player/create`

**请求方式**: POST

**功能描述**: 用于在系统中创建新玩家。

**注意事项**:
- 一个用户名（`playerId`）只能对应一个币种。如果需要给同一个玩家使用多个币种，则应为该玩家创建多个用户名，每个用户名对应一个币种。
- 玩家只有注册成功后，GM-Ag 系统才会接受任何关于此玩家的操作请求。
- 玩家注册完后的账户余额是 0。
- 玩家一旦注册成功后，玩家的相关信息后续暂时无法修改。
- 玩家的 `playerId` 对于每个代理是唯一的，不同的代理可以使用一样的 `playerId`，但是如果是同一个代理的所有下级，建议使用唯一的 `playerId`。

### 请求参数

| 参数名     | 类型       | 必选 | 参数说明                                                                                   |
| ---------- | ---------- | ---- | ------------------------------------------------------------------------------------------ |
| requestId  | String     | 是   | 请求唯一标识                                                                               |
| brandId    | Int        | 是   | 代理标识                                                                                   |
| playerId   | String(24) | 是   | 代理定义的玩家唯一标识。只支持数字、字母和下划线。                                         |
| playerName | String(32) | 否   | 玩家名称                                                                                   |
| currency   | String(4)  | 是   | 玩家的币种编码（参考编码信息）                                                             |
| country    | String(4)  | 是   | 玩家的国家编码（参考编码信息）                                                             |
| language   | String(8)  | 否   | 玩家的语言编码（参考编码信息）                                                             |
| hash       | String     | 是   | 签名（根据签名规则生成）                                                                   |

### 响应参数

| 参数名       | 类型           | 必选 | 参数说明             |
| ------------ | -------------- | ---- | -------------------- |
| requestId    | String         | 是   | 请求唯一标识         |
| playerId     | String(24)     | 是   | 代理定义的玩家唯一标识 |
| playerName   | String(32)     | 否   | 玩家用户名           |
| currency     | String(4)      | 是   | 玩家的币种编码       |
| country      | String(4)      | 否   | 玩家的国家编码       |
| language     | String(8)      | 否   | 玩家的语言编码       |
| balance      | numeric(16, 4) | 否   | 玩家的余额           |
| bonusBalance | numeric(16, 4) | 否   | 玩家的奖金余额       |
| createdAt    | DateTime       | 否   | 玩家创建时间         |
| error        | String         | 是   | 错误码，0 表示成功   |
| message      | String         | 是   | 错误信息             |

### 请求示例

```json
{
  "requestId": "requestId1234",
  "brandId": 1001,
  "playerId": "playerid1",
  "playerName": "playerAAA",
  "currency": "CNY",
  "country": "CN",
  "language": "ZH-CN"
}
```

### 响应示例

**成功响应**:

```json
{
  "requestId": "requestId1234",
  "playerId": "playerid1",
  "playerName": "playerAAA",
  "currency": "CNY",
  "country": "CN",
  "language": "ZH-CN",
  "balance": "0",
  "bonusBalance": "0",
  "createdAt": "2021-04-10 10:12:00.123Z",
  "error": "0",
  "message": "success"
}
```

**错误响应**:

```json
{
  "requestId": "requestId1234",
  "error": "P_02",
  "message": "Invalid hash"
}
```

---

## 2. 获取打开游戏令牌

**URL**: `https://{{gmag_api_url}}/player/getToken`

**请求方式**: POST

**功能描述**: 用于获取启动游戏的玩家令牌(token)，每一个令牌的过期时间是1个小时，但是建议玩家打开游戏的时候每次都获取新的令牌。

### 请求参数

| 参数名    | 类型   | 必选 | 参数说明     |
| --------- | ------ | ---- | ------------ |
| requestId | String | 是   | 请求唯一标识 |
| brandId   | Int    | 是   | 代理标识     |
| playerId  | String(24) | 是   | 代理定义的玩家唯一标识 |
| hash      | String | 是   | 签名         |

### 响应参数

| 参数名    | 类型      | 必选 | 参数说明       |
| --------- | --------- | ---- | -------------- |
| requestId | String    | 是   | 请求唯一标识   |
| token     | String(256) | 是   | 玩家启动游戏的令牌 |
| error     | String    | 是   | 错误码         |
| message   | String    | 是   | 错误信息       |

### 请求示例

```json
{
  "requestId": "requestId1234",
  "brandId": 1001,
  "playerId": "playerid1"
}
```

### 响应示例

**成功响应**:

```json
{
  "requestId": "requestId1234",
  "token": "token12314",
  "error": "0",
  "message": "success"
}
```

**错误响应**:

```json
{
  "requestId": "requestId1234",
  "error": "P_02",
  "message": "Invalid hash"
}
```

---

## 3. 查询玩家余额

**URL**: `https://{{gmag_api_url}}/player/balance`

**请求方式**: POST

**功能描述**: 用于获取玩家的余额。

### 请求参数

| 参数名       | 类型     | 必选 | 参数说明                                 |
| ------------ | -------- | ---- | ---------------------------------------- |
| requestId    | String   | 是   | 请求唯一标识                             |
| brandId     | Int      | 是   | 代理标识                                 |
| playerId    | String(24) | 是   | 玩家的唯一标识                           |
| playerBrandId | Int    | 否   | 玩家直属的代理，上级代理查询下级代理玩家信息时需指定 |
| providerCode | String(32) | 否   | 查询玩家在对应供应商处余额（该参数只在转账类型供应商） |
| hash        | String   | 是   | 签名                                     |

### 响应参数

| 参数名       | 类型           | 必选 | 参数说明           |
| ------------ | -------------- | ---- | ------------------ |
| requestId    | String         | 是   | 请求唯一标识       |
| playerId     | String(24)     | 是   | 玩家的唯一标识     |
| currency     | String(4)      | 是   | 玩家货币           |
| balance      | numeric(16, 4) | 是   | 玩家余额           |
| bonusBalance | numeric(16, 4) | 否   | 玩家奖励余额       |
| timestamp    | DateTime       | 是   | 金额最后更新的时间 |
| error        | String         | 是   | 错误码             |
| message      | String         | 是   | 错误信息           |

### 请求示例

```json
{
  "requestId": "requestId1234",
  "brandId": 1001,
  "playerId": "playerid1",
  "providerCode": "vrg"
}
```

### 响应示例

**成功响应**:

```json
{
  "requestId": "requestId1234",
  "playerId": "playerid1",
  "currency": "CNY",
  "balance": "10000",
  "bonusBalance": "10100",
  "timestamp": "2021-04-10 10:12:00.123Z",
  "error": "0",
  "message": "success"
}
```

**错误响应**:

```json
{
  "requestId": "requestId1234",
  "error": "P_02",
  "message": "Invalid hash"
}
```

---

## 4. 玩家上分（转入游戏）

**URL**: `https://{{gmag_api_url}}/payment/player/deposit`

**请求方式**: POST

**功能描述**: 用于玩家上分，将资金转入游戏账户。

### 请求参数

| 参数名      | 类型        | 必选 | 参数说明                                 |
| ----------- | ----------- | ---- | ---------------------------------------- |
| requestId   | String      | 是   | 请求唯一标识                             |
| brandId     | Int         | 是   | 代理标识                                 |
| playerId    | String(24)  | 是   | 玩家的唯一标识                           |
| currency    | String(4)   | 是   | 玩家的币种编码                           |
| amount      | numeric     | 是   | 上分金额（支持小数点后4位）               |
| extTransId  | String      | 是   | 外部交易号（订单号），必须唯一           |
| providerCode | String(32) | 否   | 供应商代码（转账钱包使用）                |
| hash        | String      | 是   | 签名                                     |

### 响应参数

| 参数名     | 类型        | 必选 | 参数说明       |
| ---------- | ----------- | ---- | -------------- |
| requestId  | String      | 是   | 请求唯一标识   |
| transId    | String      | 是   | 系统交易号     |
| extTransId | String      | 是   | 外部交易号     |
| status     | String      | 是   | 交易状态       |
| balance    | numeric     | 是   | 玩家当前余额   |
| error      | String      | 是   | 错误码         |
| message    | String      | 是   | 错误信息       |

### 请求示例

```json
{
  "requestId": "requestId1234",
  "brandId": 1001,
  "playerId": "playerid1",
  "currency": "CNY",
  "amount": "100.00",
  "extTransId": "order123456789"
}
```

### 响应示例

**成功响应**:

```json
{
  "requestId": "requestId1234",
  "transId": "trans123456",
  "extTransId": "order123456789",
  "status": "approved",
  "balance": "100.00",
  "error": "0",
  "message": "success"
}
```

**错误响应**:

```json
{
  "requestId": "requestId1234",
  "error": "P_02",
  "message": "Invalid hash"
}
```

---

## 5. 玩家下分（转出游戏）

**URL**: `https://{{gmag_api_url}}/payment/player/withdrawal`

**请求方式**: POST

**功能描述**: 用于玩家下分，将资金从游戏账户转出。

### 请求参数

| 参数名      | 类型        | 必选 | 参数说明                                 |
| ----------- | ----------- | ---- | ---------------------------------------- |
| requestId   | String      | 是   | 请求唯一标识                             |
| brandId     | Int         | 是   | 代理标识                                 |
| playerId    | String(24)  | 是   | 玩家的唯一标识                           |
| currency    | String(4)   | 是   | 玩家的币种编码                           |
| amount      | numeric     | 否   | 下分金额（支持小数点后4位）。如果指定 withdrawAll=true，则不需要此参数 |
| extTransId  | String      | 是   | 外部交易号（订单号），必须唯一           |
| withdrawAll | Boolean     | 否   | 是否提取所有余额（true/false）           |
| providerCode | String(32) | 否   | 供应商代码（转账钱包使用）                |
| hash        | String      | 是   | 签名                                     |

### 响应参数

| 参数名     | 类型        | 必选 | 参数说明       |
| ---------- | ----------- | ---- | -------------- |
| requestId  | String      | 是   | 请求唯一标识   |
| transId    | String      | 是   | 系统交易号     |
| extTransId | String      | 是   | 外部交易号     |
| status     | String      | 是   | 交易状态       |
| balance    | numeric     | 是   | 玩家当前余额   |
| amount     | numeric     | 是   | 实际下分金额   |
| error      | String      | 是   | 错误码         |
| message    | String      | 是   | 错误信息       |

### 请求示例

**指定金额下分**:

```json
{
  "requestId": "requestId1234",
  "brandId": 1001,
  "playerId": "playerid1",
  "currency": "CNY",
  "amount": "50.00",
  "extTransId": "order987654321"
}
```

**提取所有余额**:

```json
{
  "requestId": "requestId1234",
  "brandId": 1001,
  "playerId": "playerid1",
  "currency": "CNY",
  "extTransId": "order987654321",
  "withdrawAll": true
}
```

### 响应示例

**成功响应**:

```json
{
  "requestId": "requestId1234",
  "transId": "trans789012",
  "extTransId": "order987654321",
  "status": "approved",
  "balance": "50.00",
  "amount": "50.00",
  "error": "0",
  "message": "success"
}
```

**错误响应**:

```json
{
  "requestId": "requestId1234",
  "error": "P_02",
  "message": "Invalid hash"
}
```

---

## 6. 查询交易信息

**URL**: `https://{{gmag_api_url}}/payment/player/checkTrans`

**请求方式**: POST

**功能描述**: 用于查询交易信息，根据外部交易号查询交易状态。

### 请求参数

| 参数名     | 类型   | 必选 | 参数说明     |
| ---------- | ------ | ---- | ------------ |
| requestId  | String | 是   | 请求唯一标识 |
| brandId    | Int    | 是   | 代理标识     |
| extTransId | String | 是   | 外部交易号   |
| hash       | String | 是   | 签名         |

### 响应参数

| 参数名     | 类型        | 必选 | 参数说明       |
| ---------- | ----------- | ---- | -------------- |
| requestId  | String      | 是   | 请求唯一标识   |
| transId    | String      | 是   | 系统交易号     |
| extTransId | String      | 是   | 外部交易号     |
| playerId   | String      | 是   | 玩家标识       |
| amount     | numeric     | 是   | 交易金额       |
| status     | String      | 是   | 交易状态       |
| type       | String      | 是   | 交易类型（deposit/withdrawal） |
| createdAt  | DateTime    | 是   | 交易创建时间   |
| error      | String      | 是   | 错误码         |
| message    | String      | 是   | 错误信息       |

### 请求示例

```json
{
  "requestId": "requestId1234",
  "brandId": 1001,
  "extTransId": "order123456789"
}
```

### 响应示例

**成功响应**:

```json
{
  "requestId": "requestId1234",
  "transId": "trans123456",
  "extTransId": "order123456789",
  "playerId": "playerid1",
  "amount": "100.00",
  "status": "approved",
  "type": "deposit",
  "createdAt": "2021-04-10 10:12:00.123Z",
  "error": "0",
  "message": "success"
}
```

**错误响应**:

```json
{
  "requestId": "requestId1234",
  "error": "P_02",
  "message": "Invalid hash"
}
```

---

## 7. 编码信息

### 币种编码

常用币种编码：
- `CNY` - 人民币
- `USD` - 美元
- `USDT` - 泰达币
- `EUR` - 欧元
- `GBP` - 英镑
- `JPY` - 日元
- `KRW` - 韩元
- `THB` - 泰铢
- `VND` - 越南盾
- `INR` - 印度卢比

更多币种编码请参考官方文档。

### 国家编码

使用 ISO 3166-1 alpha-2 标准：
- `CN` - 中国
- `US` - 美国
- `GB` - 英国
- `JP` - 日本
- `KR` - 韩国
- `TH` - 泰国
- `VN` - 越南
- `IN` - 印度

更多国家编码请参考官方文档。

### 语言编码

使用 ISO 639-1 标准：
- `ZH-CN` - 简体中文
- `ZH-TW` - 繁体中文
- `EN-US` - 英语（美国）
- `EN-GB` - 英语（英国）
- `JA` - 日语
- `KO` - 韩语
- `TH` - 泰语
- `VI` - 越南语

更多语言编码请参考官方文档。

---

## 8. 错误码说明

| 错误码 | 说明           |
| ------ | -------------- |
| 0      | 成功           |
| P_00   | 服务器错误     |
| P_02   | 签名验证失败   |
| P_03   | 参数错误       |
| P_04   | 玩家不存在     |
| P_05   | 余额不足       |
| P_06   | 交易已存在     |
| P_07   | 交易失败       |

更多错误码请参考官方文档。

---

## 9. 注意事项

1. **请求格式**: 所有请求使用 POST 方法，Content-Type 为 `application/json`
2. **签名验证**: 所有请求必须包含有效的 `hash` 签名
3. **请求ID**: `requestId` 建议使用唯一标识，便于追踪和排查问题
4. **交易号**: `extTransId` 必须唯一，重复的交易号会被拒绝
5. **金额精度**: 金额支持小数点后4位，建议格式化为字符串传递
6. **时区**: 所有时间字段使用 GMT+0 时区
7. **令牌有效期**: 游戏令牌有效期为1小时，建议每次打开游戏时重新获取
8. **接口地址**: 注意区分游戏接口地址和数据接口地址

---

## 10. 对接流程

1. **获取配置信息**: 从 GM-Ag 获取 `brandId`、`secretKey`、`gmag_api_url`、`gmag_game_data_url`
2. **实现签名算法**: 根据提供的代码示例实现签名生成和验证
3. **创建玩家**: 调用创建玩家接口注册新玩家
4. **获取令牌**: 玩家登录时调用获取令牌接口
5. **上分下分**: 根据业务需求调用上分和下分接口
6. **查询余额**: 定期查询玩家余额保持同步
7. **查询交易**: 根据外部交易号查询交易状态

---

## 参考链接

- [GM-Ag API Guide](https://globaltllc.atlassian.net/wiki/spaces/GAG1/pages/1243546629)
- [创建玩家](https://globaltllc.atlassian.net/wiki/spaces/GAG1/pages/1243546629)
- [获取打开游戏令牌](https://globaltllc.atlassian.net/wiki/spaces/GAG1/pages/1243546648)
- [查询玩家余额](https://globaltllc.atlassian.net/wiki/spaces/GAG1/pages/1243546661)
- [玩家上分](https://globaltllc.atlassian.net/wiki/spaces/GAG1/pages/1243546674)
- [玩家下分](https://globaltllc.atlassian.net/wiki/spaces/GAG1/pages/1243546687)
- [查询交易信息](https://globaltllc.atlassian.net/wiki/spaces/GAG1/pages/1243546700)
- [编码信息](https://globaltllc.atlassian.net/wiki/spaces/GAG1/pages/1243513252/Code+Information)
- [加密代码示例](https://globaltllc.atlassian.net/wiki/spaces/GAG1/pages/1243546890/6.)
