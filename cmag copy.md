公共参数



By Henry Zhang

Add a reaction
公共的请求参数
除打开游戏的API（/launcher）外，其它API的请求参数分为两类：位于URL的参数（hash）、位于请求主体的Json参数。

1. 位于URL参数：hash
为了验证请求，每个请求URL的末尾必须添加参数hash，例如：

https://{{gmag_api_url}}/player/create?hash={{xxx}}。

hash生成方式如下：

请求中的所有参数，需要根据”参数名=参数值“的格式，按首字符字典顺序(ascii 值大小)排序。若遇到相同首字符，则判断第二个字符，以此类推。字符串需要以“参数名1=参数值1&参数名2=参数值2&….&参数名N=参数值N”的规则拼接，末尾拼接上secretKey后进行MD5运算。如果参数值是数组，该数组应先转换为Json形式。注意，参数名=参数值之间使用字符”&“连接。(可选)

函数md5调用举例：

md5(‘name1=value1&name2=value2secretKey’)。

关于详细的hash生成示例，请参见
加密代码示例。

参数名

必选

参数说明

参数名

必选

参数说明

hash

是

md5(key1=value1&key2=value2&key3=value3secretKey)

2. 位于请求主体的Json参数
下表中的参数为每个API请求主体（body of the request）中必须添加的参数。

参数名

类型

必选

参数说明

requestId

String (64)

是

每个请求的唯一标识，用于定位GM-Ag与代理通信中出现的问题。

brandId

Int

是

代理的唯一标识。

公共的响应参数
所有响应的状态码均为200，响应中的任何错误都由参数‘error’和‘message’进行说明。

参数名

类型

必选

参数说明

requestId

String (64)

是 

每个请求的唯一标识，用于定位GM-Ag与代理通信中出现的问题。

error

String (8)

是 

响应的错误编号，0表示操作成功。

message

String (512)

否 

消息内容为success，或其他具体错误信息。

关于错误码及其消息，请参考
错误编码
UNDEFINED
。

幂等请求
代理的钱包系统必须实现幂等操作，以处理同一交易请求被多次发送的情况。当出现网络故障，或者遇到异常的错误时，对于同一个押注操作，GM-Ag 系统可能发送多次扣款请求，这些请求会使用相同的 roundId 和 transactionId，在代理的钱包系统中，多次相同的请求只能执行一次扣款操作。

重试的扣款、存款、取消请求，有可能在首次请求的几个小时甚至几天后再次发送给代理方。即便游戏会话（Session）已经过期，或游戏已经结束，代理的钱包系统也不能拒绝GM-Ag再次发送相同的请求。对于已经成功的操作，也要允许GM-Ag再次发送相同参数值的请求。

验证玩家身份



By Henry Zhang

Add a reaction
URl：https://{{brand_url}}/auth?hash={{xxx}}。

方式：POST。

目的：在游戏启动过程中，GM-Ag 系统需要验证接收到的玩家令牌（token）。如果令牌有效，代理方应该返回玩家的详细信息，如币种和国家。如果该玩家在 GM-Ag 系统中不存在，GM-Ag 将使用玩家信息新建该玩家。成功启动游戏后，进入押注和赢取的流程，如下图所示。


请求
参数名

类型

必选

参数说明

token

String (255)

是

玩家启动游戏的令牌。代理方通过/launcher发送给GM-Ag。

ip

String (32)

否

玩家的IP地址。

响应
参数名

类型

必选

参数说明

参数名

类型

必选

参数说明

playerId

String (20)

是

代理定义的玩家唯一标识。只支持数字，字母和下划线。

playerName

String (32)

否

玩家名称。

playerSessionId

String (63)

是

该游戏的会话标识，用于接下来的游戏操作请求。

currency

String (4)

是

玩家的币种编码。

country

String (4)

是

玩家的国家编码。

balance

numeric (16, 4)

是

玩家的余额。

group

String(16)

      否

玩家所属的组。当该字段未初始化时，它将触发将玩家添加到对应的组。如果提供了新值，则先前的值将被覆盖。

testAccount

Boolean

      否

true - 玩家被创建为测试帐户。该标志是不可逆转的，只能在玩家创建期间设置。 

false - 玩家被创建为普通帐户。这是默认值，不需要显式设置。

关于币种编码的详细信息，请参考 
币种编码
UNDEFINED
。

关于国家编码，请参考 
国家 ISO 编码
UNDEFINED
。

