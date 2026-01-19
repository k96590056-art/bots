打开游戏


By Henry Zhang

Add a reaction
代理使用此游戏启动API，可以打开GM-Ag系统内各游戏供应商的游戏。

打开游戏流程 
步骤 1 – 3，玩家登录代理的网站，点击某游戏。

步骤 4 – 5，代理生成一个启动游戏令牌（token）。

步骤 6，代理使用令牌（token）调用 /launcher，请求打开某游戏。

步骤 7，GM-Ag 调用 /auth，请求代理验证令牌（token）是否有效。

步骤 8，代理验证令牌的有效性，如果有效，返回玩家的详细信息给GM-Ag，否则返回令牌无效。

步骤 9 – 10，GM-Ag 给玩家返回有效内容，玩家进行游戏。


方式一: 拼装游戏链接(直接进入游戏)
URI: https://{{gmag_game_launch_url}}/launcher.

方式: GET.

目的：代理使用自己系统生成的游戏令牌和下列参数，生成指定游戏的链接，用于直接在浏览器访问。

请求
参数名

类型

必选

参数说明

gameCode 

String(32)

是 

代表游戏的编码。

token

String(255)

是 

启动游戏的令牌，用于验证玩家的身份是否合法。

platform 

String(16)

是 

打开游戏的设备平台 (web, mobile, download) 。

language 

String(8)

是 

游戏屏幕显示语言。

tableAlias 

String(32)

否 

用于真人游戏，指定游戏打开的桌牌号码，而不是只进入大厅。

playerId 

String(20)

是 

玩家的唯一标识。

brandId 

Int

是 

代理的唯一标识。

mode 

Int

否 

指定玩家打开方式：真钱、免费试玩。默认为真钱。0 = 免费试玩, 1 = 真钱, 2 = 游客（适用于体育类平台，ibc, betby）

backUrl 

String(1024)

否 

打开游戏失败时，重定向的大厅链接。（在发送之前需要对URL进行转译）

cashierUrl 

String(1024)

否 

代理网站的玩家存款页面。（在发送之前需要对URL进行转译）

currency

String(4)

是 

新增参数(12/12/2023)
在游戏中使用的货币

hash

String(34)

否 

新增参数(12/03/2025)

该属性用于防止玩家手动更改游戏代码进入游戏. 

hash 生成规则MD5(brandId+playerId+gameCode+SecretKey)

如果hash 不匹配则返回 禁止切换游戏 错误提示

语言编码，请参见
语言编码
UNDEFINED
。

响应
1. 成功的响应

当请求中的参数全部正确时，游戏内容被发送给玩家。

2. 失败的响应

如果参数错误或系统错误，游戏被重定向到代理指定的‘backUrl’网址。同时，错误码（error）和错误信息（message）将附在重定向URL的末尾，用以说明错误原因。

例如, 当请求中的 ‘backUrl’ 为：

https://www.operator-back-url.com，

失败响应的重定向链接为: 

https://www.operator-back-url.com?error={{code}}&message={{error_message}}。

请求例子


https://{{gmag_game_launch_url}}/launcher?gameCode=bfb&token=xxxx&platform=web&
  language=en&playerId=1234&brandId=101&mode=0&backUrl=backUrl&cashierUrl=cashierUrl
代理向 GM-Ag 发送 /launcher 的请求后，代理开发的API /auth 将会被GM-Ag 调用，以验证代理发送的令牌是否有效。有关 /auth 的信息，请参见
验证玩家身份
 。

 

方式二: 获取进入游戏链接
URI: https://{{gmag_game_launch_url}}/launcher/getUrl

方式: POST.

目的: 用户获取进入游戏的链接地址。

请求
请求使用的 content type 为 application/json

参数名

类型

必选

参数说明

参数名

类型

必选

参数说明

gameCode 

String(32)

是 

代表游戏的编码。

token

String(255)

是 

启动游戏的令牌，用于验证玩家的身份是否合法。

platform 

String(16)

是 

打开游戏的设备平台 (web, mobile, download) 。

language 

String(8)

是 

游戏屏幕显示语言。

tableAlias 

String(32)

否 

用于真人游戏，指定游戏打开的桌牌号码，而不是只进入大厅。

playerId 

String(20)

是 

玩家的唯一标识。

brandId 

Int

是 

代理的唯一标识。

mode 

Int

否 

指定玩家打开方式：真钱、免费试玩。默认为真钱。0 = 免费试玩, 1 = 真钱, 2 = 游客（适用于体育类平台，ibc, betby）

backUrl 

String(1024)

否 

打开游戏失败时，重定向的大厅链接。（在发送之前需要对URL进行转译）

cashierUrl 

String(1024)

否 

代理网站的玩家存款页面。（在发送之前需要对URL进行转译）

currency

String(4)

是 

新增参数(12/12/2023)
在游戏中使用的货币

hash

String(34)

 否

新增参数(12/03/2025)

该属性用于防止玩家手动更改游戏代码进入游戏.

hash 生成规则MD5(brandId+playerId+gameCode+SecretKey)

如果hash 不匹配则返回 禁止切换游戏 错误提示

 