请求例子


{
    "requestId": "3d7872612319a11213211",
    "brandId": 1001,
    "token": "token1767213",
    "ip": "127.0.0.1"
}
响应例子


//success
{
    "requestId": "3d7872612319a11213211",
    "playerSessionId": "custSessionId1767213",
    "playerId": "10001",
    "playerName": "ABFXET",
    "currency": "CNY",
    "balance": 10000,
    "country": "CN",
    "group": "group1",
    "error": "0",
    "message": "success",
    "testAccount": false
}
//error
{
    "requestId": "3d7872612319a11213211",
    "error": "P_01",
    "message": "Invalid request. This error can be returned if required parameters are missing or they have incorrect format."
}

获取玩家余额



By Henry Zhang

Add a reaction
URl：https://{{brand_url}}/balance?hash={{xxx}}。

方式：POST。

目的：从代理的钱包系统获取玩家的余额。

请求
参数名

类型

必选

参数说明

playerId

String (20)

是

代理定义的玩家唯一标识。

playerSessionId

String (32)

是

/auth 返回的会话唯一标识。

gameCode

String (32)

否

玩家正在游戏的游戏代码。

响应
参数名

类型

必选

参数说明

currency

String (4)

是

玩家的币种编码。

balance

numeric (16, 4)

是

玩家的余额。

bonusBalance

numeric (16, 4)

否

玩家的奖金余额。

country

String (4)

否

玩家的国家编码。

timestamp

DateTime

否

获取余额的时间。

请求例子


{
    "requestId": "requestId1234",
    "brandId": 1001,
    "playerId": "19823",
    "playerSessionId": "custSessionId12341234",
    "gameCode": "bfb"
}
响应例子


//success
{
    "requestId": "requestId1234",
    "currency": "CNY",
    "balance": "10000",
    "bonusBalance": "10100",
    "error": "0",
    "message": "success"
}
//error
{
    "requestId": "requestId1234",
    "error": "P_08",
    "message": "Invalid session"
}

交易



By Henry Zhang

2 min

Add a reaction
URl：https://{{brand_url}}/transaction?hash={{xxx}}。

方式：POST。

目的：当玩家游戏时，用于改变代理钱包系统中的玩家余额。

请求
参数名

类型

必选

参数说明

playerId

String (20)

是

代理定义的玩家唯一标识。

playerSessionId

String (32)

是

游戏的会话。

gameCode

String (32)

是

游戏的编码。

trans

transArray

是

关于改变余额的交易信息的数组，请参考下面的交易信息的详细说明。一个交易（trans）可以包含多个动作，只有全部动作都成功后，该交易才成功完成。一旦它的某一个动作失败，此交易失败，并且回滚此交易已经完成的全部动作，将玩家的余额恢复到交易前的状态。

endSession

Int

否

默认值 = 0, 表明该游戏会话是否已经结束。当玩家结束一个游戏时，该值被回调。

detailUrl

String (1024)

否

说明一个回合的详细游戏信息的链接。

bonusChanges

bonusChangesArray

       否

奖金变化详情数组

providerCode

String(16)

       是

游戏供应商编码

gameType

String(16)

       是

游戏类型slots,table,live,arcade,sport,esport,lotto, poker,bingo, unknown(游戏未被识别)

transArray数组元素
键名

类型

必选

参数说明

seq

int

是

操作动作的顺序。

transId

String (64)

是

交易的唯一标识。

如果相同的transId已经处理过，则应返回与上次相同的结果。不应发生新的交易或钱包金额变化。

referenceId

String (64)

否

当 transType = ‘cancel’，此值为要取消的交易的transId。

amount

numeric (16, 4)

是

此操作的金额。注：由于某些游戏供应商允许重复结算，所以当transType = 'amend' 时，此金额可能小于0，请确保能正常操作。

transType

String (16)

是

交易类型，取值为：bet、transIn (转账到游戏)、win、transOut (转账到玩家)、cancel、amend(游戏过程中金额调整，用于体育，捕鱼，某些平台的真人游戏等，比如: 同一局游戏中回退某一部分金额，amend时交易金额amount有可能是负数，负数时需要扣除玩家金额，正数时需要增加玩家余额)

transTime

DateTime

是

操作的时间，格式："yyyy-mm-dd hh24:mi:ss.SSS"，时区为GMT+0。

roundId

String (127)

是

回合的唯一标识。

roundType

String (16)

是

回合的类型，取值为：normal、freegame、bonusgame。

endRound

int

否

回合是否已经完成。1 -已完成，0-未完成， 默认为0

desc

String (1024)

否

操作的描述。

jpc

numeric (16, 4)

否

奖金池的贡献金额。

jpw

numeric (16, 4)

否

奖金池的赢取金额。

jpDetails

jackpotArray

否

奖金池赢取的详细信息。

validBet

numeric (16, 4)

否

当transType = ‘transOut’，有效押注的金额。

validWin

numeric (16, 4)

否

当transType = ‘transOut’，有效赢取的金额。

additionalData

Json

否

额外的数据。

jackpotArray 数组元素
键名

类型

必选

参数说明

id

String (8)

是

奖金池赢取的唯一标识。

name

String (512)

否

奖金池的名称。

type

String (32)

否

类型，取值为：Daily, Hourly。

contribution

numeric (16, 4)

否

奖金池的贡献金额。

win

numeric (16, 4)

否

奖金池的赢取金额。

bonusChangesArray 数组元素
Name

Type

Required

Description

bonusCode

String(63)

        是

奖金编码唯一标识，在给玩家添加奖金接口返回。

count

Int

        是

奖金变化数量

value

numeric (16, 4)

        否

奖金的价值

响应
参数名

类型

必选

参数说明

currency

String (4)

是

玩家的币种编码。

balance

numeric (16, 4)

是

玩家的余额。

bonusBalance

numeric (16, 4)

否

玩家的奖金余额。

 请求例子


//bet
{
    "requestId": "requestId1234",
    "brandId": 1001,
    "playerId": "19823",
    "playerSessionId": "custSessionId12341234",
    "gameCode": "bfb",
    "endSession": 0,
    "providerCode": "pt",
    "gameType": "slots",
    "trans": [
         {
            "seq": 1,
            "transId": "unique_bet1",
            "amount": 1000,
            "transType": "bet",
            "transTime": " 2021-01-12 19:56:32.123",
            "roundId": "roundid12341",
            "roundType": "normal",
            "desc": "desc",
            "jpc": 10
        }
    ]
}
//bet+bet
{
    "requestId": "requestId1234",
    "brandId": 1001,
    "playerId": "19823",
    "playerSessionId": "custSessionId12341234",
    "gameCode": "bfb",
    "endSession": 0,
    "providerCode": "pt",
    "gameType": "slots",
    "trans": [
         {
            "seq": 1,
            "transId": "unique_bet1",
            "amount": 1000,
            "transType": "bet",
            "transTime": " 2021-01-12 19:56:32.123",
            "roundId": "roundid12341",
            "roundType": "normal",
            "desc": "desc",
            "jpc": 10
        },
        {
            "seq": 2,
            "transId": "unique_bet2",
            "amount": 2000,
            "transType": "bet",
            "transTime": " 2021-01-12 19:56:33.123",
            "roundId": "roundid12341",
            "roundType": "normal",
            "desc": "desc",
            "jpc": 20
        }
    ]
}
//bet with bonus
{
    "requestId": "requestId1234",
    "brandId": 1001,
    "playerId": "19823",
    "playerSessionId": "custSessionId12341234",
    "gameCode": "bfb",
    "endSession": 0,
    "providerCode": "pt",
    "gameType": "slots",
    "trans": [
        {
            "seq": 1,
            "transId": "unique_bet1",
            "amount": 1000,
            "transType": "bet",
            "transTime": " 2021-01-12 19:56:32.123",
            "roundId": "roundid12341",
            "roundType": "bonusgame",
            "desc": "desc",
            "jpc": 10
        }
    ],
    "bonusChanges": [
        {
            "bonusCode": "BG-123XDEAFRR3",
            "count": 1,
            "value": 5
        }
    ]
}
//win
{
    "requestId": "requestId1234",
    "brandId": 1001,
    "playerId": "19823",
    "playerSessionId": "custSessionId12341234",
    "gameCode": "bfb",
    "endSession": 1,
    "detailUrl": "https://detailedresult.provider_url.com/getgamehistoryurl.php? &username=Player_TEST& token=92b9fee7af7fc246f56c45cb &showFullHistoryPerBet=false ",
    "providerCode": "pt",
    "gameType": "slots",
    "trans": [
        {
            "seq": 1,
            "transId": "unique_win1",
            "amount": 1000,
            "transType": "win",
            "transTime": "2021-01-12 19:56:32.123",
            "roundId": "roundid12341",
            "roundType": "normal",
            "desc": "desc",
            "endRound": 1,
            "jpc": 10,
            "jpw": 100,
            "jpDetails":  [
                {   "id": "id1",
                    "name": "name",
                    "type": "Daily"
                },
                {
                    "id": "id1",
                    "name": "name",
                    "type": "Daily"
                }
              ]
        }
    ]
}
//bet+win
{
    "requestId": "requestId1234",
    "brandId": 1001,
    "playerId": "19823",
    "playerSessionId": "custSessionId12341234",
    "gameCode": "bfb",
    "endSession": 1,
    "detailUrl": "https://detailedresult.provider_url.com/getgamehistoryurl.php? &username=Player_TEST& token=92b9fee7af7fc246f56c45cb &showFullHistoryPerBet=false ",
    "providerCode": "pt",
    "gameType": "slots",
    "trans": [
        {
            "seq": 1,
            "transId": "unique_bet1",
            "amount": 1000,
            "transType": "bet",
            "transTime": "2021-01-12 19:56:32.123",
            "roundId": "roundid12341",
            "roundType": "normal",
            "desc": "desc",
            "jpc": 10
        },
        {
            "seq": 2,
            "transId": "unique_wub1",
            "amount": 1000,
            "transType": "win",
            "transTime": "2021-01-12 19:56:32.123",
            "roundId": "roundid12341",
            "roundType": "normal",
            "desc": "desc",
            "endRound": 1,
            "jpc": 10,
            "jpw": 100,
            "jpDetails": [
                {
                    "id": "id1",
                    "name": "name",
                    "type": "Daily"
                },
                {
                    "id": "id2",
                    "name": "name2",
                    "type": "Hourly"
                }
            ]
        }
    ]
}
响应例子