语言编码，请参见
语言编码
UNDEFINED
。

响应
响应使用的 content type 为 text/plain;charset=UTF-8.

 

成功的响应

返回进入游戏的链接文本

失败的响应

如果 backUrl 参数不为空那么返回到该地址否则使用默认地址 并加入error 和 message 参数.

请求例子


{
    "gameCode":"lobby",
    "token":"4MDljZWZiNTdhMWM2M3edcSJ90192",
    "platform":"web",
    "language":"en",
    "playerId":"1003233",
    "brandId":"100",
    "mode":"1",
    "backUrl":"http://google.com"
}
响应例子


//success
https://sg-server.ggravityportal.com/GameLauncher/Loader.aspx?GameCategory=Slots&GameName=Samurai&Token=stst173015908254861110274786&PortalName=goldenmatrix&ReturnUrl=https://bof.gmgoldmtn.com&Lang=en
//error
http%3A%2F%2Fgoogle.com?error=P_19&message=Player info not matched 'PlayerId: qs7kDbeJ != 1003'




补充文档说明
拉取游戏交易信息



By Henry Zhang

1 min

Add a reaction
URl: https://{{gmag_game_data_url}}/history/gameTrans?hash={{xxx}}。

方式：POST。

目的：用于根据交易产生时间获取玩家游戏中发生的交易记录，拉取的最长时间段为15分钟。

代理调用 gameTrans 命令的时长最小单位为分钟。在 GM-Ag 系统中，最近15天的游戏交易记录为可访问记录，超过30天的记录不能被拉取到。在系统对接过程中，以上规定需要再次确认。

在API的响应中，游戏交易的最大条数为10,000条。

代理保存的交易条数应该与 gameTrans 响应中的参数 total 的值始终保持一致。为了保证所有交易数据的准确性，代理可以对同一交易进行多次拉取。

拉取游戏交易信息，必须使用专用API域名gmag_game_data_url。关于实际名称，请查看GM-Ag发送的开户信息相关内容。

请求
参数名

类型

必选

参数说明

startTime

String(32)

是

GMT+0的日期和时间
格式: YYYY-MM-DD HH:mm:00
请注意，秒数值固定为00，任何非零秒数会被转换为00。

endTime

String(32)

是

GMT+0的日期和时间
格式: YYYY-MM-DD HH:mm:00
请注意，秒数值固定为00，任何非零秒数会被转换为00。
endTime - startTime 必须小于 15 分钟。

size

Int

否

每页交易的条数，默认值 = 5000。

page

Int

否

页码值，默认值 = 1。

playerId

String(24)

否

玩家的唯一标识，用于获取某个玩家的交易信息。

showAll

Int

否

1 - 包含子代理，0 - 不包含子代理。默认为0。

providerCode

String(32)

       否

游戏供应商唯一标识，用户获取某个供应商的交易信息

currency

String(8)

       否

根据玩家货币获取交易信息

响应
参数名

类型

必选

参数说明

total

Int

是

游戏交易的总条数

pages

Int

是

交易的总页数

size

Int

是

每页交易的条数

current

Int

否

当前的页码

records

Array

是

gameTrans数据的数组，可以为空。

GameTrans数组元素
参数名

类型

必选

参数说明

transId

String(64)

是

游戏交易的唯一标识

playerId

String(24)

是

玩家的唯一标识

brandId

bigInt

是

代理的唯一标识

providerCode

String(8)

是

游戏供应商的编码

sessionId

String(32)

是

游戏会话的唯一标识

roundId

String(127)

是

游戏回合的唯一标识

gameCode

String(32)

是

交易的游戏代码

currency

String(8)

是

交易的币种编码

platform

String(16)

是

启动游戏的玩家设备平台（web, mobile, download）

amount

numeric(16, 4)

是

交易的金额(包含奖池赢取金额jpw)

balanceBefore

numeric(16, 4)

是

交易发生前，玩家的余额

balanceAfter

numeric(16, 4)

是

交易发生后，玩家的余额

transTime

DateTime

是

交易操作的时间

transType

String(16)

是

交易的类型（bet, transIn, win, transOut, cancel。transIn = 从玩家转账到游戏，transOut = 从游戏转账到玩家）

referenceId

String(64)

否

当transType = ‘cancel’时，该值为对应上一条bet的transId

bonusBalanceEnd

numeric(16, 4)

否

游戏交易完成时，玩家的奖金余额

validBet

numeric(16, 4)

否

有效投注，当transType = ‘transOut’时使用

validWin

numeric(16, 4)

否

有效盈利，当transType = ‘transOut’时使用

jpc

numeric(16, 4)

否

累积奖金池的贡献

jpw

numeric(16, 4)

否

当transType = ‘win’，奖金池赢取的金额

jpDetails

text

否

奖金池赢取的详细信息，如id

rake

numeric(16, 4)

否

抽水的金额

roundType

String(16)

是

回合的类型（normal, freegame, bonusgame）

roundStatus

String(8)

是

回合的状态（active, end）

additionalData

text

否

交易的额外参数及参数值

description

String(512)

否

交易的描述信息

detailUrl

String(2048)

否

游戏的详情的链接，有些平台暂时无法提供

gameType

String(16)

        是

slots,table,live,arcade,sport,esport,lotto, poker,bingo, unknown(gameCode无法识别时)

createdAt

DateTime

       是

创建时间

请求例子


{
    "requestId": "requestId1234",
    "brandId": "1001",
    "startTime": "2021-06-10 10:00:00",
    "endTime": "2021-06-10 10:05:00",
    "size": 1000,
    "page": 1,
}
响应例子


//success
{
    "requestId":"requestId1234",
    "error":"0",
    "message":"success",
    "total":2200,
    "size":1000,
    "current":1,
    "pages":2,
    "records":[
        {
            {
            "transId":"pt4509924",
            "sessionId":"06d3231d9a524d2290d0e8d809cdd9be",
            "playerId":"SDFDF",
            "currency":"IDR",
            "providerCode":"pt",
            "brandId":214,
            "gameCode":"gpas_pluck_pop",
            "roundId":"gpas_FyVN_Dw7-Qvjfdd7n4Lg",
            "roundType":"normal",
            "roundStatus":"end",
            "transType":"win",
            "transTime":"2021-06-10 10:01:02",
            "createdAt": "2021-08-11 15:48:24.038",
            "amount":1000.0000,
            "balanceBefore":143421.7900,
            "balanceAfter":144421.7900,
            "platform":"web",
            "bonusBalanceEnd":0.0000,
            "validBet":0.0000,
            "validWin":0.0000,
            "jpc":0.0000,
            "jpw":0.0000,
            "rake":0.0000,
            "gameType": "slots",
            "detailUrl":"https://cashier.gmgiantgold.com/getgamehistoryurl.php?casino=1club&username=3MPL_AAAAAAA003K&ngscode=1989542&remotesessionenddate=2021-08-04+05%3A03%3A24&token=e1cf86c9be08c693e611101bc10668e33b9636e8daa16a26427528cb45894ed1&language=EN&showFullHistoryPerBet=false"
         },
         {
            "transId":"pt4509923"
            "sessionId":"06d3231d9a524d2290d0e8d809cdd9be",
            "playerId":"SDFDF",
            "currency":"IDR",
            "providerCode":"pt",
            "brandId":214,
            "gameCode":"gpas_pluck_pop",
            "requestId":"7be1089e-1eba-4484-8c4a-4009f42cdfca",
            "roundId":"gpas_FyVN_Dw7-Qvjfdd7n4Lg",
            "roundType":"normal",
            "roundStatus":"active",
            "transType":"bet",
            "transTime":"2021-06-10 10:03:02.000",
            "createdAt": "2021-08-11 15:48:24.038",
            "amount":2500.0000,
            "balanceBefore":145921.7900,
            "balanceAfter":143421.7900,
            "platform":"web",
            "bonusBalanceEnd":0.0000,
            "validBet":0.0000,
            "validWin":0.0000,
            "jpc":0.0000,
            "jpw":0.0000,
            "rake":0.0000,
            "gameType": "slots"
         }
    ]
}
//error
{
   "requestId": "requestId1234",
   "error": "P_02",
   "message": "Invalid hash",
}

拉取游戏历史



By Henry Zhang

2 min

Add a reaction
URl: https://{{gmag_game_data_url}}/history/game?hash={{xxx}}。

方式：POST。

目的：用于根据游戏结算时间获取玩家已经结算了的游戏历史数据，如果玩家某一局游戏未结算，将无法拉取到，拉取的最长时间段为30分钟。

代理调用 gameHistory 命令的时长最小单位为分钟。在 GM-Ag 系统中，最近30天的游戏记录为可访问记录，超过30天的记录不能被拉取到。

在API的响应中，游戏历史的最大条数为10,000条。

拉取游戏历史，必须使用专用API域名gmag_game_data_url。关于实际名称，请查看GM-Ag发送的开户信息相关内容。

拉取到的数据如果之前已经拉到，请根据roundid更新之前的数据，每个roundid只保留一条数据。

请求
参数名

类型

必选

参数说明

startTime

String(32)

是

GMT+0的日期和时间
格式: YYYY-MM-DD HH:mm:00
请注意，秒数值固定为00，任何非零秒数必须转换为00。

endTime

String(32)

是

GMT+0的日期和时间
格式: YYYY-MM-DD HH:mm:00
请注意，秒数值固定为00，任何非零秒数必须转换为00。
endTime - startTime 必须小于 30 分钟。

size

Int

否

每页游戏数据的条数，默认值 = 5000。最大10000

page

Int

否

页码值，默认值 = 1。

showAll

int

       否

1 - 包含子代理，0 - 不包含子代理。 默认为0

roundId

String(64)

否

回合的标识，用于获取某个游戏回合的游戏记录。

playerId

String(24)

       否

用于获取某个玩家的游戏历史记录

providerCode

String(24)

       否

用于获取某个游戏供应商的游戏历史记录

currency

String(8)

       否

用于获取某个货币的游戏历史记录

gameCode

String(63)

       否

用于获取某个游戏的游戏历史记录

响应
参数名

类型

必选

参数说明

total

Int

是

游戏记录的总条数

pages

Int

是

记录的总页数

size

Int

是

每页游戏记录的条数

current

Int

否

当前的页码

records

Array

是

GameHistory数据的数组，可以为空。

GameHistory数组元素
参数名

类型

必选

参数说明

brandId

bigInt

是

代理的唯一标识

playerId

String(24)

是

玩家的唯一标识

providerCode

String(32)

是

游戏供应商的编码

sessionId

String(32)

是

游戏会话的唯一标识

roundId

String(127)

是

游戏回合的唯一标识

gameCode

String(32)

是

游戏记录的游戏代码

currency

String(8)

是

游戏记录的币种编码

platform

String(16)

否

启动游戏的玩家设备平台（web, mobile, download）

bets

numeric(16, 4)

是

押注的金额

wins

numeric(16, 4)

是

赢取的金额

cancels

numeric(16, 4)

是

取消的金额

transIn

numeric(16, 4)

否

转账到游戏的金额

transOut

numeric(16, 4)

否

转账到玩家的金额

balanceEnd

numeric(16, 4)

是

回合完成后的玩家余额

bonusBalanceEnd

numeric(16, 4)

是

回合完成后的奖金账号余额

rake

numeric(16, 4)

否

抽水的金额

startTime

DateTime

是

回合开始的时间

endTime

DateTime

是

回合结束的时间

jpc

numeric(16, 4)

否

累积奖金池的贡献

jpw

numeric(16, 4)

否

当transType = ‘win’，奖金池赢取的金额

jpDetails

text

否

奖金池赢取的详细信息，如id

roundType

String(16)

是

回合的类型（normal, freegame, bonusgame）

roundStatus

String(8)

是

回合的状态

additionalData

text

否

游戏记录的额外参数及参数值

detailUrl

String(1024)

否

游戏的详情的链接，有些平台暂时无法提供此链接

gameType

String(16)

         是

slots,table,live,arcade,sport,esport,lotto, poker,bingo, unknown(gameCode无法识别时)

createdAt

DateTime

        是

创建时间

请求例子


{
    "requestId": "requestId1234",
    "brandId": "1001",
    "startTime": "2021-06-10 10:00:00",
    "endTime": "2021-06-10 10:05:00",
    "size": 1000,
    "page": 1,
}
响应例子


//success
{
    "requestId": "request5282",
    "error": "0",
    "message": "SUCCESS",
    "total": 2,
    "current": 1,
    "size": 5000,
    "pages": 1,
    "records": [
        {
            "playerId": "palyerid1",
            "brandId": 1001,
            "providerCode": "pt",
            "sessionId": "03d35793716348cabf5a202ef823a86f",
            "roundId": "583067326075",
            "roundType": "normal",
            "roundStatus": "end",
            "gameCode": "bfb",
            "currency": "CNY",
            "platform": "web",
            "bets": 5.0000,
            "wins": 10.0000,
            "cancels": 0.0000,
            "transIn": 0.0000,
            "transOut": 0.0000,
            "balanceEnd": 2652.0500,
            "bonusBalanceEnd": 0.0000,
            "rake": 0.0000,
            "startTime": "2021-08-11 15:48:23.745",
            "endTime": "2021-08-11 15:48:24.038",
            "createdAt": "2021-08-11 15:48:24.038",
            "jpc": 0.1235,
            "jpw": 5.0000,
            "jpDetails": [
                {
                    "id": "123124",
                    "contribution": 0.12345,
                    "win": 0.12345
                }
            ],
            "gameType": "slots",
            "detailUrl": "https://extstg3-cashier01.ptstaging.eu/getgamehistory.php?ThisIsJustAutomatedTestDataOK"
        },
        {
            "playerId": "palyerid1",
            "brandId": 1001,
            "providerCode": "pt",
            "sessionId": "03d35793716348cabf5a202ef823a86f",
            "roundId": "398521759399",
            "roundType": "normal",
            "roundStatus": "end",
            "gameCode": "bfb",
            "currency": "CNY",
            "platform": "web",
            "bets": 5.0000,
            "wins": 10.0000,
            "cancels": 0.0000,
            "transIn": 0.0000,
            "transOut": 0.0000,
            "balanceEnd": 2657.0500,
            "bonusBalanceEnd": 0.0000,
            "rake": 0.0000,
            "startTime": "2021-08-11 15:48:24.342",
            "endTime": "2021-08-11 15:48:24.870",
            "createdAt": "2021-08-11 15:48:24.038",
            "jpc": 0.0000,
            "jpw": 0.0000,
            "gameType": "slots",
            "detailUrl": "https://extstg3-cashier01.ptstaging.eu/getgamehistory.php?ThisIsJustAutomatedTestDataOK"
        }
    ]
}
//error
{
   "requestId": "requestId1234",
   "error": "P_02",
   "message": "Invalid hash",
}

拉取游戏历史



By Henry Zhang

2 min

Add a reaction
URl: https://{{gmag_game_data_url}}/history/game?hash={{xxx}}。

方式：POST。

目的：用于根据游戏结算时间获取玩家已经结算了的游戏历史数据，如果玩家某一局游戏未结算，将无法拉取到，拉取的最长时间段为30分钟。

代理调用 gameHistory 命令的时长最小单位为分钟。在 GM-Ag 系统中，最近30天的游戏记录为可访问记录，超过30天的记录不能被拉取到。

在API的响应中，游戏历史的最大条数为10,000条。

拉取游戏历史，必须使用专用API域名gmag_game_data_url。关于实际名称，请查看GM-Ag发送的开户信息相关内容。

拉取到的数据如果之前已经拉到，请根据roundid更新之前的数据，每个roundid只保留一条数据。

请求
参数名

类型

必选

参数说明

startTime

String(32)

是

GMT+0的日期和时间
格式: YYYY-MM-DD HH:mm:00
请注意，秒数值固定为00，任何非零秒数必须转换为00。

endTime

String(32)

是

GMT+0的日期和时间
格式: YYYY-MM-DD HH:mm:00
请注意，秒数值固定为00，任何非零秒数必须转换为00。
endTime - startTime 必须小于 30 分钟。

size

Int

否

每页游戏数据的条数，默认值 = 5000。最大10000

page

Int

否

页码值，默认值 = 1。

showAll

int

       否

1 - 包含子代理，0 - 不包含子代理。 默认为0

roundId

String(64)

否

回合的标识，用于获取某个游戏回合的游戏记录。

playerId

String(24)

       否

用于获取某个玩家的游戏历史记录

providerCode

String(24)

       否

用于获取某个游戏供应商的游戏历史记录

currency

String(8)

       否

用于获取某个货币的游戏历史记录

gameCode

String(63)

       否

用于获取某个游戏的游戏历史记录

响应
参数名

类型

必选

参数说明

total

Int

是

游戏记录的总条数

pages

Int

是

记录的总页数

size

Int

是

每页游戏记录的条数

current

Int

否

当前的页码

records

Array

是

GameHistory数据的数组，可以为空。

GameHistory数组元素
参数名

类型

必选

参数说明

brandId

bigInt

是

代理的唯一标识

playerId

String(24)

是

玩家的唯一标识

providerCode

String(32)

是

游戏供应商的编码

sessionId

String(32)

是

游戏会话的唯一标识

roundId

String(127)

是

游戏回合的唯一标识

gameCode

String(32)

是

游戏记录的游戏代码

currency

String(8)

是

游戏记录的币种编码

platform

String(16)

否

启动游戏的玩家设备平台（web, mobile, download）

bets

numeric(16, 4)

是

押注的金额

wins

numeric(16, 4)

是

赢取的金额

cancels

numeric(16, 4)

是

取消的金额

transIn

numeric(16, 4)

否

转账到游戏的金额

transOut

numeric(16, 4)

否

转账到玩家的金额

balanceEnd

numeric(16, 4)

是

回合完成后的玩家余额

bonusBalanceEnd

numeric(16, 4)

是

回合完成后的奖金账号余额

rake

numeric(16, 4)

否

抽水的金额

startTime

DateTime

是

回合开始的时间

endTime

DateTime

是

回合结束的时间

jpc

numeric(16, 4)

否

累积奖金池的贡献

jpw

numeric(16, 4)

否

当transType = ‘win’，奖金池赢取的金额

jpDetails

text

否

奖金池赢取的详细信息，如id

roundType

String(16)

是

回合的类型（normal, freegame, bonusgame）

roundStatus

String(8)

是

回合的状态

additionalData

text

否

游戏记录的额外参数及参数值

detailUrl

String(1024)

否

游戏的详情的链接，有些平台暂时无法提供此链接

gameType

String(16)

         是

slots,table,live,arcade,sport,esport,lotto, poker,bingo, unknown(gameCode无法识别时)

createdAt

DateTime

        是

创建时间

请求例子


{
    "requestId": "requestId1234",
    "brandId": "1001",
    "startTime": "2021-06-10 10:00:00",
    "endTime": "2021-06-10 10:05:00",
    "size": 1000,
    "page": 1,
}
响应例子


//success
{
    "requestId": "request5282",
    "error": "0",
    "message": "SUCCESS",
    "total": 2,
    "current": 1,
    "size": 5000,
    "pages": 1,
    "records": [
        {
            "playerId": "palyerid1",
            "brandId": 1001,
            "providerCode": "pt",
            "sessionId": "03d35793716348cabf5a202ef823a86f",
            "roundId": "583067326075",
            "roundType": "normal",
            "roundStatus": "end",
            "gameCode": "bfb",
            "currency": "CNY",
            "platform": "web",
            "bets": 5.0000,
            "wins": 10.0000,
            "cancels": 0.0000,
            "transIn": 0.0000,
            "transOut": 0.0000,
            "balanceEnd": 2652.0500,
            "bonusBalanceEnd": 0.0000,
            "rake": 0.0000,
            "startTime": "2021-08-11 15:48:23.745",
            "endTime": "2021-08-11 15:48:24.038",
            "createdAt": "2021-08-11 15:48:24.038",
            "jpc": 0.1235,
            "jpw": 5.0000,
            "jpDetails": [
                {
                    "id": "123124",
                    "contribution": 0.12345,
                    "win": 0.12345
                }
            ],
            "gameType": "slots",
            "detailUrl": "https://extstg3-cashier01.ptstaging.eu/getgamehistory.php?ThisIsJustAutomatedTestDataOK"
        },
        {
            "playerId": "palyerid1",
            "brandId": 1001,
            "providerCode": "pt",
            "sessionId": "03d35793716348cabf5a202ef823a86f",
            "roundId": "398521759399",
            "roundType": "normal",
            "roundStatus": "end",
            "gameCode": "bfb",
            "currency": "CNY",
            "platform": "web",
            "bets": 5.0000,
            "wins": 10.0000,
            "cancels": 0.0000,
            "transIn": 0.0000,
            "transOut": 0.0000,
            "balanceEnd": 2657.0500,
            "bonusBalanceEnd": 0.0000,
            "rake": 0.0000,
            "startTime": "2021-08-11 15:48:24.342",
            "endTime": "2021-08-11 15:48:24.870",
            "createdAt": "2021-08-11 15:48:24.038",
            "jpc": 0.0000,
            "jpw": 0.0000,
            "gameType": "slots",
            "detailUrl": "https://extstg3-cashier01.ptstaging.eu/getgamehistory.php?ThisIsJustAutomatedTestDataOK"
        }
    ]
}
//error
{
   "requestId": "requestId1234",
   "error": "P_02",
   "message": "Invalid hash",
}

拉取游戏报表



By Henry Zhang

1 min

Add a reaction
URl：https://{{gmag_game_data_url}}/history/gameReport?hash={{xxx}}。

方式：POST。

目的：用于拉取已经结算游戏的统计报表。未完成结算的游戏不会被统计在报表中。

报表一次拉取的时间跨度不能大于31天。在系统中，只有最近6个月内的报表数据可用，6个月以前的数据不能被拉取到。

拉取游戏报表，必须使用专用API域名gmag_game_data_url。关于实际名称，请查看GM-Ag发送的开户信息相关内容。

请求
参数名

类型

必选

参数说明

startTime

String(32)

是

GMT+0的日期和时间
格式: YYYY-MM-DD HH:mm:00
请注意，秒数值固定为00，任何非零秒数必须转换为00。此时间对应 GameHisotry 响应中的参数 'endTime'。因此，只有已经结算的游戏才会被统计在报表中。

endTime

String(32)

是

GMT+0的日期和时间
格式: YYYY-MM-DD HH:mm:00
请注意，秒数值固定为00，任何非零秒数必须转换为00。此时间对应 GameHisotry 响应中的参数 'endTime'。因此，只有已经结算的游戏才会被统计在报表中。
endTime - startTime 不能大于1 天。

playerId

String(24)

否

玩家ID，用于获取某个玩家的游戏报表。

currency

String(8)

否

币种编码，用于获取某个币种的游戏报表。

gameCode

String(64)

否

游戏编码，用于获取某款游戏的游戏报表。

reportBy

String(32)

       否

gameCode – 按游戏汇总

provider – 按供应商汇总

player – 按玩家汇总

响应
参数名

类型

必选

参数说明

data

Array

是

gameReport数据的数组，可以为空。

GameReport数组元素
参数名

类型

必选

参数说明

totalBets

numeric(16, 4)

是

押注的总金额

totalWins

numeric(16, 4)

是

赢取的总金额

totalCancels

numeric(16, 4)

是

取消的总金额

totalJpc

numeric(16, 4)

是

奖金池贡献的总金额

totalJpw

numeric(16, 4)

是

奖金池赢取的总金额

ggr

numeric(16, 4)

是

代理的总收入（totalBets - totalWins - totalCancels）

games

int

是

游戏的总数量

players

int

是

玩家的总数量

totalRakes

numeric(16, 4)

是

抽水的总金额

currency

String(8)

是

游戏的币种编码

gameCode

String(32)

        否

当reportBy=gameCode时返回

providerCode

String(32)

        否

当reportBy=provider或gameCode时返回

playerId

String(32)

        否

当reportBy=player时返回

请求例子


{
    "requestId": "requestId1234",
    "brandId": "1001",
    "startTime": "2021-06-10 01:00:00",
    "endTime": "2021-06-11 01:00:00"
}
响应例子


//success
{
    "requestId": "request8491",
    "error": "0",
    "message": "SUCCESS",
    "data": [
        {
            "ggr": -150,
            "totalWins": 260,
            "totalCancels": 225,
            "players": 1,
            "games": 54,
            "totalBets": 335,
            "currency": "CNY",
            "totalJpw": 5,
            "totalRakes": 0,
            "totalJpc": 0.1235
        },
        {
            "ggr": -150,
            "totalWins": 260,
            "totalCancels": 225,
            "players": 1,
            "games": 54,
            "totalBets": 335,
            "currency": "INR",
            "totalJpw": 5,
            "totalRakes": 0,
            "totalJpc": 0.1235
        }
    ]
}
//error
{
    "requestId": "requestId1234",
    "error": "P_02",
    "message": "Invalid hash",
}

拉取游戏列表



By Amy Guo (Unlicensed)

1 min

Add a reaction
URl: https://{{gmag_game_data_url}}/game/list?hash={{xxx}}

方式: POST.

目的: 用于搜索GMAG中的游戏列表，查询游戏的详细信息

代理调用gameList 方法来查询游戏信息， 可以对 providerCode, gameType, gameCode 等字段进行查询.

拉取游戏信息，必须用专用API域名 gmag_game_data_url。 关于实际名称，请查看GM-Ag发送的开户信息相关内容。

请求
参数名

类型

必选

描述

providerCode

String(32)

否

游戏供应商编码

gameType

String(32)

否

游戏类型

gameCode

String(32)

否

游戏唯一编码

page

Int

否

查询的页码数，默认为1

size

Int

否

每页的记录书，默认为100

响应
参数名

类型

必选

描述

total

Int

是

所有游戏记录数。

pages

Int

是

总页面数。

sizes

Int

是

每个页面的游戏数量。

records

Array

是

Game数据的数组，可以为空。

current

Int

是

当前页面编码数。

游戏信息
参数名

类型

必选

描述

gameCode

String(32)

是

游戏的唯一编码。

gameType

String(32)

是

游戏的类型，详细信息请参加下方的GameType表格。

cnName

String(255)

是

游戏中文名字。

enName

String(8)

是

游戏英文名字。

providerCode

String(32)

是

游戏的供应商编码。

mobile

int(2)

是

是否支持手机，是为1，否则为0。

desktop

int(2)

是

是否支持电脑，是为1，否则为0。

freeGame

int(2)

是

是否支持免费游戏，是为1，否则为0。

freeSpin

int(2)

是

是否支持免费旋转，是为1，否则为0。

goldenChip

int(2)

是

 是否支持golden chip，是为1，否则为0。

progressive

int(2)

是

是否支持奖金池，是为1，否则为0。

released

int(2)

是

是否已发布，是为1，否则为0。

jackpotName

String(255)

否

奖金池名字，progressive 为1 时不为空。

jackpotTicker

String(255)

否

奖金池编码，progressive 为1时不为空。

description

String(2048)

否

游戏描述。

rtp

String(255)

否

游戏的返奖率。

reels

String(255)

否

游戏的转数。

lines

String(255)

否

游戏线数。

releaseDate

DateTime

否

游戏上线时间。

resourceLink

String(1023)

否

游戏资源链接。

imgDefault

String(1023)

否

游戏的默认图片。

imgCn

String(1023

否

中文游戏图片
更新于 2024-07-12

tableAlias

String(1023)

否

游戏的桌子编码，当为live类型游戏时出现。

status

int(2)

是

游戏状态（生效，下架，维护中）。

游戏类型
Name

Description

slots

老虎机游戏类型。

table

赌桌游戏类型。

live

真人游戏类型。

arcade

街机游戏类型。

sport

体育游戏类型。

esport

电子竞技游戏类型。

lotto

彩票游戏类型。

poker

扑克游戏类型。

other

其他游戏类型。

请求例子


{
   "requestId": "requestId1234",
   "brandId": "1",
   "gameType":"slots",
   "size": 2,
   "page": 1
}
响应例子


//success
{
    "requestId": "requestId1234",
    "error": "0",
    "message": "SUCCESS",
    "total": 1728,
    "current": 1,
    "size": 2,
    "pages": 864,
    "records": [
        {
            "gameCode": "gf_2226",
            "gameType": "slots",
            "cnName": "HotSpin",
            "enName": "HotSpin",
            "providerCode": "gf",
            "mobile": 1,
            "desktop": 1,
            "freeGame": 0,
            "freespin": 0,
            "goldenChip": 0,
            "progressive": 0,
            "released": 1,
            "status": 1
        },
        {
            "gameCode": "gf_2202",
            "gameType": "slots",
            "cnName": "Wolf Disco",
            "enName": "Wolf Disco",
            "providerCode": "gf",
            "mobile": 1,
            "desktop": 1,
            "freeGame": 0,
            "freespin": 0,
            "goldenChip": 0,
            "progressive": 0,
            "released": 1,
            "status": 1
        }
    ]
}
//error
{
   "requestId": "requestId1234",
   "error": "P_02",
   "message": "Invalid hash",
}

拉取游戏详情链接



By Amy Guo (Unlicensed)

Add a reaction
URl: https://{{gmag_game_data_url}}/history/roundDetail?hash={{xxx}}

方式: POST.

目的: 用于获取某一局对局游戏详情的链接，查询游戏对局详细信息

代理使用roundDetail方法来查询游戏对局详情， 可以对 providerCode, roundId 等字段进行查询.

拉取游戏详情，必须用专用API域名 gmag_game_data_url。 关于实际名称，请查看GM-Ag发送的开户信息相关内容。

备注：并非所有游戏供应商都会提供该功能，没有提供会返回“No Data”

请求
参数名

类型

必选

描述

endTime

String(32)

是

GMT+0的日期和时间
格式: YYYY-MM-DD HH:mm:ss
此时间对应 GameHisotry 中的参数 ‘endTime’，或者是交易请求中endRound = 1 的那一笔交易的‘transTime’ 因此，只有已经结算的游戏才能查询到游戏对局详情。

roundId

String(64)

是

回合的标识，用于获取某个游戏回合的游戏记录。

providerCode

String(24)

是

供应商代码，用于获取某个供应商的游戏详情。

language

String(8)

       否

游戏详情需要使用的语言（并非所有供应商都会支持，不支持该功能的供应商会自动忽略该字段）

响应
参数名

类型

必选

描述

data

String

是

游戏详情的链接。

请求例子


{
   "requestId": "requestId1234",
   "brandId": "1",
   "roundId": "roundId1234",
   "endTime": "2022-08-04 23:00:00",
   "providerCode": "pt"
}
响应例子


//success
{
    "requestId": "requestId1234",
    "error": "0",
    "message": "SUCCESS",
    "data": "https://detailurl.example"
}
//error
{
   "requestId": "requestId1234",
   "error": "P_02",
   "message": "Invalid hash"
}
{
    "requestId": "request2868",
    "error": "50001",
    "message": "No data"
}

拉取游戏额外奖励交易信息



By John Chen

1 min

Add a reaction
URl: https://{{gmag_game_data_url}}/history/extraTrans?hash={{xxx}}。

方式：POST。

目的：用于根据交易产生时间获取玩家的交易记录(推广活动/ 锦标赛)。

在API的响应中，游戏交易的最大条数为10,000条。

拉取游戏交易信息，必须使用专用API域名gmag_game_data_url。关于实际名称，请查看GM-Ag发送的开户信息相关内容。

请求
参数名

类型

必选

参数说明

startTime

String(32)

是

GMT+0的日期和时间
格式: YYYY-MM-DD HH:mm:00
请注意，秒数值固定为00，任何非零秒数会被转换为00。

endTime

String(32)

是

GMT+0的日期和时间
格式: YYYY-MM-DD HH:mm:00
请注意，秒数值固定为00，任何非零秒数会被转换为00。

size

Int

否

每页交易的条数，默认值 = 5000。

page

Int

否

页码值，默认值 = 1。

playerId

String(24)

否

玩家的唯一标识，用于获取某个玩家的交易信息。

showAll

Int

否

1 - 包含子代理，0 - 不包含子代理。默认为0。

providerCode

String(32)

否

游戏供应商唯一标识，用户获取某个供应商的交易信息

currency

String(8)

否

根据玩家货币获取交易信息

响应
参数名

类型

必选

参数说明

total

Int

是

游戏交易的总条数

pages

Int

是

交易的总页数

size

Int

是

每页交易的条数

current

Int

否

当前的页码

records

Array

是

extraTrans数据的数组，可以为空。

ExtraTrans数组元素
参数名

类型

必选

参数说明

transId

String(64)

是

游戏交易的唯一标识

playerId

String(24)

是

玩家的唯一标识

brandId

bigInt

是

代理的唯一标识

providerCode

String(8)

是

游戏供应商的编码

currency

String(8)

是

交易的币种编码

amount

numeric(16, 4)

是

交易的金额(包含奖池赢取金额jpw)

balanceBefore

numeric(16, 4)

是

交易发生前，玩家的余额

balanceAfter

numeric(16, 4)

是

交易发生后，玩家的余额

transTime

DateTime

是

交易操作的时间

referenceId

String(64)

是

活动ID

referenceName

String(512)

否

活动名称

description

String(2048)

否

描述

请求例子


{
   "requestId": "requestId1234",
   "brandId": "222",
   "startTime": "2024-09-11 01:30:00",
   "endTime": "2024-09-11 01:45:00",
   "size": 1000,
   "page": 1
}
响应例子


//success
{
    "requestId": "requestId1234",
    "error": "0",
    "message": "SUCCESS",
    "total":2200,
    "size":1000,
    "current":1,
    "pages":2,
    "records": [
        {
            "transId": "10003",
            "playerId": "JohnCNY_T_0424",
            "providerCode": "oaks",
            "brandId": 222,
            "transTime": "2024-09-11 01:35:15.220",
            "amount": 0,
            "currency": "CNY",
            "balanceBefore": 975055.89,
            "balanceAfter": 975055.89,
            "referenceId": "10003",
            "referenceName":"10003",
        },
        {
            "transId": "10004",
            "playerId": "JohnCNY_T_0424",
            "providerCode": "oaks",
            "brandId": 222,
            "transTime": "2024-09-11 01:36:21.495",
            "amount": 0.09,
            "currency": "CNY",
            "balanceBefore": 975055.89,
            "balanceAfter": 975055.98,
            "referenceId": "10004",
            "referenceName":"10004"
        },
        {
            "transId": "10005",
            "playerId": "JohnCNY_T_0424",
            "providerCode": "oaks",
            "brandId": 222,
            "transTime": "2024-09-11 01:36:40.632",
            "amount": 0.09,
            "currency": "CNY",
            "balanceBefore": 975055.98,
            "balanceAfter": 975056.07,
            "referenceId": "10005",
            "referenceName":"10005",
            "description":"10005"
        }
    ]
}
//error
{
   "requestId": "requestId1234",
   "error": "P_02",
   "message": "Invalid hash",
}