//success
{
    "requestId": "requestId1234", 
    "error": "0",
    "message": "success",
    "currency": "CNY",
    "balance": 10000,
    "bonusBalance": 10100
}
//error T_01, 当余额不足时请返回玩家当前余额
{
    "requestId": "requestId1234",
    "error": "T_01",
    "message": "Player Insufficient Funds",
    "balance": 999,
    "bonusBalance": 0
}
//error
{
    "requestId": "requestId1234",
    "error": "P_02",
    "message": "Invalid hash"
}

发放玩家奖金



By Henry Zhang

1 min

Add a reaction
URl：https://{{brand_url}}/payUp?hash={{xxx}}。

方式：POST。

目的：当发放奖金时，改变玩家在代理钱包系统中的余额，应用场景包括：发放玩家奖金、奖金池奖金、活动奖金、排行榜。

请求
参数名

类型

必选

参数说明

playerId

String (20)

是

代理定义的玩家唯一标识。

transId

String (64)

是

交易的唯一标识。

type

String (16)

是

类型：bonus、jackpot、promo、leaderboard。

referenceId

String (64)

否

发放奖金操作的相关标识。

referenceName

String (1024)

否

发放奖金操作的相关参考名称。

providerCode

String (16)

       是

此请求对应的供应商

currency

String (4)

是

玩家的币种编码。

amount

numeric (16, 4)

是

发放的金额。

transTime

DateTime

是

操作的时间，格式为 "yyyy-mm-dd hh24:mi:ss.SSS", 时区为GMT+0。

desc

String (1024)

否

描述信息。

additionalData

Json

否

额外数据。

响应
参数名

类型

必选

参数说明

参数名

类型

必选

参数说明

currency

String (4)

是

玩家的币种编码。

balance

numeric (16, 4)

是

玩家的余额。

bonusBalance

numeric (16, 4)

否

玩家的奖金余额。

请求例子


{
    "requestId": "requestId1234",
    "brandId": 1001,
    "playerId": "19823",
    "transId": "transid",
    "referenceId": "ptplus lotto id",
    "currency": "CNY",
    "amount": 1000,
    "type": "bonus",
    "transTime": "2021-01-12 19:56:32.123",
    "desc": "lotto winning"
}
响应例子


//success
{
    "requestId": "requestId1234",
    "currency": "CNY",
    "balance": "10000",
    "bonusBalance": "10100",
    "error": "0",
    "message": "success"
}
//error
{
    "requestId": "requestId1234",
    "error": "P_04",
    "message": "player not found"
}