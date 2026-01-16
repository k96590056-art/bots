开元棋牌
开元棋牌API接入文档
KY Card Game API Document
V2.0.19
版本记录Release
日期
Date
版本Version
备注
Remark
2017/2/28 V1.0.0 创建API文档
Create API ducument
2017/3/24 V1.0.1 更新接口说明
Update interface description
2017/4/13 V1.0.2 登录接口新增IP字段
IP field is added to the login interface
2017/4/17 V1.0.3 游戏结果接口更新
Game result interface update
2017/6/5 V1.0.4 登录接口新增站点标识
Login interface adds site identity
2017/7/11 V1.0.5
CardValue新增二八杠规则
CardValue adds Two-Eight Bar bar rules
2017/8/26 V1.0.6
CardValue新增牛牛规则
CardValue adds Niu-Niu rules
2017/9/25 V1.0.7 修正订单查询返回状态码
correct order query return status code
2017/10/23 V1.0.8 新增查询游戏内总分接口
Add interface for query the total score in the game
2017/10/24 V1.0.9 新增踢下线接口
Add interface for kicking off the line
2017/12/21 V1.1.0 修复4.4撰写错误repair 4.4 errors
2017/12/28 V1.1.1
CardValue新增押庄龙虎、三公
CardValue adds Dragon-Tiger game, Three-Facecard game
2018/1/8 V1.1.2
1.删除3.2.5的订单状态1（处理中状态）
delete order state 1 of 3.2.5 (processing state)
2.修改3.2.7的list字段（增加LineCode字段）
modify the list field of 3.2.7 (add the LineCode field)
2018/1/10 V1.1.3
1.修改押庄龙虎
CardValuemodify Dragon-Tiger CardValue
2.优化3.2描述，注明所有子操作类型
optimize the 3.2 description, indicate all suboperation types
2018/1/17 V1.1.4
1.新增21点CardValue、KindID
add BlackJack CardValue、KindID corresponding
information
2.优化所有游戏CardValue描述（规则未变动）
optimizate all game’s CardValue descriptions (rules unchanged)
2018/1/29 V1.1.5
新增通比牛牛、欢乐红包CardValue、KindID
Add Casino Bull-Bull, Happy Red Packets’ CardValue, KindID
information corresponding
2018/2/1 V1.1.6 修正欢乐红包CardValue读取规则描述
Correct CardValue read rule description of Happy Red Packet
2018/4/3 V1.1.7 新增极速炸金花、抢庄牌九CardValue、KindID
2
Add Speed Golden Flower, Paigow’s CardValue、KindID
2018/5/7 V1.2.0
1.新增3.3多币种支持、4.5兑换比例
Add 3.3 multi – currency principle, 4.5 exchange ratio
2.新增斗地主、幸运五张、十三水、CardValue、KindID
Add Landlord, lucky 5 cards, Pineapple Poker
CardValue、KindID
3.增加抢庄牛牛至尊房KindID
Add Banker Bull-Bull master room KindID
4.增加code码37~39
Add code 37-39
2018/5/10 V1.2.1
1.修改上下分，增加上下分后返回玩家可下分金
Modify charge points and refund, after charge points or refund back to
the refundable balance of the player
2.增加3.2.10查询代理余额接口
Add 3.2.10 query agency balance interface
2018/5/29 V1.2.2 修改幸运五张CardValue读取规则
Modify lucky 5 cards CardValue reading rules
2018/6/4 V1.2.3
1.修改欢乐红包CardValue读取规则
Modify Happy Red Packets’CardValue reading rules
2.修改十三水CardValue读取规则
Modify Pineapple Poker’CardValue reading rules
2018/6/6 V1.2.4 增加4.2错误码说明-错误码40
Add 4.2 Error code description-error code 40
2018/7/17 V1.2.5 增加4.2错误码说明-错误码41、42、43
Add 4.2 Error code description-error code41、42、43
2018/7/22 V1.2.6
1.修改3.2.3、3.2.4、3.2.5接口描述信息
Modify interface description information of 3.2.3、
3.2.4、3.2.5
2.增加4.1游戏房间8306、7305、8605、7205、8705
Add 4.1game room 8306、7305、8605、7205、8705
3.新增百家乐、射龙门4.4CardValue、4.1KindID
Add Baccarat、Dragon Gate 4.4 CardValue、4.1 KindID
2018/7/30 V1.2.7 修改21点cardvalue读取规则
Modify BlackJack cardvalue reading rules
2018/8/7 V1.2.8 新增森林舞会cardvalue读取规则
Add forest dance cardvalue read rule
2018/8/24 V1.2.9 修改百家乐cardvalue读取规则
Correct CardValue read rule description of Baccarat
2018/9/17 V1.3.0
3.2.7Gameid的Nvarchar(20)更改为Nvarchar(50)
3.2.7Gameid's Nvarchar(20) changed to Nvarchar(50)
2018/9/21 V1.3.1 新增百人牛牛cardvalue读取规则
Add Niu–niu for thousands person cardvalue read rule
2018/10/18 V1.3.2
注单拉取限制,由无限制改为至少间隔10秒才能拉取1次
The bet order pull limit is changed from unlimited to at least 10 seconds
to pull 1 time.
2018/10/25 V1.3.3
3.2.1account加入提醒，账号区分大小写
3.2.1 Player Account case sensitive
3
2018/11/19 V1.3.4
1.3.2.5增加状态3（处理中）3.2.5 add state 3（in process）
2.4.2增加错误码44，有相同订单正在处理中4.2 add error
code 44
2018/11/30 V1.3.5
3.2.6和3.2.8 status加入封停状态
3.2.6 and 3.2.8 add banned status
2018/12/5 V1.3.6
新增二八杠、三公、通比牛牛、抢庄牌九王者房
Add Two-Eight Bar、Three-Facecard、Casino
Bull-Bull、Paigow King’s Room
2018/12/11 V1.3.7
3.2.1登录游戏接口新增返回按钮自定义跳转链接（backUrl）
Adds proxy customization to return Url control, see at 3.2.1
2019/2/22 V1.4.0
1.新增万人炸金花cardvalue读取规则
2.新增万人炸金花kindid和对应房间ID
Add Golden Flower for thousands person cardvalue read rule
2019/3/7 V1.5.0
1.新增血流成河cardvalue读取规则
2.新增血流成河kindid和对应房间ID
Add Bleeding Mahjong cardvalue read rule
2019/4/2 V1.6.0
1.新增二人麻将cardvalue读取规则
Adds 2 Persons’ Mahjong KindID
2.新增二人麻将kindid和对应房间ID
Adds 2 Persons’ Mahjong cardvalue
3.新增看牌抢庄牛牛cardvalue读取规则
Adds Banker Bull-Bull After Check Card KindID Adds Banker
Bull-Bull After Check Card cardvalue
4.新增看牌抢庄牛牛kindid和对应房间ID
2019/4/16 V1.6.1
4.2新增错误码45，参数错误
4.2 add error code 45
2019/5/25 V1.6.2
1.新增幸运转盘cardvalue读取规则、kindid和房间ID
Adds Lucky Dial cardvalue 、KindID and room ID
2.新增金鲨银鲨cardvalue读取规则、kindid和房间ID
Adds Golden Shark & Silver Shark cardvalue、KindID
and room ID
3.新增奔驰宝马cardvalue读取规则、kindid和房间ID
Adds Benz & BMW cardvalue 、KindID and room ID
4.修改注单最大拉取时间范围不能超过40分钟
Modify the maximum pull time of the bet can not exceed 40 minutes
2019/9/4 V1.6.3
1.新增百人骰宝cardvalue读取规则、kindid和房间ID
Adds Sic Bo cardvalue 、KindID and room ID
2.新增单挑牛牛cardvalue读取规则、kindid和房间ID
Adds 1v1 Bull-Bull cardvalue 、KindID and room ID
3.新增炸金牛cardvalue读取规则、kindid和房间ID
Adds Golden Bull cardvalue 、KindID and room ID
4.新增押宝抢庄牛牛cardvalue读取规则、kindid和房间ID
Adds Bet 3 Players Bull-Bull cardvalue 、KindID and
room ID
5.新增红包捕鱼cardvalue读取规则、kindid和房间ID
Adds Fishing cardvalue 、KindID and room ID
6.新增血战到底cardvalue读取规则、kindid和房间ID
Adds Fishing cardvalue 、KindID and room ID
7.新增搏一搏cardvalue读取规则、kindid
Adds Give A Bet cardvalue 、KindID
4
2019/11/15 V1.7.0
1.新增五星宏辉cardvalue读取规则、kindid和房间ID
Adds Five Stars cardvalue、KindID and room ID
2.新增赌场扑克cardvalue读取规则、kindid和房间ID
Adds Casino Poker cardvalue、KindID and room ID
3.新增港式梭哈cardvalue读取规则、kindid和房间ID
Adds Hong Kong Stud cardvalue、KindID and room ID
4.新增血战骰宝cardvalue读取规则、kindid和房间ID
Adds Karmic SicBo cardvalue、KindID and room ID
5.新增水果机cardvalue读取规则、kindid和房间ID
Adds Fruit Machine cardvalue、KindID and room ID
6.新增幸运夺宝cardvalue读取规则、kindid和房间ID
Adds Lucky Treasure cardvalue、KindID and room ID
2020/2/27 V1.7.1
1.新增鱼虾蟹cardvalue读取规则、kindid和房间ID
Adds Fish-Prawn-Crab Dice cardvalue、KindID and
room ID
2.新增跑得快cardvalue读取规则、kindid和房间ID
Adds Run Fast cardvalue、KindID and room ID
3.标记4.1附录游戏列表下不能单独接入的游戏
Mark 4.1 games that cannot be accessed separately in the appendix
game list
2021/2/4 V1.7.2 正式服订单每5s查询一次，改为每10s查询一次
Change query time in refund process.
2021/4/15 V1.7.3
1.新增红黑大战cardvalue读取规则、kindid和房间ID
Adds Red & Black War cardvalue、KindID and room ID
2.新增疯狂抢庄牛牛cardvalue读取规则、kindid和房间ID
Adds Crazy Banker Bull-Bull cardvalue、KindID and
room ID
3.新增马战竞猜cardvalue读取规则、kindid和房间ID
Adds Horse Fight cardvalue、KindID and room ID
4.新增李逵捕鱼kindid和房间ID
Adds LK Fishing cardvalue、KindID and room ID
2021/4/26 V1.7.5
修改游戏币兑换比例并且新增澳元（AUD）、文莱元（BND）、加
拿大元（CAD）、瑞士法郎（CHF）、英镑（GBP）、缅元（MMK
）、罗威克朗（NOK）、新西兰元（NZD）、菲律宾比绍（PHP
）、新加坡元（SGD）、瑞典克朗（SEK）、南非兰特（ZAR）、
津巴布韦元（ZWD）、港币（HKD）、新台币（TWD）
Change game Currency Exchange Ratio.
Game Currency Exchange Ratio add Australian Dollar
（AUD）、Brunei Dollar（BND）、Canadian dollar（CAD
）、Swiss franc（CHF）、Great British Pound（GBP）、
Myanmar Kyat（MMK）、Norwegian krone（NOK）、New
Zealand dollar（NZD）、Philippine peso（PHP）、
Singapore dollar（SGD）、Swedish krona（SEK）、
South African rand（ZAR）、Zimbabwean dollar（ZWD
）、Hong Kong dollar（HKD）、New Taiwan dollar（TWD
）
2021/10/4 V1.7.6
3.2.3上分参数附注使用 AES-128-ECB 加密方式3.2.3 Notes
on Charge Points param use AES-128-ECB encryption
3.2.3 Notes on Charge Points param use AES-128-ECB encryption
2021/10/28 V1.7.7
1.新增金元捕鱼kindid和房间ID
Adds ChinYuan fishing cardvalue、KindID and room ID
2.新增捕鱼传说kindid和房间ID
5
Adds BYCS Fishing cardvalue、KindID and room ID
2021/11/12 V1.7.8
1.新增二人斗地主cardvalue读取规则、kindid和房间ID
Adds 2 Persons' Landlord cardvalue、KindID and room
ID
2.新增绝代皇后kindid和房间ID
Adds The Peerless Queen cardvalue、KindID and room
ID
3.新增文房四宝kindid和房间ID
Adds Four Treasures of the study cardvalue、KindID
and room ID
4.修改游戏币移除美元（USD）、港币（HKD）、新台币（TWD）
Removes US dollar(USD) 、Hong Kong dollar（HKD）、
New Taiwan dollar（TWD）from Game Currency
Exchange Ratio
2022/2/25 V1.7.9
1.新增美元（USD）、港币（HKD）、新台币（TWD）、泰达币（
USDT）、里奥（BRL）
Game Currency Exchange Ratio add US dollar(USD) 、
Hong Kong dollar（HKD）、New Taiwan dollar（TWD）、
Tether（USDT）、Brazilian Reais（BRL）
2.移除欢乐红包kindid、cardvalue和房间ID
Remove Happy Red Packets KindID, CardValue and Room ID
3.移除幸运五kindid、cardvalue和房间ID
Remove Lucky 5 Cards KindID, CardValue and Room ID
4.移除射龙门kindid、cardvalue和房间ID
Remove Dragon Gate KindID, CardValue and Room ID
5.移除血战到底kindid、cardvalue和房间ID
Remove Karmic Mahjong KindID, CardValue and Room ID
2022/3/28 V1.8.0
1.新增极速百家乐cardvalue读取规则、kindid和房间ID
Adds Three-Facecard After Check Card cardvalue、
KindID and room ID
2.新增看牌抢庄三公cardvalue读取规则、kindid和房间ID
Adds Speed Baccarat cardvalue、KindID and room ID
2022/6/17 V1.8.1
1.新增梭哈德州扑克cardvalue读取规则、kindid和房间ID
Adds All-In or Fold cardvalue、KindID and room ID
2.新增干瞪眼cardvalue读取规则、kindid和房间ID
Adds Desperate Rummy cardvalue、KindID and room
ID
2022/7/1 V1.8.2 移除干瞪眼
Remove Desperate Rummy
2022/8/2 V1.8.3
移除二人斗地主、马战竞猜、文房四宝、绝代皇后Remove 2
Persons' Landlord 、Horse Fight、Peerless Queen、
Four Treasures of the study
2022/8/31 V1.8.4
1.新增MP_泰式骰宝、MP_色碟 kindid
Adds MP Hilo 、MP Xoc Dia KindID
2.抢庄牌九说明调整
Paigow card value description adjustment
3.新增印度尼西亚盾（IDR）
Game Currency Exchange Ratio add IDR
2022/9/19 V1.8.5 新增开元体育拉单api规则
Adds Get Sport Orders API
6
2022/10/4 V1.8.6
1.新增十倍牛牛cardvalue读取规则、kindid和房间ID
Adds Ten Times Bull-Bull cardvalue、KindID and
room ID
2.新增金球银球cardvalue读取规则、kindid和房间ID
Adds World Cup Golden Ball cardvalue、KindID and
room ID
3.3.2.7Gameid的Nvarchar(50)更改为Nvarchar(190)
3.2.7Gameid's Nvarchar(50) changed to Nvarchar(190)
4.新增MP_泰式骰宝、MP_色碟cardvalue说明
Adds MP Hilo 、MP Xoc Dia cardvalue
5.修正3.2.11体育拉单”settleTime”字段描述
Modify 3.2.11 Sport Order “settleTime”filed description
2022/12/8 V1.8.7 移除MP_泰式骰宝、MP_色碟
Remove MP Hilo 、MP Xoc Dia
2022/12/19 V1.8.8
1.新增富贵金龙cardvalue读取规则、kindid和房间ID
Adds Golden Dragon cardvalue、KindID and room ID
2.金鲨银鲨cardvalue读取规则调整
Modify Golden Shark & Sliver Shark cardvalue reading rules
2023/2/22 V1.8.9
1.新增欧式轮盘cardvalue读取规则、kindid和房间ID
Adds European Roulette cardvalue、KindID and room
ID
2.新增富贵三张cardvalue读取规则、kindid和房间ID
Adds Three Card Poker cardvalue、KindID and room ID
2023/3/28 V1.9.0 新增色色百家乐cardvalue读取规则、kindid和房间ID
Adds Se-Se Baccarat cardvalue、KindID and room ID
2023/4/27 V1.9.1 色色百家乐更名为官人坏坏百J乐
Rename Se-Se Baccarat to H-Baccarat
2023/6/22 V1.9.2
1.修改KY体育kindId 7280改 7470及体育拉单
Modify KY sports kindId 7280 to 7470 and get sport record
2.移除4.5游戏币兑换比例登入地区说明
Remove 4.5 game currency exchange ratio area of login
3.3.3.13体育拉单新增提前结算相关参数
3.3.13 Added parameters related to early settlement for sports record
4.修改4.6运动类型及4.8盘口信息
Modify 4.6 Sports Type and 4.8 Market Type Information
5. 移除3.3.13体育拉单API除rows字段
Remove 3.3.13 Sports Order API rows filed
6.修改3.3.13体育拉单API isLive字段型别bool -> string
Modify 3.3.13 Sports Order API isLive filed type bool -> string
2023/09/11 V1.9.3
3.3.13体育拉单新增游戏局号, 游戏唯一识别码, 注单的归帐日, 投
注类型 相关参数
3.3.13 Added parameters gameNo, gameID, profitReportDate, betType
for sports record
2023/10/10 V1.9.4
新增闪电21点cardvalue读取规则、kindid和房间ID
Adds Lightning Blackjack cardvalue、KindID and room
ID
2023/10/31 V.1.9.5 游戏币移除港币（HKD）
Removes Hong Kong dollar（HKD）
2023/11/7 V.1.9.6 3.3.13体育拉单修改validSettleStakeAmount说明, 删除
7
turnover、actualStake
3.3.13 Modify validSettleStakeAmount info and removes turnover,
actualStake
2023/11/21 V1.9.7 新增终极德州扑克cardvalue读取规则、kindid和房间ID
Adds Ultimate Texas cardvalue、KindID and room ID
2024/1/10 V1.9.8
1. 修改【3.2.2 查询可下分】的子操作类型 s=24 调整成 s=1
1. Modify the sub-operation type of [3.2.2 Query can be divided] from
s=24 to s=1
2. 新增财神发发发 幸运熊猫 炸财神cardvalue读取规则、kindid
和房间ID
Adds Fortune FaFaFa、Lucky Panda、Bombing Fortune
cardvalue、KindID and room ID
2024/1/25 V1.9.9 新增麻将胡了3 cardvalue读取规则、kindid和房间ID
Adds Mahjong Master cardvalue、KindID and room ID
2024/4/30 V2.0.0
1.新增以下错误码：46 48 49 50 51 89 200 1001 1002
Add error code: 46 48 49 50 51 89 200 1001 1002
2. 游戏API指引以下三支接口响应money字段型态由string调整为
float (3.2.2 查询可下分 3.2.3 上分 3.2.4 下分)
2. Modify the api guidelines 3 api response filed [money] type string to
float
(3.2.2 query balance 3.2.3 charge points 3.2.4 refund)
3. 拉取注单API指引以下四支接口响应CellScore AllBet Profit
Revenue字段型态由string调整为float
(3.3.1取牌局纪录1 3.3.2取牌局纪录2 3.3.3取牌局纪录3 3.3.4取
牌局纪录4 )
3. Modify the get game record api guidelines 4 api response filed
[CellScore AllBet Profit Revenue] type string to float
(3.3.1 Get Game Record1 3.3.2 Get Game Record2 3.3.3 Get Game
Record3 3.3.4 Get Game Record4)
2024/5/16 V2.0.1
1.拉取注单API指引以下四支接口, 新增返回币别Currency和语系
Language
(3.3.1取牌局纪录1 3.3.2取牌局纪录2 3.3.3取牌局纪录3 3.3.4取
牌局纪录4 )
Adds Currency and Language to the following four APIs: (3.3.1 Get
Game Record1, 3.3.2 Get Game Record2, 3.3.3 Get Game Record3,
3.3.4 Get Game Record4)
2024/6/4 V2.0.2
1. 删除以下错误码：
10, 12, 13, 14, 17, 18,19, 21, 23, 25, 37, 200, 1001, 1002
Delete error code：
10, 12, 13, 14, 17, 18,19, 21, 23, 25, 37, 200, 1001, 1002
2. 新增以下错误码：91, 98, 99
Add error code：91, 98 , 99
3.修正4.4.1德州扑克读取CardValue说明
Correction 4.4.1 Texas Hold'em poker reading CardValue instructions
2024/7/16 V2.0.3 新增抖音牛牛cardvalue读取规则、kindid和房间ID
Adds TikTok Bull-Bull cardvalue、KindID and room ID
2024/8/28 V2.0.4
1. 新增错误码52，玩家有异常盈利或分数异常状况时
呼叫API s=3返回错误码52，当收到此响应再请洽询我方客服人员
Added error code 52, when players have abnormal profits or abnormal
scores calling API s=3 returns error code 52. Please contact our team
8
when receiving this response.
2. 3.2.3上分API s=2叙述补充当收到回复异常或超时回补玩家分数
说明
The description of the add score API s=2 is supplemented with
instructions for replenishing player scores when receiving an abnormal
response or timeout.
3. 新增掼蛋cardvalue读取规则、kindid和房间ID
Adds GuanDan cardvalue、KindID and room ID
2024/10/24 V2.0.5
新增黑神话百人牛牛读取规则、kindid和房间ID
Adds Black Myth Niu-niu For Thousands Person
cardvalue、KindID an3.3.13d room ID
2024/11/6 V2.0.6
新增逃离五指山读取规则、kindid和房间ID
Adds Escape from Wuzhishan cardvalue、KindID and
room ID
2024/12/4 V2.0.7
新增黑神话西游读取规则、kindid和房间ID
Adds Monkey king: black wukong cardvalue、KindID
and room ID
2024/12/26 V2.0.8 新增癞子牛牛读取规则、kindid和房间ID
Adds Lai Zi Niu Niu cardvalue、KindID and room ID
2025/02/06 V2.0.9
1. 新增比大小读取规则、kindid和房间ID
Adds HI-LO cardvalue、KindID and room ID
2.文件3.3.13 体育拉单接口修改
1. 移除以下栏位
1.1. isSystemTagRisky
1.2. netTurnoverByActualStake
1.3. subBet.htScore
1.4. subBet.ftScore
1.5. subBet.customeizedBetType
2. 更改栏位型别
2.1. status 更改成 int
2.2. subBet.status 更改成 int
3. 调整栏位说明
3.1. subBet.status 调整为结算结果
2. Modify 3.3.13 KY sport order
1. Remove the following fields
1.1. isSystemTagRisky
1.2. netTurnoverByActualStake
1.3. subBet.htScore
1.4. subBet.ftScore
1.5. subBet.customeizedBetType
2. Change field type
2.1. field "status" type is adjusted from String to Int
2.2. field "subBet status" type is adjusted from String to Int
3. Adjust field descriptions
3.1. subBet.status Adjust to settlement results
2025/3/10 V2.0.10
新增以下游戏kindid
1. 三国
2. 喜相逢
3. 后羿射日
4. 大力神槌
5. 找地鼠
6. 新年到戳戳乐
7. 水果炸弹
9
8. 王者荣耀
9. 生存者
10. 矮人矿坑
11. 祥狮献瑞
12. 荒野逃生
13. 财神到
14. 金虎报吉
15. 雀神
16. 鬼吹灯
17. 龙年行大运
Adds the following games KindID
1. Three Kingdoms
2. Encounter
3. Houyi Shot The Suns
4. Hammer
5. Gopher
6. Poke Fortune
7. Fruit Bombs
8. King of Glory
9. Survivor
10. Gold Digger
11. Tigerlions Lead To Auspicious
12. Battle Royale
13. Fortune
14. Golden Tiger
15. MAHJONG GOD
16. Candle In The Bomb
17. Great Luck In The Year Of The Dragon
2025/03/14 V2.0.11
1. 新增3.3.14虚拟体育拉单接口s=1
2. 新增4.9虚拟体育产品代码
1. Add 3.3.14 Virtual Sports Order Interface s=1
2. Add 4.9 SporVirtual Sport Product Code
2025/05/16 V2.0.12 新增土耳其麻将读取规则、kindid和房间ID
Adds Okey cardvalue、KindID and room ID
2025/06/03 V2.0.13
1. 新增澳门百家乐幸运六读取读规则、kindid和房间ID
2. 新增极速牛牛读取规则、kindid和房间ID
1. Add Macau Baccarat Lucky Six cardvalue、KindID
and room ID
2. Add Speed Bull-Bull cardvalue、KindID and room ID
2025/07/08 V2.0.14
1. 新增铸剑读取规则、kind和房间ID
1. Add Forging a sword cardvalue、KindID and room ID
2025/07/16 V2.0.15
1. 新增3.3.15开元体育根据注单局号获取资讯接口
1. Add 3.3.15 KY Sport specific order
2025/07/30 V2.0.16
1. 新增3.3.13开元体育根据修改日期获取注单列表新增是否为二次结
算栏位
1. Add 3.3.13 KY Sport specific order add column isRollback
2025/08/12 V2.0.17 新增射门之王读取规则、kindid和房间ID
Adds Soccer King cardvalue、KindID and room ID
2025/08/15 V2.0.18
1.以下拉取牌局紀錄返回字段的TableID 型態修改為BigInt
3.3.1拉取牌局紀錄1
10
3.3.2拉取牌局紀錄2
3.3.3拉取牌局紀錄3
3.3.4拉取牌局紀錄4
1.The TableID type of the following return fields for retrieved hand
records has been changed to BigInt.
3.3.1 Retrieving Hand Record 1
3.3.2 Retrieving Hand Record 2
3.3.3 Retrieving Hand Record 3
3.3.4 Retrieving Hand Record 4
2.3.3.5拉取牌局詳情s=10添加語系參數
2.3.3.5 Pull game details s=10 Add Lang parameter
2025/09/17 V2.0.19
1. 新增体育登入语系参数 - sportLang
2. 新增体育登入语系表
1. Add KY Sport login language parameter - sportLang
2. Add KY Sport login language code
11
目录 Catalog
1、 产品介绍 Product Introduction.......................................................................................................... 14
1.1 七大优势 Seven Advantages........................................................................................................14
1.2 合作模式Cooperation Mode........................................................................................................14
二、接入准备Access Preparation.............................................................................................................15
三、接入方法Access Method...................................................................................................................16
3.1 流程图Flow Chart........................................................................................................................16
3.1.1 登入平台Login Platform............................................................................................................16
3.1.2 查询余额Get Balance................................................................................................................ 17
3.1.3 上分Charge Points..................................................................................................................... 17
3.1.4 下分 Refund...............................................................................................................................18
3.2 游戏API指引Game Api Guidelines............................................................................................... 18
3.2.1 登录游戏Login...........................................................................................................................18
3.2.2 查询可下分Query Refundable Balance.....................................................................................21
3.2.3 上分Charge Points..................................................................................................................... 22
3.2.4 下分Refund................................................................................................................................24
3.2.5 查询订单Order Query............................................................................................................... 25
3.2.6 查询玩家在线状态Query The Player’s Online Status...............................................................27
3.2.7 查询玩家总分Query Player’total Points................................................................................... 28
3.2.8 踢玩家下线 Kicking The Player Off........................................................................................... 29
3.2.9 查询代理余额(非必要) Query Agency Balance(Unnecessary).................................................31
3.3拉取注单API指引 API Guide for get game record......................................................................... 32
3.3.1取牌局记录1 Get Game Record1...............................................................................................32
3.3.2拉牌局记录2 Get game record 2............................................................................................... 35
3.3.3拉取牌局记录3 Get game record 3........................................................................................... 37
3.3.4拉取牌局记录4 Get game record 4........................................................................................... 40
3.3.5拉取牌局详情 Get detail of game.............................................................................................42
3.3.6拉取玩家输赢排行 Get player profit rankings.......................................................................... 44
3.3.7根据对局记录获取一段时间汇总数据 Get summarized game record....................................46
3.3.8生成加密的同桌玩家链接 Get same table player data link..................................................... 47
3.3.9对局日志解析 Get game log link............................................................................................... 49
3.3.10拉取分类统计游戏数据 Get categorized game statistic data.................................................50
3.3.11 拉取百人游戏下注点列表 Get bet points list of baccarat-style game.................................. 52
3.3.12 代理拉取前端地址ws、ld地址 Get front end ws and ld address...........................................54
3.3.13开元体育根据修改日期获取注单列表 KY sport order..........................................................55
3.3.14虚拟体育根据修改日期获取注单列表 virtual sport order................................................... 59
3.3.15开元体育根据注单局号获取资讯 KY sport specific order.....................................................62
3.4 多币种支持Multi-Currency Principle........................................................................................... 66
四、附录Appendix................................................................................................................................... 67
4.1 KindID对应游戏Corresponding Games........................................................................................ 67
4.2 KindID对应房间名 Corresponding Game’s room..........................................................................70
4.3 加解密代码Encryption And Decryption Code.............................................................................. 85
4.4 CardValue读取规则Cardvalue Reading Rules............................................................................... 85
4.4.1 德州扑克Texas Hold'em Poker.................................................................................................. 86
12
4.4.2 二八杠Two-Eight Bar.................................................................................................................87
4.4.3 抢庄牛牛Banker Bull-Bull..........................................................................................................87
4.4.4 炸金花Golden Flower................................................................................................................88
4.4.5 三公Three-Facecard.................................................................................................................. 88
4.4.6 押庄龙虎Dragon-Tiger.............................................................................................................. 89
4.4.7 21点Blackjack............................................................................................................................ 89
4.4.8 通比牛牛Casino Bull-Bull.......................................................................................................... 90
4.4.9 抢庄牌九Paigow........................................................................................................................90
4.4.10 极速炸金花Speed Golden Flower...........................................................................................92
4.4.11 斗地主Landlord.......................................................................................................................92
4.4.12 十三水Pineapple Poker........................................................................................................... 93
4.4.13 百家乐Baccarat....................................................................................................................... 94
4.4.14 森林舞会Forest Party..............................................................................................................95
4.4.15 百人牛牛Niu-Niu For Thousands Person................................................................................ 95
4.4.16 万人炸金花Golden Flower For Thousands Person................................................................. 96
4.4.17 血流成河Bleeding Mahjong....................................................................................................97
4.4.18 看牌抢庄牛牛Banker Bull-Bull After Check Card....................................................................98
4.4.19 二人麻将2 Persons’ Mahjong 2.............................................................................................. 98
4.4.20 幸运转盘Lucky Dial................................................................................................................. 99
4.4.21 金鲨银鲨Golden Shark & Silver Shark.....................................................................................99
4.4.22 奔驰宝马Benz & BMW..........................................................................................................100
4.4.23 百人骰宝Sic Bo..................................................................................................................... 100
4.4.24 单挑牛牛 1V1 Bull-Bull..........................................................................................................100
4.4.25 炸金牛Golden Bull................................................................................................................ 101
4.4.26 押宝抢庄牛牛Bet 3 Players Bull-Bull.................................................................................... 102
4.4.27 红包捕鱼Fishing....................................................................................................................103
4.4.28 搏一搏Give A Bet.................................................................................................................. 103
4.4.29 五星宏辉Five Stars................................................................................................................103
4.4.30 赌场扑克Casino Poker...........................................................................................................104
4.4.31 港式梭哈Hong Kong Stud..................................................................................................... 105
4.4.32 血战骰宝Karmic SicBo...........................................................................................................106
4.4.33 水果机Fruit Machine.............................................................................................................106
4.4.34 幸运夺宝Lucky Treasure....................................................................................................... 109
4.4.35 鱼虾蟹Fish-Prawn-Crab Dice................................................................................................. 109
4.4.36 跑得快Run Fast..................................................................................................................... 111
4.4.37 红黑大战Red & Black War.....................................................................................................113
4.4.38 疯狂抢庄牛牛Crazy Banker Bull-Bull.................................................................................... 113
4.4.39 李逵捕鱼LK Fishing............................................................................................................... 113
4.4.40 金元捕鱼ChinYuan Fishing.................................................................................................... 114
4.4.41 捕鱼传说BYCS Fishing........................................................................................................... 114
4.4.42 极速百家乐Speed Baccarat.................................................................................................. 114
4.4.43 看牌抢庄三公Three-Face Card After Check Card................................................................. 115
4.4.44 梭哈德州扑克All-In or Fold.................................................................................................. 115
4.4.45 金球银球World Cup Golden Ball...........................................................................................115
13
4.4.46 十倍牛牛Ten Times Bull-Bull.................................................................................................116
4.4.47 富贵金龙Golden Dragon....................................................................................................... 116
4.4.48 欧式轮盘European Roulette................................................................................................. 117
4.4.49 富贵三张Three Card Poker....................................................................................................117
4.4.50 官人坏坏百J乐H-Baccarat.................................................................................................... 117
4.4.51 闪电21点Lightning Blackjack.................................................................................................118
4.4.52 终极德州扑克Ultimate Texas................................................................................................118
4.4.53 炸财神Bombing Fortune....................................................................................................... 119
4.4.54 幸运熊猫Lucky Panda........................................................................................................... 119
4.4.55 财神发发发Fortune FaFaFa...................................................................................................119
4.4.56 麻将胡了3 Mahjong Master................................................................................................. 119
4.4.57 抖音牛牛TikTok Bull-BullGuandan........................................................................................ 119
4.4.58 掼蛋Guandan.........................................................................................................................120
4.4.59 黑神话百人牛牛 Black Myth Niu-Niu For Thousands Person...............................................121
4.4.60 逃离五指山 Escape from Wuzhishan....................................................................................122
4.4.61 西游黑悟空Monkey king black wukong................................................................................122
4.4.62 癞子牛牛Lai Zi Niu Niu.......................................................................................................... 122
4.4.63 比大小 HI-LO......................................................................................................................... 122
4.4.64 土耳其麻将 Okey.................................................................................................................. 123
4.4.65 极速牛牛 Speed Bull-Bulll..................................................................................................... 124
4.4.66 澳门百家乐幸运六 Macau Baccarat Lucky Six..................................................................... 124
4.4.67 铸剑 Forging a sword............................................................................................................. 125
4.4.68 射门之王 Soccer King............................................................................................................125
4.5游戏币兑换比例 Game Currency Exchange Ratio....................................................................... 125
4.6 运动类型 Sport Type................................................................................................................. 127
4.7 体育注单状态 Sport Order status.............................................................................................. 128
4.7.1 订单状态 Order status.............................................................................................................128
4.7.2 结算结果 Outcome................................................................................................................. 128
4.8 盘口 Market Type...................................................................................................................... 128
4.9 虚拟体育产品代码 Virtual Sport Product Codes........................................................................150
4.10 体育登入语系表 Sport Login Language Code..................................................................151
14
1、 产品介绍 Product Introduction
开元棋牌是由开元游戏集团2017年全新发布上线的棋牌游戏中心，资深研发团队倾情打造，支
持API无限分发，国内首家，全球领先！
KY card game is a brand new card game center launched by Kaiyuan Group CO. in 2017. It is made by a
senior research and developent team, supporting API unlimited distribution which is first in China and
leading global.
1.1 七大优势 Seven Advantages
( 1 ) 抢滩蓝海市场：移动互联网迅猛发展，大量新玩家涌入。棋牌游戏玩家认知度高、上手简单
和游戏性强，能迅速拉近玩家与平台距离，降低玩家参与博彩心理负担。
Snatch Market Share: A large number of new game players influx along with the rapid
development of mobile internet. Card games with great recognition, simple hands and strong
game nature, can bring the distance between the players and the platform closer quickly and
reduce their psychological burden of participation in the gambling.
( 2 ) API无限分发：无需缴纳高昂的接入费用、保证金，人人都能成为代理商无限发展下线代理
和直线会员
API Unlimited Distribution: It has no need to pay high access fees, margin. Everyone can be an
agent to develop subordinate agents and straight membership unlimitedly.
( 3 ) 无全币种支持：一次接入，所有币种通用，代理方便，玩家最佳体验
Multi-currency：One-time access, all currencies are available, convenient to agent, best
experience for players.
( 4 ) 独立匹配系统：根据代理需求可以每个代理商玩家独立匹配，也可以多代理商玩家联合匹
配，最大程度保证代理利益
Independent Matching System: According to the agent requirements, the system can be matched
by each agent independently, and also can be matched by multi agent players together to
maximally guarantee the interest of the agent.
( 5 ) 游戏种类丰富：数十款棋牌产品积淀，德州扑克、炸金花、牛牛、三公、百家乐等将陆续更新
，代理可以通过后台自定义游戏大厅
Rich in Variety: Dozens of card games, Dezhou poker, Golden Flower, Niu-Niu, San Gong and
Baccarat continue updating. Agents can customize the game hall through the background.
( 6 ) 多终端支持：移动端、PC端打开即玩，完美兼容，无需下载
Multiple Terminal Supports: It supports Mobile terminal, PC terminal, perfect compatibility, no
need to download.
( 7 ) 强大支援团队：资深研发团队保证游戏稳定可靠，专业推广团队提供全套推广方案咨询，
7*24小时客服运维团队随时响应
Strong Support Team: The senior R & D team ensures that the game is stable and reliable.
Professional promotion teams provide a full range of promotional program consultation. 7*24
hours customer service operation team respond at any time.
1.2 合作模式Cooperation Mode
甲方（开发商）向乙方（代理商）免费提供游戏接入服务，并以10%~15%的费率向乙方销售游戏分
数，乙方通过向下级代理或者直线玩家销售分数实现盈利。分数售出概不退回，对于有实力的乙方，
甲方可以先提供分数，下月初再根据消耗分数进行结算。
Party A (developer) provides game access services free to Party B (agents), and sells game scores to
Party B at the rate of 10%~15%. Party B achieves profits through selling points to subordinate agents or
straight players. Points sold shall not be returned. Party A can provide points first to Party B who is assessed
key agent, both parties settle accounts at the beginning of the next month according to the consumption of
points.
● 甲方服务：提供游戏接入API、代理商后台、游戏维护更新、7*24小时客服运维保障
Party A: provide game access to API, agent backstage, game maintenance update, 7*24 hour
service and maintenance support.
● 乙方权限：游戏独立运营、无限极下级代理发展、独立代理商后台、游戏大厅自定义
15
Party B: operate the game independently, unlimited development of subordinate agents,
independent agents background, custom game hall
二、接入准备Access Preparation
● 从上级代理处获取你的代理号和KEY值，并向开发商提供你的服务器IP用以添加服务器IP白
名单
Getting your agent number and KEY value from the superior agent and providing your server IP to
the developer to add the server IP white list.
● 需要贵方提供一个回调通知接口，用作玩家下线时我方通知贵方，接口参数包括<1、agent
代理编号；2、param 参数加密字符串；3、timestamp 时间戳；4、 key、Md5校验字符串 >
You need to provide a callback notification interface which is applied to notify you when the
player is offline. The interface parameters include <1, agent: agent number; 2, param: parameter
encryption string; 3, timestamp: timestamp; 4, key, Md5 check string >.
● 参照“三、接入方法”进行调试
Debugging refer to “Ⅲ. Access Method”.
● 说明：游戏接入时先按照“开元棋牌API接入文档-测试”调通游戏，测试完成后再按照“开元棋
牌API接入文档 - 正式”更新代理信息
Explanation: When the game is accessed, it will first debug the game according to the “XX Card
API access to document – debug”. After the test is completed, the agent information will be
updated according to “XX Card API access to document – release”.
16
三、接入方法Access Method
3.1 流程图Flow Chart
3.1.1 登入平台Login Platform
17
3.1.2 查询余额Get Balance
3.1.3 上分Charge Points
● 订单号是现金网根据平台的规则生成出来的
The cash net generates an order number according to the rules of the platform.
● 没有在平台数据库查询到订单号，则再次使用此订单号上分可以防止重复上分
It uses the original order number if the order number is not querying in the platform database to
prevent duplication.
● 上分失败的错误提示包括Error prompt include：
● 订单号已处理（此订单号已处理，上分已经成功了，不需要回滚分数）
注Notes：
The order number has been processed(the order number has been processed, charge points
success, no need to rollback points)
● 订单号错误（订单号格式不正确，上分不成功，需要回滚分数）
Order number error (order number format incorrect, charge points failure, need to rollback
points)
18
● 代理商余额不足（上分失败，需要回滚分数）
The agent’s balance is insufficient (charge points failure, need to rollback points)
3.1.4 下分 Refund
注Notes：
● 订单号是现金网根据平台的规则生成出来的
The cash net generates an order number according to the rules of the platform.
● 没有在平台数据库查询到订单号，则再次使用此订单号下分可以防止重复下分
It uses the original order number if the order number is not querying in the platform database to
prevent duplication.
● 下分失败的错误提示包括Error prompt inculde：
● 订单号错误（提示：订单号格式不正确，下分失败，现金网不用加分）
Order number error (order number format incorrect, refund failure, no need to increase points on
cash net)
● 订用户余额不足（提示：下分失败，账户金额不足，现金网不用加分）
The player’s balance is insufficient (refund failure, insufficient account amount, no need to
increase points on cash net)
● 订单号已处理（此订单号已处理过，不需要再次下分，如果此时代理商数据库没有通过此订
单号加分则需要增加用户额度）
The order number has been processed(the order number has been processed, no need to refund.
If the agent database does not increase points for this order number at this time, the player’s
account quota needs to be increased)
3.2 游戏API指引Game Api Guidelines
3.2.1 登录游戏Login
描述Description
此接口用以验证游戏账号，如果账号不存在则创建游戏账号并为账号上分。
This interface is used to authenticate the game account. If the account does not exist, the game account is
created. Charging points for the account.
接口URL Interface URL
https://<server>/channelHandle?agent=XX&timestamp=XX&param=XX&key=XX
参数Parameter
19
接口interface：channelHandle
示例URL：Sample URL:
https://api.ky34.com/channelHandle?agent=10001&timestamp=1488781836949&param=ngtgiYCl26%2F
gBmGvf9Euj2c1MOpzIzy4VWru%2Fsv3jao88cUlrENQTXz6pAeS3I2FqR7%2FPJFUIoTh%0D%0Ae%2FFnAkdb
w2TxTkbhPCi5yjGJVVdY2C4%3D&key=f3afd416a0bb1b183eed8ef6cac30d75
字段名
Field Name
描述
Description
数据类型
Data type
是否必须
Required
agent 代理编号（平台提供）
Agent number（platform provide）
String Y
timestamp
时间戳(Unix时间戳带上毫秒),获取当前时间
（1488781836949）
Time stamp (Unix time stamp with
milliseconds), grab the current time（
1488781836949）
String Y
param
参数加密字符串param=（
s=0&account=111111&money=100&orderid=1
000120170306143036949111111&ip=127.0.0.
1& lineCode
=text11&KindID=0&sportLang=CMN）
s：操作子类型：0
account：会员帐号(64位字符)
money：金额(上分的金额,如果不携带分数传
0)
orderid：流水号（格式：代理编号
+yyyyMMddHHmmssSSS+ account,长度不能
超过100字符串）
ip:客户端请求IP(玩家IP)
lineCode：代理下面的站点标识,用防止站点
之间导分。(区分同一个代理账号下面的不
同站点，值自定义,长度10字符以内的英文
或者数字。请千万不要一个玩家一个
linecode)
KindID:游戏ID(传入不同的游戏ID直接进入
不同的游戏，对应关系见附录)
sportLang: ky体育登入语系参数
Encrypt.AESEncrypt(param,DESKey);
DESKey：平台提供
parameter encrypted string param =（
s=0&account=111111&money=100&orderid=1
000120170306143036949111111&ip=127.0.0.
1& lineCode
=text11&KindID=0&sportLang=CMN）
s：operate subtype：0
account：member account number（64byte）
money： points (charge points, if without point
default by 0)
orderid：serial number（pormat: agent
number+yyyyMMddHHmmssSSS+ account，
limit 100 string）
ip:client request IP (player IP)
String Y
20
lineCode：the site identity below the agent
(used to distinguish different sites under the
same agent account, value custom, English or
number within 10 bytes of length. One
linecode for each player is forbided)
KindID:geme ID(afferent different games’ID, go
directly into different games, the
corresponding relationship is attached to the
appendix)
sportLang: ky sport login language parameter
Encrypt.AESEncrypt(param,DESKey);
DESKey： platform provide
key
Md5校验字符串
Md5check string
Encrypt.MD5(agent+timestamp+ MD5Key);
String Y
返回Return
示例Sample：
{"s":100,"m":"/channelHandle","d":{"code":0,"url":"https://h5.ky34.com/index.html?account=10001_11
1111&token=FBE54A7273EE4F15B363C3F98F32B19F&lang=zh-CN&KindID=0"}}
字段名Field Name 数据类型Data type 描述Description
s Int 子操作类型suboperation type
m String 主操作类型main operation type
d Object 数据结果data results
d数据结果返回值对应d data result return value correspondence
字段值Field Name 数据类型Data type 描述Description
url String
游戏URL game URL
大厅或房间选择界面的返回按钮，如果
期望跳转到自定义的URL，可以在游戏
地址后面增加&backUrl=自定义URL（非
必要,如果不拼接那么使用默认值，不
会影响用户正常使用）
The return button of the room selection
interface or lobby, if you want to jump to
a custom URL, you can add
&backUrl=custom URL after the game
address. (not necessary，If you do not
splicing then use the default value, it will
not affect the normal use of the user.)
code Int 错误码Error code
游戏URL拼接自定义参数Game URL Stitching Custom Parameters
21
示例Sample：
https://new.ky206.com/index.html?account=21002_test966&token=eyJkYXRhIjoiNzAwMDBfdGVzdDUyN
yIsImNyZWF0ZWQiOjE1NDE1ODEwOTksImV4cCI6MTUwfQ==.+sZ8eQ+W8ygZOTrIVzH/E3eSZ6UuCpEOlXF
oWmfm6uA=&lang=zh-CN&time=1541581116142&backUrl=https://www.baidu.com/&jumpType=2
参数名称parameter
name
解释
explain
backUrl
0：默认值，不外跳
自定义URL：例&backUrl= https://new.ky206.com，必须是http或者https格
式，点击按钮则跳转到该地址(外跳地址最好进行转译,防止外跳地址中
有特殊字符导致链接异常,游戏进入失败)
0: default value, no jump
Custom URL: example&backUrl = http://leg666.com, must be in http o,click
the button to jump to the address
jumpType
0：默认值，不能外跳，不显示大厅的主页按钮，显示游戏选择房间界面的
返回按钮（点击回到大厅）
0: default value, can not jump outside, does not display the home button of
the lobby, display the return button of the game selection room interface
(click to return to the lobby)
1：不能外跳，不显示游戏选择房间界面的返回按钮，不显示大厅的主页
按钮
1: can not jump outside, does not display the return button of the game
selection room interface, does not display the lobby Home button
2：可以外跳，点击游戏选择房间界面的返回按钮跳转到backUrl，不显示
大厅的主页按钮
2: Can jump outside, click the return button of the game selection room
interface to jump to backUrl, do not display the home button of the lobby
3：可以外跳，显示游戏选择房间界面的返回按钮（点击回到大厅），点击
大厅的主页按钮跳转到backUrl
3: Can jump outside, display the return button of the game selection room
interface (click back to the lobby), click on the lobby Home button jumps to
backUrl
3.2.2 查询可下分Query Refundable Balance
描述Description
此接口用来查询玩家的币别钱包可下分余额
如果要查询玩家总额可以不使用此接口，直接使用3.2.8
This interface is used to query the player’s refundable balance.
If need to query player’s total amount can use interface 3.2.8 rather this one.
接口URL Interface URL
https://<server>/channelHandle?agent=XX&timestamp=XX&param=XX&key=XX
参数Parameter
接口Interface：channelHandle
示例URL：Sample URL：
https://api.ky34.com/channelHandle?agent=10001&timestamp=1488790714058&param=EDt0JatL6P3UP
5NKs971baLdIDe4jkkb4BTPJxyrhzI%3D&key=9b742d6a08f5d6b66af2f9c047ee1e06
字段名
Field Name
描述
Description
数据类型
Data type
是否必须
Required
agent 代理编号（平台提供） String Y
22
Agent number（platform provide）
timestamp
时间戳(Unix时间戳带上毫秒),获取当
前时间（1488781836949）
timestamp(Unix timestamp with
milliseconds), grab the current time（
1488781836949）
String Y
param
参数加密字符串param=（
s=1&account=111111）
s：操作子类型:1
account：会员帐号）
Encrypt.AESEncrypt(param,DESKey);
DESKey：平台提供
parameter encrypted string param=（
s=1&account=111111）
s: operate subtype: 1
account: member account number）
Encrypt.AESEncrypt(param, DESKey);
DESKey: platform provide
String Y
key
Md5校验字符串
Md5 check string
Encrypt.MD5(agent+timestamp+
MD5Key);
String Y
返回Return
示例Sample：
{"s":101,"m":"/channelHandle","d":{"money":100,"code":0}}
字段名Field Name 数据类型Data type 描述Description
s Int 子操作类型suboperation type
m String 主操作类型main operation type
d Object 数据结果data results
d数据结果返回值对应
字段值Field Value 数据类型Data type 描述Description
account String 玩家账号User account
code Int
错误码（查看附录说明）
Error code（see the appendix instructions
）
money Float 余额money
3.2.3 上分Charge Points
描述Description
此接口用来为账号上分（如果未收到API接口响应或是收到code != 0，可通过3.2.5查询订单状态来判
断此次请求是否成功，当发生上述情况若需要将玩家分数回补请务必遵循我方3.1.3流程指引）。
This interface is used to charge points for the player’s account（If do not receive response form interface,
can use 3.2.5 to query order state to determine whether the request was successful, when the above
situation occurs, if you need to replenish player points, please be sure to follow our 3.1.3 process
guidelines.）
23
接口URL Interface URL
https://<server>/channelHandle?agent=XX&timestamp=XX&param=XX&key=XX
参数Parameter
接口Interface：channelHandle
示例URL：Sample URL：
https://api.ky34.com/channelHandle?agent=10001&timestamp=1488791553051&param=nS42zzqT3fHQ
LBEfbB4ok2c1MOpzIzy4VWru%2Fsv3jao88cUlrENQTXz6pAeS3I2F8SI5db8tTG20%0D%0AWQDY9LQPMW9
Xfy%2F1boz0REbE957bAvk%3D&key=8aeef9ff9b32f5f746ca663e8676a412
字段名
Field Name
描述
Description
数据类型
Data type
是否必须
Required
agent 代理编号（平台提供）
Agent number（platform provide）
String Y
timestamp
时间戳(Unix时间戳带上毫秒),获取
当前时间（1488781836949）
timestamp(Unix timestamp with
milliseconds), grab the current time（
1488781836949）
String Y
param
参数加密字符串param=（
s=2&account=111111&money=100&o
rderid=1000120170306143036949111
111）
s：操作子类型:2
account：会员帐号
money：金额(上分的金额)
orderid：流水号（格式：代理编号
+yyyyMMddHHmmssSSS+ account,长
度不能超过100字符串）
Encrypt.AESEncrypt(param,DESKey);
DESKey：平台提供
注: 请按照 AES-128-ECB 加密方式
parameter encrypted string param=（
s=2&account=111111&money=100&o
rderid=1000120170306143036949）
s: operate subtype : 3
account: member account number
money: points (charge points)
orderid: serial number（pormat: agent
number +yyyyMMddHHmmssSSS+
account，limit 100 string）
Encrypt.AESEncrypt(param, DESKey);
DESKey: platform provide
String Y
key
Md5校验字符串
Md5 check string
Encrypt.MD5(agent+timestamp+
MD5Key);
String Y
返回Return
24
示例Sample：
{"s":102,"m":"/channelHandle","d":{"code":0}}
字段名Field Name 数据类型Data type 描述Description
s Int 子操作类型suboperation type
m String 主操作类型main operation type
d Object 数据结果data results
d数据结果返回值对应d data result return value correspondence
字段值Field Value 数据类型Data type 描述Description
code Int
错误码（查看附录说明）
Error code（see the appendix instructions
）
money float
上分后可下分金额
Refundable balance after refund
3.2.4 下分Refund
描述Description
此接口用来为账号下分（如果未收到API接口响应，可通过3.2.5查询订单状态来判断此次请求是否成
功）。
This interface is used to refund for the player’s account
（If do not receive response form interface, can use 3.2.5 to query order state to determine whether the
request was successful ）
接口URL Interface URL
https://<server>/channelHandle?agent=XX&timestamp=XX&param=XX&key=XX
参数Parameter
接口Interface：channelHandle
示例Sample URL：
https://api.ky34.com/channelHandle?agent=10001&timestamp=1488802591519&param=mpxbf%2FNVX
Aoq6Ct8yF637Gc1MOpzIzy4VWru%2Fsv3jao88cUlrENQTXz6pAeS3I2FIVTuKjUEvvQ1%0D%0AYZkrUWStHs
89aNubhKlWiKmywItCYHY%3D&key=59511e18be46aa96aee13c36ceb46bdb
字段名
Field Name
描述
Description
数据类型
Data type
是否必须
Required
agent 代理编号（平台提供）
Agent number（platform provide）
String Y
timestamp
时间戳(Unix时间戳带上毫秒),获取
当前时间（1488781836949）
timestamp(Unix timestamp with
milliseconds), grab the current time（
1488781836949）
String Y
25
param
参数加密字符串param=（
s=3&account=111111&money=100&o
rderid=1000120170306143036949111
111）
s：操作子类型:3
account：会员帐号
money：金额(下分的金额，不要超过
可下分数)
orderid：流水号（格式：代理编号
+yyyyMMddHHmmssSSS+ account，长
度不能超过100字符串）
Encrypt.AESEncrypt(param,DESKey);
DESKey：平台提供
parameter encrypted string param=（
s=4&orderid=10001201703021948213
16）
s: operate subtype : 4
orderid: serial number（pormat: agent
number +yyyyMMddHHmmssSSS+
account）
Encrypt.AESEncrypt(param, DESKey);
DESKey: platform provide
String Y
key
Md5校验字符串
Md5 chech string
Encrypt.MD5(agent+timestamp+
MD5Key);
String Y
返回Return
示例Sample：
{"s":103,"m":"/channelHandle","d":{"account":"111111","code":0}}
字段名Field Name 数据类型Data type 描述Description
s Int 子操作类型suboperation type
m String 主操作类型main operation type
d Object 数据结果data results
d数据结果返回值对应d data result return value correspondence
字段值Field Value 数据类型Data type 描述Description
code Int
错误码（查看附录说明）
Error code（see the appendix instructions
）
money Float 下分后可下分金额
money
3.2.5 查询订单Order Query
描述Description
此接口用来查询玩家上下分的订单信息，通过status状态来判断上下分是否成功。
This interface is used to query the player’s order information of charging points or refund，through status to
determine whether the charge point or refund was successful.
接口URL Interface URL
26
https://<server>/channelHandle?agent=XX&timestamp=XX&param=XX&key=XX
参数Parameter
接口Interface：channelHandle
https://api.ky34.com/channelHandle?agent=10001&timestamp=1488803043759&param=4Oq38C3kRzE
U9%2Be2pqdUNwa7nIbBcWGpFRQjxYboxJ37cEUpZ0P3wND7jBmzQ7Do&key=378c50baaf22320332ee09
e704ad8ad3
字段名
Field Name
描述
Description
数据类型
Data type
是否必须
Required
agent 代理编号（平台提供）
Agent number（platform provide）
String Y
timestamp
时间戳(Unix时间戳带上毫秒),获取当
前时间（1488781836949） String Y
param
参数加密字符串param=（
s=4&orderid=10001201703021948213
16111111）
s：操作子类型:4
orderid：流水号（格式：代理编号
+yyyyMMddHHmmssSSS+ account）
Encrypt.AESEncrypt(param,DESKey);
DESKey：平台提供
parameter encrypted string param=（
s=4&orderid=10001201703021948213
16）
s: operate subtype : 4
orderid: serial number（pormat: agent
number +yyyyMMddHHmmssSSS+
account）
Encrypt.AESEncrypt(param, DESKey);
DESKey: platform provide
String Y
key
Md5校验字符串
Md5 chech string
Encrypt.MD5(agent+timestamp+
MD5Key);
String Y
返回Return
示例Sample：
{"s":104,"m":"/channelHandle","d":{"code":0,"status":2}}
字段名Field Name 数据类型Data type 描述Description
s Int 子操作类型suboperation type
m String 主操作类型main operation type
d Object 数据结果data results
d数据结果返回值对应d data result return value correspondence
字段值Field Value 数据类型Data type 描述Description
27
code Int
错误码（查看附录说明）
Error code（see the appendix instructions
）
status Int
状态码（-1:不存在、0:成功、2:失败、3:
处理中）
Status code（-1: inexistence、0: success、
2: failure、3: Processing）
money Float 交易金额
Transaction amount
3.2.6 查询玩家在线状态Query The Player’s Online Status
描述Description
此接口用来查询玩家是否在线。
This interface is used to query whether the player is online.
接口URL Interface URL
https://<server>/channelHandle?agent=XX&timestamp=XX&param=XX&key=XX
参数parameter
接口Interface：channelHandle
https://api.ky34.com/channelHandle?agent=10001&timestamp=1488803043759&param=4Oq38C3kRzE
U9%2Be2pqdUNwa7nIbBcWGpFRQjxYboxJ37cEUpZ0P3wND7jBmzQ7Do&key=378c50baaf22320332ee09
e704ad8ad3
字段名
Field Name
描述
Description
数据类型
Data type
是否必须
Required
agent 代理编号（平台提供）
Agent number（platform provide）
String Y
timestamp
时间戳(Unix时间戳带上毫秒),获取当
前时间（1488781836949）
timestamp(Unix timestamp with
milliseconds), grab the current time（
1488781836949）
String Y
param
参数加密字符串param=（
s=5&account=111111）
s：操作子类型：5
account：玩家帐号
Encrypt.AESEncrypt(param,DESKey);
DESKey：平台提供
parameter encrypted string param=（
s=5&account=111111）
s: operate subtype: 5
account: player’s account
Encrypt.AESEncrypt(param, DESKey);
DESKey: platform provide
String Y
key
Md5校验字符串
Md5 check string
Encrypt.MD5(agent+timestamp+
MD5Key);
String Y
28
返回Return
示例Sample：
{"s":105,"m":"/channelHandle","d":{"code":0,"status":1}}
字段名Field Name 数据类型Data type 描述Description
s Int 子操作类型suboperation type
m String 主操作类型main operation type
d Object 数据结果data results
d数据结果返回值对应d data result return value correspondence
字段值Field Value 数据类型Data type 描述Description
code Int
错误码（查看附录说明）
Error code（see the appendix instructions
）
status Int
状态码（-1、不存在，0、不在线,1、在线
，2、封停）
Status code（-1: inexistence、0: offline、1:
online、2: Banned）
3.2.7 查询玩家总分Query Player’total Points
描述Description
此接口用来查询玩家的游戏内总分、玩家可下分余额、玩家在线状态
This interface is used to query the player’s total balance in the game, available balance for refund, online
status.
接口URL Interface URL
https://<server>/channelHandle?agent=XX&timestamp=XX&param=XX&key=XX
参数parameter
接口interface：channelHandle
示例URL：Sample URL:
https://api.ky34.com/channelHandle?agent=10001&timestamp=1488790714058&param=EDt0JatL6P3UP
5NKs971baLdIDe4jkkb4BTPJxyrhzI%3D&key=9b742d6a08f5d6b66af2f9c047ee1e06
字段名
Field Name
描述
Description
数据类型
Data type
是否必须
Required
agent 代理编号（平台提供）
Agent number（platform provide）
String Y
timestamp
时间戳(Unix时间戳带上毫秒),获取当
前时间（1488781836949）
timestamp(Unix timestamp with
milliseconds), grab the current time（
1488781836949）
String Y
29
param
参数加密字符串param=（
s=7&account=111111）
s：操作子类型:7
account：会员帐号）
Encrypt.AESEncrypt(param,DESKey);
DESKey：平台提供
parameter encrypted string param=（
s=7&account=111111）
s: operate subtype : 7
account: member account number）
Encrypt.AESEncrypt(param, DESKey);
DESKey: platform provide
String Y
key
Md5校验字符串
Md5 chech string
Encrypt.MD5(agent+timestamp+
MD5Key);
String Y
返回Return
示例sample：
{"s":107,"m":"/channelHandle","d":{"totalMoney":100, "freeMoney":80, "status":0,"code":0}}
字段名Field Name 数据类型Data type 描述Description
s Int 子操作类型suboperation type
m String 主操作类型main operation type
d Object 数据结果data results
d数据结果返回值对应d data result return value correspondence
字段值Field Value 数据类型Data type 描述Description
account String
玩家账号
Member account number
totalMoney Float 总余额
Total balance
freeMoney Float 可下分余额
available balance for refund
status Int
状态码（-1、不存在，0、不在线,1、在线
，2、封停）
Status code（-1: inexistence、0: offline、1:
online、2: Banned）
gameStatus Int
0、不在游戏中，1在游戏中
0：not in the game 1:in the game
code Int
错误码（查看附录说明）
Error code（see the appendix instructions
）
3.2.8 踢玩家下线 Kicking The Player Off
描述Description
此接口用以将在线的玩家强制离线
30
This interface is used to force the online player off.
接口URL Interface URL
https://<server>/channelHandle?agent=XX&timestamp=XX&param=XX&key=XX
参数parameter
接口Interface：channelHandle
示例URL：Sample URL：
https://api.ky34.com/channelHandle?agent=10001&timestamp=1488790714058&param=EDt0JatL6P3UP
5NKs971baLdIDe4jkkb4BTPJxyrhzI%3D&key=9b742d6a08f5d6b66af2f9c047ee1e06
字段名
Field Name
描述
Description
数据类型
Data type
是否必须
Required
agent 代理编号（平台提供）
Agent number（platform provide）
String Y
timestamp
时间戳(Unix时间戳带上毫秒),获取当
前时间（1488781836949）
timestamp(Unix timestamp with
milliseconds), grab the current time（
1488781836949）
String Y
param
参数加密字符串param=（
s=8&account=111111）
s：操作子类型:8
account：会员帐号）
Encrypt.AESEncrypt(param,DESKey);
DESKey：平台提供
parameter encrypted string param=（
s=8&account=111111）
s: operate subtype : 8
account: member account number）
Encrypt.AESEncrypt（param, DESKey）;
DESKey: platform provide
String Y
key
Md5校验字符串
Md5 check string
Encrypt.MD5(agent+timestamp+
MD5Key);
String Y
返回Return
示例Sample：
{"s":108,"m":"/channelHandle","d":{"code":0}}
字段名Field Name 数据类型Data type 描述Description
s Int 子操作类型suboperation type
m String 主操作类型main operation type
d Object 数据结果data results
d数据结果返回值对应d data result return value correspondence
字段值Field Value 数据类型Data type 描述Description
code Int 错误码（查看附录说明）
31
Error code（see the appendix instructions
）
3.2.9 查询代理余额(非必要) Query Agency Balance(Unnecessary)
描述Description
此接口用以查询代理余额This interface is used to query agency balance
接口URL Interface URL
https://<server>/channelHandle?agent=XX&timestamp=XX&param=XX&key=XX
参数parameter
接口Interface：channelHandle
示例URL：Sample URL
https://api.ky34.com/channelHandle?agent=10001&timestamp=1488790714058&param=EDt0JatL6P3UP
5NKs971baLdIDe4jkkb4BTPJxyrhzI%3D&key=9b742d6a08f5d6b66af2f9c047ee1e06
字段名
Field Name
描述
Description
数据类型
Data type
是否必须
Required
agent 代理编号（平台提供）
Agent number（platform provide）
String Y
timestamp
时间戳(Unix时间戳带上毫秒),获取当
前时间（1488781836949）
timestamp(Unix timestamp with
milliseconds), grab the current time（
1488781836949）
String Y
param
参数加密字符串param=（s=14）
s：操作子类型:14
）
Encrypt.AESEncrypt(param,DESKey);
DESKey：平台提供
parameter encrypted string param
=（s=14）
s：operate subtype:14
Encrypt.AESEncrypt（param,DESKey）;
DESKey：platform provide
String Y
key
Md5校验字符串
Md5 check string
Encrypt.MD5(agent+timestamp+
MD5Key);
String Y
返回Return
示例sample：
{"m":"/channelHandle","s":114,"d":{"code":0,"money":"1000000.01"}}
字段名Field Name 数据类型Data type 描述Description
s Int 子操作类型suboperation type
m String 主操作类型main operation type
d Object 数据结果data results
32
d数据结果返回值对应d data result return value correspondence
字段值Field Value 数据类型Data type 描述Description
code Int
错误码（查看附录说明）
Error code（see the appendix instructions
）
money Float 代理余额Agency balance
3.3拉取注单API指引 API Guide for get game record
注：注单是以游戏派奖时间为准；拉取当前时间1分钟之前数据；建议拉取区间为1-5分钟，最大不能超
过40分钟。我方注单每30秒更新一次，建议每隔至少30秒拉取一次，因为30秒内多次拉取的注单也
是重复注单。并强制限制至少每隔10秒才能拉取一次注单。
Notes: bet order is based on the time of game award distributed; fetch the data from one minute before the
current time; It is recommended to fetch data within a range of 1-5 minutes, the maximum time range
should be within 40 minutes. Bet orders are updated every 30 seconds, so it is advised to fetch data at least
every 30 seconds, as fetching within a 30 second would result in duplicate orders. Futhermore, there is a
mandatory restriction to fetch bet orders at least every 10 seconds.
3.3.1取牌局记录1 Get Game Record1
描述Description
拉取各游戏牌局记录
Get game record
接口URL Interface URL
https://<server>/getRecordHandle?agent=XX&timestamp=XX&param=XX&key=XX
参数parameter
接口Interface：getRecordHandle
示例sample：
https://api.ky34.com/getRecordHandle?agent=10001&timestamp=1488791553051&param=nS42zzqT3fH
QLBEfbB4ok2c1MOpzIzy4VWru%2Fsv3jao88cUlrENQTXz6pAeS3I2F8SI5db8tTG20%0D%0AWQDY9LQPMW
9Xfy%2F1boz0REbE957bAvk%3D&key=8aeef9ff9b32f5f746ca663e8676a412
字段名
Field Name
描述
Description
数据类型
Data type
是否必须
Required
agent 代理编号（平台提供）
Agent number（platform provide）
String Y
timestamp
时间戳(Unix时间戳带上毫秒),获取
当前时间（1488781836949）
timestamp(Unix timestamp with
milliseconds), grab the current time
（1488781836949）
String Y
33
param
参数加密字符串param=（
s=6&startTime=1666144818000&endT
ime=1666147818000）
s：操作子类型:6
startTime：查询起始时间戳
（1488781836949）
endTime：查询结束时间戳
（1488781836949）
Encrypt.AESEncrypt(param,DESKey);
DESKey：平台提供
注: 请按照 AES-128-ECB 加密方式
parameter encrypted string param=（
s=6&startTime=1666144818000&endT
ime=1666147818000）
s: operate subtype : 6
startTime: 1488781836949
endTime: 1488781836949
Encrypt.AESEncrypt（param, DESKey）;
DESKey: platform provide
Notes: please use AES-128-ECB
encrypt method
String Y
key
Md5校验字符串
Md5 check string
Encrypt.MD5(agent+timestamp+
MD5Key);
String Y
返回Return
示例sample：
{"m":"/getRecordHandle","s":106,"d":{"code":0,"start":1666144818000,"end":1666147818000,"count":1,
"list":{"GameID":["50-1666145108-309498-2"],"Accounts":["1_sh_test"],"ServerID":[2201],"KindID":[220]
,"TableID":[44020001],"ChairID":[2],"UserCount":[5],"CellScore":["60.00"],"AllBet":["15.00"],"Profit":["57.
00"],"Revenue":["3.00"],"GameStartTime":["2022-10-19 10:05:08"],"GameEndTime":["2022-10-19
10:05:34"],"CardValue":["3723122b0b0d3b1924260608111c362"],"ChannelID":[1],"LineCode":["1_1_sim
onlinecode"],"Currency": ["CNY"], "Language": ["ZH_CN"]}}}
字段名Field Name 数据类型Data type 描述Description
s Int 子操作类型suboperation type
m String 主操作类型main operation type
d Object 数据结果data results
d数据结果返回值对应d data result return value correspondence
字段值Field Value 数据类型Data type 描述Description
code Int
错误码（查看附录说明）
Error code（see the appendix instructions
）
start Int
查询起始时间
start time
34
end Int
查询结束时间
end time
count Int 回传资料笔数
data total amount
list Object 数据列表
list数据结果返回值对应 list data result return value correspondence
GameID String
游戏局号
Game number
Accounts String
会员账号
Player account
ServerID Int 游戏房间代号
Game room ID
KindID Int 游戏代号
Game ID
TableID BigInt 桌号
Table number
ChairID Int 座位号
Chair number
UserCount Int 同房所在玩家数
Number of players
CellScore Float 有效投注额
Effective bet
AllBet Float 总投注额
Total bet
Profit Float 输赢金额
Profit
Revenue Float 反水金额
Revenue
GameStartTime String
游戏开始时间
Game start time
GameEndTime String
游戏结束时间
Game end time
CardValue String
牌局原始资料
Origin card value
ChannelID Int 代理商编号
Channel ID
LineCode String
LineCode
Linecode
Currency String
币别
Currency
35
Language String 游戏语系列表
Language
3.3.2拉牌局记录2 Get game record 2
描述Description
拉取各游戏牌局记录，包含原始数据id
Fetch game record data including original data id
接口URL Interface URL
https://<server>/getRecordHandle?agent=XX&timestamp=XX&param=XX&key=XX
参数parameter
接口Interface：getRecordHandle
示例sample URL：
https://api.ky34.com/getRecordHandle?agent=10001&timestamp=1488791553051&param=nS42zzqT3fH
QLBEfbB4ok2c1MOpzIzy4VWru%2Fsv3jao88cUlrENQTXz6pAeS3I2F8SI5db8tTG20%0D%0AWQDY9LQPMW
9Xfy%2F1boz0REbE957bAvk%3D&key=8aeef9ff9b32f5f746ca663e8676a412
字段名
Field Name
描述
Description
数据类型
Data type
是否必须
Required
agent 代理编号（平台提供）
Agent number（platform provide）
String Y
timestamp
时间戳(Unix时间戳带上毫秒),获取
当前时间（1488781836949）
timestamp(Unix timestamp with
milliseconds), grab the current time
（1488781836949）
String Y
param
参数加密字符串param=（
s=9&startTime=1666144818000&endT
ime=1666147818000）
s：操作子类型:9
startTime：查询起始时间戳
（1488781836949）
endTime：查询结束时间戳
（1488781836949）
Encrypt.AESEncrypt(param,DESKey);
DESKey：平台提供
注: 请按照 AES-128-ECB 加密方式
parameter encrypted string param=（
s=9&startTime=1666144818000&endT
ime=1666147818000）
s: operate subtype : 9
startTime: 1488781836949
endTime: 1488781836949
Encrypt.AESEncrypt（param, DESKey）;
DESKey: platform provide
Notes: please use AES-128-ECB
encrypt method
String Y
key
Md5校验字符串
Md5 check string
String Y
36
Encrypt.MD5(agent+timestamp+
MD5Key);
返回Return
示例sample：
{"m":"/getRecordHandle","s":109,"d":{"code":0,"start":1666144818000,"end":1666147818000,"count":1,
"list":{"GameID":["50-1666145108-309498-2"],"Accounts":["1_sh_test"],"ServerID":[2201],"KindID":[220]
,"TableID":[44020001],"ChairID":[2],"UserCount":[5],"CellScore":["60.00"],"AllBet":["15.00"],"Profit":["57.
00"],"Revenue":["3.00"],"GameStartTime":["2022-10-19 10:05:08"],"GameEndTime":["2022-10-19
10:05:34"],"CardValue":["3723122b0b0d3b1924260608111c362"],"ChannelID":[1],"LineCode":["1_1_sim
onlinecode"],"RecordID":[48866], "Currency": ["CNY"], "Language": ["ZH_CN"]}}}
字段名Field Name 数据类型Data type 描述Description
s Int 子操作类型suboperation type
m String 主操作类型main operation type
d Object 数据结果data results
d数据结果返回值对应d data result return value correspondence
字段值Field Value 数据类型Data type 描述Description
code Int
错误码（查看附录说明）
Error code（see the appendix instructions
）
start Int
查询起始时间
start time
end Int
查询结束时间
end time
count Int 回传资料笔数
data total amount
list Object 数据列表
list数据结果返回值对应 list data result return value correspondence
GameID String
游戏局号
Game number
Accounts String
会员账号
Player account
ServerID Int 游戏房间代号
Game room ID
KindID Int 游戏代号
Game ID
TableID BigInt 桌号
Table number
ChairID Int 座位号
Chair number
UserCount Int 同房所在玩家数
37
Number of players
CellScore Float 有效投注额
Effective bet
AllBet Float 总投注额
Total bet
Profit Float 输赢金额
Profit
Revenue Float 反水金额
Revenue
GameStartTime String
游戏开始时间
Game start time
GameEndTime String
游戏结束时间
Game end time
CardValue String
牌局原始资料
Origin card data
ChannelID Int 代理商编号
Channel ID
LineCode String
LineCode
LineCode
RecordID Int 原始数据编号
Original data ID
Currency String
币别
Currency
Language String 游戏语系列表
Language
3.3.3拉取牌局记录3 Get game record 3
描述Description
拉取各游戏牌局记录，包含该牌局进入初始分数
Fetch game record data including the initial score
接口URL Interface URL
https://<server>/getRecordHandle?agent=XX&timestamp=XX&param=XX&key=XX
参数parameter
接口Interface：getRecordHandle
示例sample URL：
https://api.ky34.com/getRecordHandle?agent=10001&timestamp=1488791553051&param=nS42zzqT3fH
QLBEfbB4ok2c1MOpzIzy4VWru%2Fsv3jao88cUlrENQTXz6pAeS3I2F8SI5db8tTG20%0D%0AWQDY9LQPMW
9Xfy%2F1boz0REbE957bAvk%3D&key=8aeef9ff9b32f5f746ca663e8676a412
字段名
Field Name
描述
Description
数据类型
Data type
是否必须
Required
agent 代理编号（平台提供） String Y
38
Agent Number (platform provide)
timestamp
时间戳(Unix时间戳带上毫秒),获取
当前时间（1488781836949）
timestamp(Unix timestamp with
milliseconds), grab the current time
（1488781836949）
String Y
param
参数加密字符串param=（
s=16&startTime=1666144818000&end
Time=1666147818000）
s：操作子类型:16
startTime：查询起始时间戳
（1488781836949）
endTime：查询结束时间戳
（1488781836949）
Encrypt.AESEncrypt(param,DESKey);
DESKey：平台提供
注: 请按照 AES-128-ECB 加密方式
parameter encrypted string param=（
s=16&startTime=1666144818000&end
Time=1666147818000）
s: operate subtype : 16
startTime: 1488781836949
endTime: 1488781836949
Encrypt.AESEncrypt（param, DESKey）;
DESKey: platform provide
Notes: please use AES-128-ECB
encrypt method
String Y
key
Md5校验字符串
Md5 check string
Encrypt.MD5(agent+timestamp+
MD5Key);
String Y
返回 Return
示例 Sample：
{"m":"/getRecordHandle","s":116,"d":{"code":0,"start":1666144818000,"end":1666147818000,"count":1,"list":{"Ga
meID":["50-1666145108-309498-2"],"Accounts":["1_sh_test"],"ServerID":[2201],"KindID":[220],"TableID":[4402000
1],"ChairID":[2],"UserCount":[5],"CellScore":["60.00"],"AllBet":["15.00"],"Profit":["57.00"],"Revenue":["3.00"],"Gam
eStartTime":["2022-10-19 10:05:08"],"GameEndTime":["2022-10-19
10:05:34"],"CardValue":["3723122b0b0d3b1924260608111c362"],"ChannelID":[1],"LineCode":["1_1_simonlinecode
"],"RecordID":[48866],"CurScore":["9999.00"],"Currency": ["CNY"], "Language": ["ZH_CN"]}}}
字段名Field Name 数据类型Data type 描述Description
s Int 子操作类型suboperation type
m String 主操作类型main operation type
d Object 数据结果data results
d数据结果返回值对应d data result return value correspondence
字段值Field Value 数据类型Data type 描述Description
code Int 错误码（查看附录说明）
39
Error code（see the appendix instructions）
start Int
查询起始时间
start time
end Int
查询结束时间
end time
count Int 回传资料笔数
data total amount
list Object 数据列表
list数据结果返回值对应 list data result return value correspondence
GameID String
游戏局号
Game number
Accounts String
会员账号
Player account
ServerID Int 游戏房间代号
Game room ID
KindID Int 游戏代号
Game ID
TableID BigInt 桌号
Table number
ChairID Int 座位号
Chair number
UserCount Int 同房所在玩家数
Number of players
CellScore Float 有效投注额
Effective bet
AllBet Float 总投注额
Total bet
Profit Float 输赢金额
Profit
Revenue Float 反水金额
Revenue
GameStartTime String
游戏开始时间
Game start time
GameEndTime String
游戏结束时间
Game end time
CardValue String
牌局原始资料
Origin card data
ChannelID Int 代理商编号
Channel ID
LineCode String
LineCode
LineCode
RecordID Int 原始数据编号
Original data ID
40
CurScore String
进入游戏初始金额
Initial score
Currency String
币别
Currency
Language String 游戏语系列表
Language
3.3.4拉取牌局记录4 Get game record 4
描述Description
拉取各游戏牌局记录，包含该牌局进入初始分数及gType
Fetch game record data including intial score and game type
接口URL Interface URL
https://<server>/getRecordHandle?agent=XX&timestamp=XX&param=XX&key=XX
参数parameter
接口Interface：getRecordHandle
示例sample URL：
https://api.ky34.com/getRecordHandle?agent=10001&timestamp=1488791553051&param=nS42zzqT3fH
QLBEfbB4ok2c1MOpzIzy4VWru%2Fsv3jao88cUlrENQTXz6pAeS3I2F8SI5db8tTG20%0D%0AWQDY9LQPMW
9Xfy%2F1boz0REbE957bAvk%3D&key=8aeef9ff9b32f5f746ca663e8676a412
字段名
Field Name
描述
Description
数据类型
Data type
是否必须
Required
agent 代理编号（平台提供）
Agent number (platform provide)
String Y
timestamp
时间戳(Unix时间戳带上毫秒),获取
当前时间（1488781836949）
timestamp(Unix timestamp with
milliseconds), grab the current time
（1488781836949）
String Y
param
参数加密字符串param=（
s=20&startTime=1666144818000&end
Time=1666147818000）
s：操作子类型:20
startTime：查询起始时间戳
（1488781836949）
endTime：查询结束时间戳
（1488781836949）
Encrypt.AESEncrypt(param,DESKey);
DESKey：平台提供
注: 请按照 AES-128-ECB 加密方式
parameter encrypted string param=（
s=20&startTime=1666144818000&end
Time=1666147818000）
s: operate subtype : 20
startTime: 1488781836949
endTime: 1488781836949
Encrypt.AESEncrypt（param, DESKey）;
DESKey: platform provide
String Y
41
Notes: please use AES-128-ECB
encrypt method
key
Md5校验字符串
Md5 check string
Encrypt.MD5(agent+timestamp+
MD5Key);
String Y
返回 Return
示例 Sample：
{"m":"/getRecordHandle","s":120,"d":{"code":0,"start":1666144818000,"end":1666147818000,"count":1,
"list":{"GameID":["50-1666145108-309498-2"],"Accounts":["1_sh_test"],"ServerID":[2201],"KindID":[220]
,"TableID":[44020001],"ChairID":[2],"UserCount":[5],"CellScore":["60.00"],"AllBet":["15.00"],"Profit":["57.
00"],"Revenue":["3.00"],"GameStartTime":["2022-10-19 10:05:08"],"GameEndTime":["2022-10-19
10:05:34"],"CardValue":["3723122b0b0d3b1924260608111c362"],"ChannelID":[1],"LineCode":["1_1_sim
onlinecode"],"RecordID":[48866],"CurScore":["9999.00"],"gameType":["1"],"Currency": ["CNY"],
"Language": ["ZH_CN"]
}}}
字段名Field Name 数据类型Data type 描述Description
s Int 子操作类型suboperation type
m String 主操作类型main operation type
d Object 数据结果data results
d数据结果返回值对应d data result return value correspondence
字段值Field Value 数据类型Data type 描述Description
code Int
错误码（查看附录说明）
Error code（see the appendix instructions
）
start Int
查询起始时间
start time
end Int
查询结束时间
end time
count Int 回传资料笔数
data total amount
list Object 数据列表
list数据结果返回值对应 list data result return value correspondence
GameID String
游戏局号
Game ID
Accounts String
会员账号
Player account
ServerID Int 游戏房间代号
Game room ID
KindID Int 游戏代号
Game ID
42
TableID BigInt 桌号
Table number
ChairID Int 座位号
Chair number
UserCount Int 同房所在玩家数
Number of player
CellScore String
有效投注额
Effective bet
AllBet String
总投注额
Total bet
Profit String
输赢金额
Profit
Revenue String
反水金额
Revenue
GameStartTime String
游戏开始时间
Game start time
GameEndTime String
游戏结束时间
Game end time
CardValue String
牌局原始资料
Original card data
ChannelID Int 代理商编号
Channel ID
LineCode String
LineCode
LineCode
RecordID Int 原始数据编号
Original data ID
CurScore String
进入游戏初始金额
Inital score
gameType String
游戏类
Game type
Currency String
币别
Currency
Language String 游戏语系列表
Language
3.3.5拉取牌局详情 Get detail of game
描述Description
拉取各游戏牌局记录详情
Fetch detail of game record
接口URL Interface URL
https://<server>/getRecordHandle?agent=XX&timestamp=XX&param=XX&key=XX
参数parameter
43
接口Interface：getRecordHandle
示例sample URL：
https://api.ky34.com/getRecordHandle?agent=10001&timestamp=1488791553051&param=nS42zzqT3fH
QLBEfbB4ok2c1MOpzIzy4VWru%2Fsv3jao88cUlrENQTXz6pAeS3I2F8SI5db8tTG20%0D%0AWQDY9LQPMW
9Xfy%2F1boz0REbE957bAvk%3D&key=8aeef9ff9b32f5f746ca663e8676a412
字段名
Field Name
描述
Description
数据类型
Data type
是否必须
Required
agent 代理编号（平台提供）
Agent number (platform provide)
String Y
timestamp
时间戳(Unix时间戳带上毫秒),获取
当前时间（1488781836949）
timestamp(Unix timestamp with
milliseconds), grab the current time
（1488781836949）
String Y
param
参数加密字符串param=（
s=10&account=sh_test&kindID=220&r
ecordID=48866&Lang=0）
s：操作子类型:10
account：查询会员账号
recordID：查询记录之原始编号
Lang:語系(0中文, 1英文)
Encrypt.AESEncrypt(param,DESKey);
DESKey：平台提供
注: 请按照 AES-128-ECB 加密方式
parameter encrypted string param=（
s=10&account=sh_test&kindID=220&r
ecordID=48866）
s: operate subtype : 10
account: player account
recordID: original record ID
Lang: language(0: Chinese, 1:English)
Encrypt.AESEncrypt（param, DESKey）;
DESKey: platform provide
Notes: please use AES-128-ECB
encrypt method
String Y
key
Md5校验字符串
Md5 check string
Encrypt.MD5(agent+timestamp+
MD5Key);
String Y
返回 Return
示例 Sample：
{"m":"/getRecordHandle","s":110,"d":{"code":0,"data":"炸金花体验房, 底分 1.00\r\n玩家账号 1_sh_test, 座位号
2\r\n1 号位, 携带金额 448.30\r\n2 号位, 携带金额 9999.00\r\n3 号位, 携带金额 291.21\r\n4 号位, 携带金额
58.80\r\n5 号位, 携带金额 205.80\r\n1 号位, 开始, 下注锅底 1.00\r\n2 号位, 开始, 下注锅底 1.00\r\n3 号位, 开
始, 下注锅底 1.00\r\n4 号位, 开始, 下注锅底 1.00\r\n5 号位, 开始"}}
字段名Field Name 数据类型Data type 描述Description
44
s Int 子操作类型suboperation type
m String 主操作类型main operation type
d Object 数据结果data results
d数据结果返回值对应d data result return value correspondence
字段值Field Value 数据类型Data type 描述Description
code Int 错误码（查看附录说明）
Error code（see the appendix instructions）
data String
该牌局记录详情
record detail
3.3.6拉取玩家输赢排行 Get player profit rankings
描述Description
拉取玩家输赢排行(以日为单位)
Fetch players’ profit rankings (on a daily basis)
接口URL Interface URL
https://<server>/getRecordHandle?agent=XX&timestamp=XX&param=XX&key=XX
参数parameter
接口Interface：getRecordHandle
示例sample URL：
https://api.ky34.com/getRecordHandle?agent=10001&timestamp=1488791553051&param=nS42zzqT3fH
QLBEfbB4ok2c1MOpzIzy4VWru%2Fsv3jao88cUlrENQTXz6pAeS3I2F8SI5db8tTG20%0D%0AWQDY9LQPMW
9Xfy%2F1boz0REbE957bAvk%3D&key=8aeef9ff9b32f5f746ca663e8676a412
字段名
Field Name
描述
Description
数据类型
Data type
是否必须
Required
agent 代理编号（平台提供）
Agent number (platform provide)
String Y
timestamp
时间戳(Unix时间戳带上毫秒),获取
当前时间（1488781836949）
timestamp(Unix timestamp with
milliseconds), grab the current time
（1488781836949）
String Y
45
param
参数加密字符串param=（
s=12&dayTime=2022-10-06）
s：操作子类型:12
dayTime：查询日期
Encrypt.AESEncrypt(param,DESKey);
DESKey：平台提供
注: 请按照 AES-128-ECB 加密方式
parameter encrypted string param=（
s=12&dayTime=2022-10-06）
s: operate subtype : 12
dayTime: date
Encrypt.AESEncrypt（param, DESKey）;
DESKey: platform provide
Notes: please use AES-128-ECB
encrypt method
String Y
key
Md5校验字符串
Md5 check string
Encrypt.MD5(agent+timestamp+
MD5Key);
String Y
返回 Return
示例 Sample：
{"m":"/getRecordHandle","s":112,"d":{"code":0,"start":"2022-10-06 00:00:00","end":"2022-10-06
23:59:59","count":2,"list":{"Accounts":["1_1234","1_qatest02"],"TotalGames":[1,4],"ValidBet":["6.00","4
3.00"],"DeductGold":["0.30","1.00"],"ProfitGold":["5.70","-4.00"]}}}
字段名Field Name 数据类型Data type 描述Description
s Int 子操作类型suboperation type
m String 主操作类型main operation type
d Object 数据结果data results
d数据结果返回值对应d data result return value correspondence
字段值 Field Value 数据类型 Data type 描述 Description
code Int
错误码（查看附录说明）
Error code（see the appendix instructions
）
start String
查询起始时间
start time
end String
查询结束时间
end time
count Int 回传资料笔数
data total amount
list Object 数据列表
list数据结果返回值对应 list data result return value correspondence
Accounts String 会员账号
46
Player account
TotalGames String
游玩游戏个数
Played game amount
ValidBet Int 有效投注额
Effective bet
DeductGold Int 扣除金额
Deduced amount
ProfitGold String
会员当日总输赢
Player day total profit
3.3.7根据对局记录获取一段时间汇总数据 Get summarized game record
描述Description
拉取一段时间汇总数据
Fetch summarized data for a specific time period
接口URL Interface URL
https://<server>/getRecordHandle?agent=XX&timestamp=XX&param=XX&key=XX
参数parameter
接口Interface：getRecordHandle
示例sample URL：
https://api.ky34.com/getRecordHandle?agent=10001&timestamp=1488791553051&param=nS42zzqT3fH
QLBEfbB4ok2c1MOpzIzy4VWru%2Fsv3jao88cUlrENQTXz6pAeS3I2F8SI5db8tTG20%0D%0AWQDY9LQPMW
9Xfy%2F1boz0REbE957bAvk%3D&key=8aeef9ff9b32f5f746ca663e8676a412
字段名
Field Name
描述
Description
数据类型
Data type
是否必须
Required
agent 代理编号（平台提供）
Agent number (platform provide)
String Y
timestamp
时间戳(Unix时间戳带上毫秒),获取
当前时间（1488781836949）
timestamp(Unix timestamp with
milliseconds), grab the current time
（1488781836949）
String Y
param
参数加密字符串param=（
s=15&startTime=1666144818000&end
Time=1666147818000）
s：操作子类型:15
startTime：查询起始时间
endTime：查询结束时间
Encrypt.AESEncrypt(param,DESKey);
DESKey：平台提供
注: 请按照 AES-128-ECB 加密方式
parameter encrypted string param=（
s=15&startTime=1666144818000&end
Time=1666147818000）
s: operate subtype : 12
startTime: 1666144818000
endTime: 1666144818000
String Y
47
Encrypt.AESEncrypt（param, DESKey）;
DESKey: platform provide
Notes: please use AES-128-ECB
encrypt method
key
Md5校验字符串
Md5 check string
Encrypt.MD5(agent+timestamp+
MD5Key);
String Y
返回 Return
示例sample：
{"m":"/getRecordHandle","s":115,"d":{"code":0,"validBet":"60.00","winGold":"57.00","count":1}}
字段名Field Name 数据类型Data type 描述Description
s Int 子操作类型suboperation type
m String 主操作类型main operation type
d Object 数据结果data results
d数据结果返回值对应d data result return value correspondence
字段值 Field Value 数据类型 Data type 描述 Description
code Int
错误码（查看附录说明）
Error code（see the appendix instructions
）
validBet String
有效投注额
Effective bet
winGold String
输赢金额
Profit amount
count Int 回传资料汇总笔数
Data total amount
3.3.8生成加密的同桌玩家链接 Get same table player data link
描述Description
取得加密同桌玩家内迁链结
Get encrypted links of same table player data
接口URL Interface URL
https://<server>/getRecordHandle?agent=XX&timestamp=XX&param=XX&key=XX
参数parameter
接口Interface：getRecordHandle
示例sample URL：
https://api.ky34.com/getRecordHandle?agent=10001&timestamp=1488791553051&param=nS42zzqT3fH
QLBEfbB4ok2c1MOpzIzy4VWru%2Fsv3jao88cUlrENQTXz6pAeS3I2F8SI5db8tTG20%0D%0AWQDY9LQPMW
9Xfy%2F1boz0REbE957bAvk%3D&key=8aeef9ff9b32f5f746ca663e8676a412
字段名 描述 数据类型 是否必须
48
Field Name Description Data type Required
agent 代理编号（平台提供）
Agent number ( platform provide)
String Y
timestamp
时间戳(Unix时间戳带上毫秒),获取
当前时间（1488781836949）
timestamp(Unix timestamp with
milliseconds), grab the current time
（1488781836949）
String Y
param
参数加密字符串param=（
s=17&id=48866&gameid=220&accoun
ts=1_sh_test&gameuserno=50-166614
5108-309498-2）
s：操作子类型:17
gameid：查询游戏代号
accounts：查询帐号
gameuserno:查询局号
Encrypt.AESEncrypt(param,DESKey);
DESKey：平台提供
注: 请按照 AES-128-ECB 加密方式
parameter encrypted string param=（
s=17&id=48866&gameid=220&accoun
ts=1_sh_test&gameuserno=50-166614
5108-309498-2）
s: operate subtype : 17
gameid: game id
accounts: player
gameuserno: game number
Encrypt.AESEncrypt（param, DESKey）;
DESKey: platform provide
Notes: please use AES-128-ECB
encrypt method
String Y
key
Md5校验字符串
Md5 check string
Encrypt.MD5(agent+timestamp+
MD5Key);
String Y
返回 Return
示例 Sameple：
{"m":"/getRecordHandle","s":117,"d":{"code":0,"sametableusersURL":"/sameTable?params="}}
字段名Field Name 数据类型Data type 描述Description
s Int 子操作类型suboperation type
m String 主操作类型main operation type
d Object 数据结果data results
d数据结果返回值对应d data result return value correspondence
字段值Field Value 数据类型Data type 描述Description
49
code Int
错误码（查看附录说明）
Error code（see the appendix instructions
）
sametableusersURL String
内迁用链结
Links for embedding
3.3.9对局日志解析 Get game log link
描述Description
取得对局日志解析内迁链结
Get game log embedded link
接口URL Interface URL
https://<server>/getRecordHandle?agent=XX&timestamp=XX&param=XX&key=XX
参数parameter
接口Interface：getRecordHandle
示例sample URL：
https://api.ky34.com/getRecordHandle?agent=10001&timestamp=1488791553051&param=nS42zzqT3fH
QLBEfbB4ok2c1MOpzIzy4VWru%2Fsv3jao88cUlrENQTXz6pAeS3I2F8SI5db8tTG20%0D%0AWQDY9LQPMW
9Xfy%2F1boz0REbE957bAvk%3D&key=8aeef9ff9b32f5f746ca663e8676a412
字段名
Field Name
描述
Description
数据类型
Data type
是否必须
Required
agent 代理编号（平台提供）
Agent Number ( platform provide)
String Y
timestamp
时间戳(Unix时间戳带上毫秒),获取
当前时间（1488781836949）
timestamp(Unix timestamp with
milliseconds), grab the current time
（1488781836949）
String Y
param
参数加密字符串param=（
s=19&id=48866&serverID=220&accou
nt=sh_test&gameuserno=50-1666145
108-309498-2）
s：操作子类型:19
serverID：查询游戏代号
account:查询帐号
gameuserno:查询游戏局号
Encrypt.AESEncrypt(param,DESKey);
DESKey：平台提供
注: 请按照 AES-128-ECB 加密方式
parameter encrypted string param=（
s=19&id=48866&serverID=220&accou
nt=sh_test&gameuserno=50-1666145
108-309498-2）
s: operate subtype : 19
serverID: game id
account: player
gameuserno: game number
Encrypt.AESEncrypt（param, DESKey）;
DESKey: platform provide
String Y
50
Notes: please use AES-128-ECB
encrypt method
key
Md5校验字符串
Md5 check string
Encrypt.MD5(agent+timestamp+
MD5Key);
String Y
返回 Return
示例 Sample ：
{"m":"/getRecordHandle","s":119,"d":{"code":0,"gameLogURL":"/gameLogUrl?params="}}
字段名Field Name 数据类型Data type 描述Description
s Int 子操作类型suboperation type
m String 主操作类型main operation type
d Object 数据结果data results
d数据结果返回值对应d data result return value correspondence
字段值Field Value 数据类型Data type 描述Description
code Int
错误码（查看附录说明）
Error code（see the appendix instructions
）
gameLogURL String
内迁用链结
Links for embedding
3.3.10拉取分类统计游戏数据 Get categorized game statistic data
描述Description
拉取游戏数据分类统计
Fetch categorized statistic game data
接口URL Interface URL
https://<server>/getRecordHandle?agent=XX&timestamp=XX&param=XX&key=XX
参数parameter
接口：getRecordHandle
示例sample URL：
https://api.ky34.com/getRecordHandle?agent=10001&timestamp=1488791553051&param=nS42zzqT3fH
QLBEfbB4ok2c1MOpzIzy4VWru%2Fsv3jao88cUlrENQTXz6pAeS3I2F8SI5db8tTG20%0D%0AWQDY9LQPMW
9Xfy%2F1boz0REbE957bAvk%3D&key=8aeef9ff9b32f5f746ca663e8676a412
字段名
Field Name
描述
Description
数据类型
Data type
是否必须
Required
agent 代理编号（平台提供）
Agent number ( platform provide)
String Y
timestamp
时间戳(Unix时间戳带上毫秒),获取
当前时间（1488781836949）
timestamp(Unix timestamp with
milliseconds), grab the current time
String Y
51
（1488781836949）
param
参数加密字符串param=（
s=61&dayTime=2022-10-06）
s：操作子类型:61
dayTime：查询日期
Encrypt.AESEncrypt(param,DESKey);
DESKey：平台提供
注: 请按照 AES-128-ECB 加密方式
parameter encrypted string param=（
s=61&dayTime=2022-10-06）
s: operate subtype : 61
dayTime: date
Encrypt.AESEncrypt（param, DESKey）;
DESKey: platform provide
Notes: please use AES-128-ECB
encrypt method
String Y
key
Md5校验字符串
Md5 check string
Encrypt.MD5(agent+timestamp+
MD5Key);
String Y
返回 Return
示例 Sample：
{"m":"/getRecordHandle","s":161,"d":{"code":0,"start":"2022-10-06 00:00:00","end":"2022-10-06
23:59:59","data":[{"game_type":"棋牌类
","lostNum":3,"lostGold":"-23.00","WinGold":"24.70","winNum":2,"cellScore":"49.00"}]}}
字段名Field Name 数据类型Data type 描述Description
s Int 子操作类型suboperation type
m String 主操作类型main operation type
d Object 数据结果data results
d数据结果返回值对应d data result return value correspondence
字段值Field Value 数据类型Data type 描述Description
code Int
错误码（查看附录说明）
Error code（see the appendix instructions
）
start String
查询起始时间
start time
end String
查询结束时间
end time
data Array 数据列表
data数据结果返回值对应 data result return value correspondence
game_type String
游戏类型
Game type
52
lostNum Int 输次数统计
Lost game numbers
lostGold String
输金额统计
Lost gold
WinGold String
赢金额统计
Win gold
winNum Int 赢次数统计
Win game numbers
cellScore String
有效投注额统计
Effective bet
3.3.11 拉取百人游戏下注点列表 Get bet points list of baccarat-style game
描述Description
拉取百人游戏下注点列表
Fetch bet points list for the baccarat-style game
接口URL Interface URL
https://<server>/getRecordHandle?agent=XX&timestamp=XX&param=XX&key=XX
参数parameter
接口Interface：getRecordHandle
示例sample URL：
https://api.ky34.com/getRecordHandle?agent=10001&timestamp=1488791553051&param=nS42zzqT3fH
QLBEfbB4ok2c1MOpzIzy4VWru%2Fsv3jao88cUlrENQTXz6pAeS3I2F8SI5db8tTG20%0D%0AWQDY9LQPMW
9Xfy%2F1boz0REbE957bAvk%3D&key=8aeef9ff9b32f5f746ca663e8676a412
字段名
Field Name
描述
Description
数据类型
Data type
是否必须
Required
agent 代理编号（平台提供）
Agent number ( platform provide)
String Y
timestamp
时间戳(Unix时间戳带上毫秒),获取
当前时间（1488781836949）
timestamp(Unix timestamp with
milliseconds), grab the current time
（1488781836949）
String Y
param
参数加密字符串param=（
s=13&account=test1&kindID=1930&re
cordID=512801）
s：操作子类型:13
account：查询帐号
kindID: 游戏编号
recordID: 该局游戏原始编号
Encrypt.AESEncrypt(param,DESKey);
DESKey：平台提供
注: 请按照 AES-128-ECB 加密方式
parameter encrypted string param=（
s=13&account=test1&kindID=1930&re
cordID=512801）
s: operate subtype : 13
String Y
53
account: player
kindID: game id
recordID: original game id
Encrypt.AESEncrypt（param, DESKey）;
DESKey: platform provide
Notes: please use AES-128-ECB
encrypt method
key
Md5校验字符串
Md5 check string
Encrypt.MD5(agent+timestamp+
MD5Key);
String Y
返回 Return
示例 Sample：
{"m":"/getRecordHandle","s":113,"d":{"code":0,"data":{"2":500,"7":800,"31":800}}}
字段名Field Name 数据类型Data type 描述Description
s Int 子操作类型suboperation type
m String 主操作类型main operation type
d Object 数据结果data results
d数据结果返回值对应d data result return value correspondence
字段值Field Value 数据类型Data type 描述Description
code Int
错误码（查看附录说明）
Error code（see the appendix instructions
）
data Object 数据列表
data数据结果返回值对应 data result return value correspondence
参数栏位 Key field String
下注点
bet position number
值栏位 Value field String
下注金额
bet amount
3.3.12 代理拉取前端地址ws、ld地址 Get front end ws and ld address
描述Description
代理拉取前端地址ws、ld地址
Fetch the front end ws and ld url
接口URL Interface URL
https://<server>/getRecordHandle?agent=XX&timestamp=XX&param=XX&key=XX
参数parameter
接口Interface：getRecordHandle
54
示例sample URL：
https://api.ky34.com/getRecordHandle?agent=10001&timestamp=1488791553051&param=nS42zzqT3fH
QLBEfbB4ok2c1MOpzIzy4VWru%2Fsv3jao88cUlrENQTXz6pAeS3I2F8SI5db8tTG20%0D%0AWQDY9LQPMW
9Xfy%2F1boz0REbE957bAvk%3D&key=8aeef9ff9b32f5f746ca663e8676a412
字段名
Field Name
描述
Description
数据类型
Data type
是否必须
Required
agent 代理编号（平台提供）
Agent number ( platform provide)
String Y
timestamp
时间戳(Unix时间戳带上毫秒),获取
当前时间（1488781836949）
timestamp(Unix timestamp with
milliseconds), grab the current time
（1488781836949）
String Y
param
参数加密字符串param=（
s=62&account=test1&KindID=1930）
s：操作子类型:62
account：查询帐号
kindID: 游戏编号
Encrypt.AESEncrypt(param,DESKey);
DESKey：平台提供
注: 请按照 AES-128-ECB 加密方式
parameter encrypted string param=（
s=62&account=test1&KindID=1930）
s: operate subtype : 62
KindID: game id
Encrypt.AESEncrypt（param, DESKey）;
DESKey: platform provide
Notes: please use AES-128-ECB
encrypt method
String Y
key
Md5校验字符串
Md5 check string
Encrypt.MD5(agent+timestamp+
MD5Key);
String Y
返回 Return
示例 Sample：
{"m":"/getRecordHandle","d":{"code":0,"url":"https://h5.ky34.com/index.html?account=10001_111111&
token=FBE54A7273EE4F15B363C3F98F32B19F&lang=zh-CN&KindID=1930"},"s":162}
字段名Field Name 数据类型Data type 描述Description
s Int 子操作类型suboperation type
m String 主操作类型main operation type
d Object 数据结果data results
d数据结果返回值对应d data result return value correspondence
字段值Field Value 数据类型Data type 描述Description
55
url String
游戏URL
Game URL
大厅或房间选择界面的返回按钮，如果
期望跳转到自定义的URL，可以在游戏
地址后面增加&backUrl=自定义URL（非
必要,如果不拼接那么使用默认值，不
会影响用户正常使用）
If you would like to redirect to a custom
URL by the button on the lobby or room
selection interface, you may add
“&backUrl=customURL” at the end of the
game address. (This is optional, and if not
appended, the default value will be used,
which will not affect normal user usage.)
code Int
错误码（查看附录说明）
Error code（see the appendix instructions
）
3.3.13开元体育根据修改日期获取注单列表 KY sport order
描述Description
此接口用来查询开元体育注单列表(最多拉取一天)
Get Sport Orders by time(Pull up to 1 days)
接口URL Interface URL
https://<server>/sportRecordHandle?agent=XX&timestamp=XX&param=XX&key=XX
参数parameter
接口Interface：sportRecordHandle
示例sample URL：
https://api.ky34.com/sportRecodeHandle?agent=64874&timestamp=1658199185000&param=6LJXcCp7%
2F2G7JS1FBS6GA6g9NoAPx%2B%2FTmJlJWno23PNbFF3qgx3lCiRKAQp%2F%2FgpuU5pE8hjumU7BnLddU2
2gcg%3D%3D&key=07e821f65827e4a02a164c2cce1150a9
字段名
Field Name
描述
Description
数据类型
Data type
是否必须
Required
agent 代理编号（平台提供）
Agent number ( platform provide)
String Y
timestamp
时间戳(Unix时间戳带上毫秒),获取当
前时间（1488781836949）
timestamp(Unix timestamp with
milliseconds), grab the current time
（1488781836949）
String Y
param
参数加密字符串param=（
s=0&startTime=1488781836949&endTi
me=1488781886949）
s：操作子类型:0
startTime: 查询起始时间
endTime: 查询结束时间
）
Encrypt.AESEncrypt(param,DESKey);
DESKey：平台提供
parameter encrypted string param =（
s=0&startTime=1488781836949&endTi
String Y
56
me=1488781886949）
s：operate subtype：0
startTime: startTime
endTime: 查询结束时间
）
Encrypt.AESEncrypt(param,DESKey);
DESKey：platform provide
key
Md5校验字符串
Md5 check string
Encrypt.MD5(agent+timestamp+
MD5Key);
String Y
返回Return
示例Sample：
{"s":100,"m":"/ sportRecordHandle ",
"d":{"code":0,"start":"1488781836949","end":"1488781886949","list":{ }}
字段名Field Name 数据类型Data type 描述Description
s Int 子操作类型suboperation type
m String 主操作类型main operation type
d Object 数据结果data results
d数据结果返回值对应d data result return value correspondence
字段值Field Name 数据类型Data type 描述Description
start String
查询起始时间
Search startTime
end String
查询结束时间
Search endTime
count Int 注单数量
Order count
code Int
错误码（查看附录说明）
errorCode（see the appendix instructions
）
list Array 注单list
list数据结果返回值对应list data result return value correspondence
agent String
代理商编号
Agent number
account String
会员账号
Member account
refNo String
投注编号
Reference number of the white label
system
sportsType String
运动类型，请参照4.6
SportType, please ref 4.6
57
odds decimal 下注选项的赔率
The Odds that player placed on
oddsStyle String
盘口资讯
The Odds Style that player placed on
M : Malay odds
H : HongKong odds
E : Euro odds
I : Indonesia odds
stake decimal 玩家的投注金
The stake that player placed on
currency String
币别
currency
status Int
注单的状态，请参照4.7.1
The Status of Player's bets, please ref
4.7.1
winlost decimal
玩家的注单净赢
The Winlose of Player, do not include
player's stake
isHalfWonLose bool 是否为半场获胜或半场失败
Is half won or half lose
isLive String
是否为现场赛事(滚球/赛前)
Is Live Match or not
maxWinWithoutActualStake String
注单未清算，将回传当前不包含注金
(ActualStake)的最大净赢。 当注单清算
时，将回传当前不包含注金
(ActualStake)的预估净赢。
The max wining of player withour actual
stake
ip String
玩家下注的ip
The IP that player placed bet
voidReason String
注单退款/取消之原因
The void reason of the sports bet
orderTime DateTime
玩家下注的时间
The Time that player place bet
winLostDate DateTime
注单的归帐日
The Time use to do accounting on this
bet
settleTime DateTime
注单结算的时间
The order’s settle time
modifyDate DateTime
修改日期
The Time that this bet been modified
createTime DateTime
订单建立时间
The Time that this create
58
profitReportDate DateTime
注单的归帐日
The Time use to do accounting on this
bet
gameNo String
游戏局号
Game Number
gameID Integer
游戏唯一识别码
Game ID
validSettleStakeAmount String
玩家有效投注额
The Turnover of Playe
settleAmount String
正常结算返还
Normal settlement return amount
cashOutTotalStake decimal 提前结算金额
Early settlement amount
cashOutPayoutStake decimal 提前结算返还
Early settlement return amount
cashOutCount Integer
提前结算次数
Early settlement frequency
betType String
投注类型
Bet Type
isRollback Integer
是否为二次结算 (0为否, 1 为是)
Is rollback (0: no, 1: yes)
subBet Array
下注场次资讯
Single bet will only got one subBet for the
bet detail, and Mixpalay will have mutiple
subBets
subBet数据结果返回值对应subBet data result return value correspondence
id Integer
流水编号
serial number
productType String
游戏产品类别
The Product Category of the casino game
that player placed
refNo String
投注编号
Reference number of the white label
system
betOption String
会员在此投注中选择的选项
player bet option
marketType String
运动盘口，请参照4.8
MarketType of Subbet, please ref 4.8
sportType String
运动类型，请参照4.6
SportType, please ref 4.6
hdp decimal 下注选项的让球数
Handicap Point
59
odds String
下注选项的赔率
The Odds that player placed on
league String
本场赛事的联赛名称
Name of league of the match
match String
赛事的名称
Name of match
status Int 结算结果，请参照4.7.2
The subbet status, please ref 4.7.2
liveScore String
如果为滚球赛事，将记录玩家下注时的
比分
If the match is a live match, this field will
record the score at the moment when
player placed bet
winLostDate DateTime
注单的归帐日
The Time use to do accounting on this
bet
kickOffTime DateTime
开赛时间
The Time when the game start
createTime DateTime
订单建立时间
The Time that this create
isHalfWonLose bool 是否为半场获胜或半场失败
Is half won or half lose
3.3.14虚拟体育根据修改日期获取注单列表 virtual sport order
描述Description
此接口用来查询虚拟体育注单列表(最多拉取一天)
Get Virtual Sport Orders by time(Pull up to 1 days)
接口URL Interface URL
https://<server>/sportRecordHandle?agent=XX&timestamp=XX&param=XX&key=XX
参数parameter
接口Interface：sportRecordHandle
示例sample URL：
https://api.ky34.com/sportRecodeHandle?agent=64874&timestamp=1658199185000&param=6LJXcCp7%
2F2G7JS1FBS6GA6g9NoAPx%2B%2FTmJlJWno23PNbFF3qgx3lCiRKAQp%2F%2FgpuU5pE8hjumU7BnLddU2
2gcg%3D%3D&key=07e821f65827e4a02a164c2cce1150a9
字段名
Field Name
描述
Description
数据类型
Data type
是否必须
Required
agent 代理编号（平台提供）
Agent number ( platform provide)
String Y
timestamp
时间戳(Unix时间戳带上毫秒),获取当
前时间（1488781836949）
timestamp(Unix timestamp with
milliseconds), grab the current time
（1488781836949）
String Y
60
param
参数加密字符串param=（
s=1&startTime=1488781836949&endTi
me=1488781886949）
s：操作子类型:1
startTime: 查询起始时间
endTime: 查询结束时间
）
Encrypt.AESEncrypt(param,DESKey);
DESKey：平台提供
parameter encrypted string param =（
s=1&startTime=1488781836949&endTi
me=1488781886949）
s：operate subtype：1
startTime: startTime
endTime: 查询结束时间
）
Encrypt.AESEncrypt(param,DESKey);
DESKey：platform provide
String Y
key
Md5校验字符串
Md5 check string
Encrypt.MD5(agent+timestamp+
MD5Key);
String Y
返回Return
示例Sample：
{"s":101,"m":"/ sportRecordHandle ", "d":{"code":0,"start":"1488781836949","end":"1488781886949",
count :0 , "list":{ }}
字段名Field Name 数据类型Data type 描述Description
s Int 子操作类型sub operation type
m String 主操作类型main operation type
d Object 数据结果data results
d数据结果返回值对应d data result return value correspondence
字段值Field Name 数据类型Data type 描述Description
start String
查询起始时间
Search startTime
end String
查询结束时间
Search endTime
count Int 注单数量
Order count
code Int
错误码（查看附录说明）
errorCode（see the appendix instructions
）
list Array 注单list
list数据结果返回值对应list data result return value correspondence
61
a
g
e
n
t
S
t
rin
g
代
理
商
编
号
A
g
e
n
t
n
u
m
b
e
r
a
c
c
o
u
n
t
S
t
rin
g
会
员
账
号
M
e
m
b
e
r
a
c
c
o
u
n
t
r
e
f
N
o
S
t
rin
g
投
注
编
号
R
e
f
e
r
e
n
c
e
n
u
m
b
e
r
o
f
t
h
e
w
hit
e la
b
el system
o
d
d
s
d
e
cim
al 下
注
选
项
的
赔
率
T
h
e
O
d
d
s
t
h
a
t
pla
y
e
r
pla
c
e
d
o
n
o
d
d
s
S
t
yle
S
t
rin
g
盘
口
资
讯
T
h
e
O
d
d
s
S
t
yle
t
h
a
t
pla
y
e
r
pla
c
e
d
o
n
e
u
3: E
u
r
o
p
e
a
n
D
e
cim
als
(
0.0
0
0
)
s
t
a
k
e
d
e
cim
al 玩
家
的
投
注
金
T
h
e
s
t
a
k
e
t
h
a
t
pla
y
e
r
pla
c
e
d
o
n
c
u
r
r
e
n
c
y
S
t
rin
g
币
别
C
u
r
r
e
n
c
y
s
t
a
t
u
s
S
t
rin
g
注
单
的
状
态
T
h
e
S
t
a
t
u
s
o
f
Pla
y
e
r's
b
e
t
s
S
=
S
e
t
tle
d
,
P
=
Pla
c
e
d
,
V
=
V
oid
e
d
winlo
s
s
d
e
cim
al 玩
家
的
注
单
净
赢
T
h
e
Winlo
s
s
o
f
Pla
y
e
r,
d
o
n
o
t in
clu
d
e
pla
y
e
r's
s
t
a
k
e ip String 玩家下注的ip The IP that pla
y
e
r
pla
c
e
d
b
e
t
o
r
d
e
r
Tim
e
D
a
t
e
Tim
e
玩
家
下
注
的
时
间
T
h
e
Tim
e
t
h
a
t
pla
y
e
r
pla
c
e
b
e
t
s
e
t
tle
Tim
e
D
a
t
e
Tim
e
注
单
结
算
的
时
间
T
h
e
o
r
d
e
r
’
s
s
e
t
tle
tim
e
c
r
e
a
t
e
Tim
e
D
a
t
e
Tim
e
订
单
建
立
时
间
T
h
e
Tim
e
t
h
a
t
t
his
c
r
e
a
t
e
g
a
m
e
N
o
S
t
rin
g
游
戏
局
号
G
a
m
e
N
u
m
b
e
r
g
a
m
eID In
t
e
g
e
r
游
戏
唯
一
识
别
码
G
a
m
e ID
p
r
o
d
u
c
t
C
o
d
e
S
t
rin
g
产
品
代
码，请
参
照
4.9
A
u
niq
u
e id
e
n
tifie
r
a
s
sig
n
e
d
t
o
a
p
r
o
d
u
c
t
t
h
a
t
pla
y
e
r
pla
c
e
d
,
ple
a
s
e
r
e
f
4.9
b
e
t
O
u
t
c
o
m
e
S
t
rin
g
结
算
结
果
T
h
e
s
e
t
tle
m
e
n
t
o
u
t
c
o
m
e
W
o
n
,
L
o
s
t
o
r
N
U
L
L
(
p
e
n
din
g
)
m
a
t
c
hId In
t
e
g
e
r
赛
事
的ID
U
niq
u
e
n
u
m
b
e
r id
e
n
tif
yin
g
t
h
e
m
a
t
c
h
6
2
eventDate String
开赛时间
The Time when the game start
betDescription String
下注描述
Description of the bet placed
betEventID Integer
事件ID
Unique number identifying the event
being bet on
betEvent String
事件名称
Name of the event being bet on
betMarketID Integer
盘口ID
Unique identifier for this market
betMarket String
盘口
Name of the market being bet on
betSelectionID Integer
会员在此投注中选择的选项ID
Unique number identifying the selection
being bet on
betSelection String
会员在此投注中选择的选项
Name of the selection being bet on
3.3.15开元体育根据注单局号获取资讯 KY sport specific order
描述Description
此接口用来依照局号查询开元体育注单资讯
Get Sport Orders by gameuserno
接口URL Interface URL
https://<server>/sportRecordHandle?agent=XX&timestamp=XX&param=XX&key=XX
参数parameter
接口Interface：sportRecordHandle
示例sample URL：
https://api.ky34.com/sportRecodeHandle?agent=64874&timestamp=1658199185000&param=6LJXcCp7%
2F2G7JS1FBS6GA6g9NoAPx%2B%2FTmJlJWno23PNbFF3qgx3lCiRKAQp%2F%2FgpuU5pE8hjumU7BnLddU2
2gcg%3D%3D&key=07e821f65827e4a02a164c2cce1150a9
字段名
Field Name
描述
Description
数据类型
Data type
是否必须
Required
agent 代理编号（平台提供）
Agent number ( platform provide)
String Y
timestamp
时间戳(Unix时间戳带上毫秒),获取当
前时间（1488781836949）
timestamp(Unix timestamp with
milliseconds), grab the current time
（1488781836949）
String Y
63
param
参数加密字符串param=（s=3&
gameuserno= 1475213935815688425）
s：操作子类型:3
gameuserno: 注单局号
）
Encrypt.AESEncrypt(param,DESKey);
DESKey：平台提供
parameter encrypted string param =（
s=3&gameuserno=
1475213935815688425）
(
s：operate subtype：3
gameuserno: 注单局号
）
Encrypt.AESEncrypt(param,DESKey);
DESKey：platform provide
String Y
key
Md5校验字符串
Md5 check string
Encrypt.MD5(agent+timestamp+
MD5Key);
String Y
返回Return
示例Sample：
{"s":103,"m":"/ sportRecordHandle ", "d":{"code":0,"count":0,,"list":[] }
字段名Field Name 数据类型Data type 描述Description
s Int 子操作类型suboperation type
m String 主操作类型main operation type
d Object 数据结果data results
d数据结果返回值对应d data result return value correspondence
字段值Field Name 数据类型Data type 描述Description
count Int 注单数量
Order count
code Int
错误码（查看附录说明）
errorCode（see the appendix instructions
）
list Array 注单list
list数据结果返回值对应list data result return value correspondence
agent String
代理商编号
Agent number
account String
会员账号
Member account
refNo String
投注编号
Reference number of the white label
system
64
sportsType String
运动类型，请参照4.6
SportType, please ref 4.6
odds decimal 下注选项的赔率
The Odds that player placed on
oddsStyle String
盘口资讯
The Odds Style that player placed on
M : Malay odds
H : HongKong odds
E : Euro odds
I : Indonesia odds
stake decimal 玩家的投注金
The stake that player placed on
currency String
币别
currency
status Int
注单的状态，请参照4.7.1
The Status of Player's bets, please ref
4.7.1
winlost decimal
玩家的注单净赢
The Winlose of Player, do not include
player's stake
isHalfWonLose bool 是否为半场获胜或半场失败
Is half won or half lose
isLive String
是否为现场赛事(滚球/赛前)
Is Live Match or not
maxWinWithoutActualStake String
注单未清算，将回传当前不包含注金
(ActualStake)的最大净赢。 当注单清算
时，将回传当前不包含注金
(ActualStake)的预估净赢。
The max wining of player withour actual
stake
ip String
玩家下注的ip
The IP that player placed bet
voidReason String
注单退款/取消之原因
The void reason of the sports bet
orderTime DateTime
玩家下注的时间
The Time that player place bet
winLostDate DateTime
注单的归帐日
The Time use to do accounting on this
bet
settleTime DateTime
注单结算的时间
The order’s settle time
modifyDate DateTime
修改日期
The Time that this bet been modified
65
createTime DateTime
订单建立时间
The Time that this create
profitReportDate DateTime
注单的归帐日
The Time use to do accounting on this
bet
gameNo String
游戏局号
Game Number
gameID Integer
游戏唯一识别码
Game ID
validSettleStakeAmount String
玩家有效投注额
The Turnover of Playe
settleAmount String
正常结算返还
Normal settlement return amount
cashOutTotalStake decimal 提前结算金额
Early settlement amount
cashOutPayoutStake decimal 提前结算返还
Early settlement return amount
cashOutCount Integer
提前结算次数
Early settlement frequency
betType String
投注类型
Bet Type
isRollback Integer
是否为二次结算 (0为否, 1 为是)
Is rollback (0: no, 1: yes)
subBet Array
下注场次资讯
Single bet will only got one subBet for the
bet detail, and Mixpalay will have mutiple
subBets
subBet数据结果返回值对应subBet data result return value correspondence
id Integer
流水编号
serial number
productType String
游戏产品类别
The Product Category of the casino game
that player placed
refNo String
投注编号
Reference number of the white label
system
betOption String
会员在此投注中选择的选项
player bet option
marketType String
运动盘口，请参照4.8
MarketType of Subbet, please ref 4.8
sportType String
运动类型，请参照4.6
SportType, please ref 4.6
66
hdp decimal 下注选项的让球数
Handicap Point
odds String
下注选项的赔率
The Odds that player placed on
league String
本场赛事的联赛名称
Name of league of the match
match String
赛事的名称
Name of match
status Int 结算结果，请参照4.7.2
The subbet status, please ref 4.7.2
liveScore String
如果为滚球赛事，将记录玩家下注时的
比分
If the match is a live match, this field will
record the score at the moment when
player placed bet
winLostDate DateTime
注单的归帐日
The Time use to do accounting on this
bet
kickOffTime DateTime
开赛时间
The Time when the game start
createTime DateTime
订单建立时间
The Time that this create
isHalfWonLose bool 是否为半场获胜或半场失败
Is half won or half lose
3.4 多币种支持Multi-Currency Principle
支持所有币种用户进行游戏，非人民币币种代理接通API时需要额外做以下工作：
Supports all currency users to play games, Non-rmb currency agents need to do the following extra work
when they connect to the API:
● 通知我方开通所需币种对应线路，我方目前仅限制台湾地区用户不可登入
Inform us to open the needed currency route, we will restrict only the user who use this kind of
currency will login (We currently only restrict users from Taiwan to not be able to log in)
● 按照附录“4.5-游戏币兑换比例”在会员上下分时将对应金额货币转换成游戏币后调用上下分接
口（注：传入游戏币2位小数以后的部分会被舍弃）
According to the appendix instructions “4.5 Game Currency Exchange Ratio”, when members charging
points or refunding, invoke the charge points or refund interface after convert the corresponding
amount currency into game currency(the game currency that turned in，2 decimal places will be
discarded)
● 我方后台和对局数据均按照游戏币结算，代理交收时，需交收对应币种金额=游戏币结算金额/
游戏币兑换比例
Our background and match data are settled according to the game currency, when agency deliver, the
corresponding currency amount they need to deliver game currency settlement amount/ game
currency exchange ratio.
四、附录Appendix
4.1 KindID对应游戏Corresponding Games
KindID 游戏Games 开发状态Development status
67
0 大厅Hall 完成Developed
620 德州扑克
Texas Hold'em Poker
完成Developed
720 二八杠Two-Eight Bar 完成Developed
830 抢庄牛牛Banker Bull-Bull 完成Developed
220 炸金花Golden Flower 完成Developed
860 三公Three-Facecard 完成Developed
900 押庄龙虎Dragon-Tiger 完成Developed
600 21点Black Jack 完成Developed
870 通比牛牛Casino Bull-Bull 完成Developed
230 极速炸金花
Speed Golden Flower
完成Developed
730 抢庄牌九Paigow 完成Developed
630 十三水Pineapple Poker 完成Developed
610 斗地主Landlord 完成Developed
910 百家乐Baccarat 完成Developed
920 森林舞会Forest Party 完成Developed
930 百人牛牛
Niu–niu for thousands person
完成Developed
1950 万人炸金花
Golden Flower for thousands person
完成Developed
650 血流成河Bleeding Mahjong 完成Developed
890 看牌抢庄牛牛
Banker Bull-Bull After Check Card
完成Developed
740 二人麻将2 Persons’ Mahjong 完成Developed
1350 幸运转盘Lucky Dial
完成（不能单独接入）
Developed（Cannot be accessed
separately）
1940 金鲨银鲨
Gold Shark & Silver Shark
完成Developed
1960 奔驰宝马Benz & BMW 完成Developed
1980 百人骰宝Sic Bo 完成Developed
1810 单挑牛牛1v1 Bull-Bull 完成Developed
1990 炸金牛Golden Bull 完成Developed
1850 押宝抢庄牛牛
Bet 3 Players Bull-Bull
完成Developed
68
510 红包捕鱼Fishing 完成Developed
1355 搏一搏Give A Bet
完成（不能单独接入）
Developed（Cannot be accessed
separately）
1970 五星宏辉Five Stars 完成Developed
1860 赌场扑克Casino Poker 完成Developed
1370 港式梭哈Hong Kong Stud 完成Developed
1690 血战骰宝Karmic SicBo 完成Developed
1890 水果机Fruit Machine 完成Developed
1610 幸运夺宝Lucky Treasure
完成（不能单独接入）Developed（Cannot
be accessed separately）
1930 鱼虾蟹Fish-Prawn-Crab Dice 完成Developed
8130 跑得快Run Fast 完成Developed
950 红黑大战Red & Black War 完成Developed
840 疯狂抢庄牛牛
Crazy Banker Bull-Bull
完成Developed
520 李逵捕鱼LK Fishing 完成Developed
530 金元捕鱼ChinYuan Fishing 完成Developed
540 捕鱼传说BYCS Fishing 完成Developed
3001 极速百家乐Speed Baccarat 完成Developed
2890
看牌抢庄三公
Three-Facecard After Check Card After
Check Card
完成Developed
2002 梭哈德州扑克All-In or Fold 完成Developed
3002 金球银球
World Cup Golden Ball
完成Developed
3003 十倍牛牛Ten Times Bull-Bull 完成Developed
550 富贵金龙Golden Dragon 完成Developed
7470 KY体育KY Sport 完成Developed
3005 欧式轮盘European Roulette 完成Developed
2005 富贵三张Three Card Poker 完成Developed
3006 官人坏坏百J乐H-Baccarat 完成Developed
2007 闪电21点Lightning BlackJack 完成Developed
2008 终极德州扑克Ultimate Texas 完成Developed
7479 炸财神 Bombing Fortune 完成Developed
7484 幸运熊猫Lucky Panda 完成Developed
69
7485 财神发发发Fortune FaFaFa 完成Developed
7471 麻将胡了 3Mahjong Master 完成Developed
2012 抖音牛牛TikTok Bull-Bull 完成Developed
2011 掼蛋GuanDan 完成Developed
2013 土耳其麻将Okey 完成Developed
2014 极速牛牛 Speed Bull-Bulll 完成Developed
2016 射门之王 Soccer King 完成Developed
931
黑神话百人牛牛
Black Myth Niu-niu For Thousands
Person
完成Developed
1602 逃离五指山
Escape from Wuzhishan
完成Developed
7491 西游:黑悟空
Monkey king : black wukong
完成Developed
2010 癞子牛牛
Lai Zi Niu-niu
完成Developed
2015 比大小
HI-LO
完成Developed
2017 铸剑
Forging a sword
完成Developed
3011 澳门百家乐幸运六
Macau Baccarat Lucky Six
完成Developed
7492 三国
Three Kindoms
完成Developed
7498 后羿射日
HOUYI SHOT THE SUNS
完成Developed
7488 喜相逢
Encounter
完成Developed
7480 大力神锤
King Of The Hammer
完成Developed
7494 找地鼠
LOOKING FOR GOPHERS
完成Developed
7495 新年到戳戳乐
POKING FORTUNE
完成Developed
7497 水果炸弹
FRUIT BOMBS
完成Developed
7486 王者荣耀
KING OF GLORY
完成Developed
7496 生存者
SURVIVOR
完成Developed
70
7489 矮人矿坑
GOLD DIGGER
完成Developed
7481 祥狮献瑞
Tigerlions Lead To Auspicious
完成Developed
7487 荒野逃生
BATTLE ROYALE
完成Developed
7482 财神到
The God Of Fortune Arrives
完成Developed
7483 金虎报吉
Golden Tiger
完成Developed
7499 雀神
MAHJONG GOD
完成Developed
7493 鬼吹灯
CANDLE IN THE TOMB
完成Developed
7502
龙年行大运
GREAT LUCK IN THE YEAR OF THE
DRAGON
完成Developed
4.2 KindID对应房间名 Corresponding Game’s room
KindId ServerId 房间Room
620 3600 德州扑克新手房
Texas Hold'em Poker Fresh Room
620 3601 德州扑克初级房
Texas Hold'em Poker Beginner’s Room
620 3602 德州扑克中级房
Texas Hold'em Poker Intermediate Room
620 3603 德州扑克高级房
Texas Hold'em Poker Advanced Room
620 3700 德州扑克财大气粗房
Texas Hold'em Poker Ante Room Very Rich
620 3701 德州扑克腰缠万贯房
Texas Hold'em Poker Ante Room Very Wealthy
620 3702 德州扑克挥金如土房
Texas Hold'em Poker Ante Room Spend Money Like Water
620 3703 德州扑克富贵逼人房
Texas Hold'em Poker Ante Room Wealthy And Honor
720 7201
二八杠体验房
Two-Eight Bar Fresh Room
720 7202
二八杠初级房
Two-Eight Bar Beginner’s Room
71
7
2
0
7
2
0
3
二
八
杠
中
级
房
Tw
o
-
Eig
h
t
B
a
r In
t
e
r
m
e
dia
t
e
R
o
o
m
7
2
0
7
2
0
4
二
八
杠
高
级
房
Tw
o
-
Eig
h
t
B
a
r
A
d
v
a
n
c
e
d
R
o
o
m
7
2
0
7
2
0
5
二
八
杠
至
尊
房
Tw
o
-
Eig
h
t
B
a
r
M
a
s
t
e
r
r
o
o
m
7
2
0
7
2
0
6
二
八
杠
王
者
房
Tw
o
-
Eig
h
t
B
a
r
Kin
g
’
s
R
o
o
m
8
3
0
8
3
0
1
抢
庄
牛
牛
体
验
房
B
a
n
k
e
r
B
ullB
ull F
r
e
s
h
R
o
o
m
8
3
0
8
3
0
2
抢
庄
牛
牛
初
级
房
B
a
n
k
e
r
B
ullB
ull B
e
gin
n
e
r
’
s
R
o
o
m
8
3
0
8
3
0
3
抢
庄
牛
牛
中
级
房
B
a
n
k
e
r
B
ullB
ull In
t
e
r
m
e
dia
t
e
R
o
o
m
8
3
0
8
3
0
4
抢
庄
牛
牛
高
级
房
B
a
n
k
e
r
B
ullB
ull A
d
v
a
n
c
e
d
R
o
o
m
8
3
0
8
3
0
5
抢
庄
牛
牛
至
尊
房
B
a
n
k
e
r
B
ullB
ull M
a
s
t
e
r
r
o
o
m
8
3
0
8
3
0
6
抢
庄
牛
牛
王
者
房
B
a
n
k
e
r
B
ullB
ull Kin
g
’
s
R
o
o
m
2
2
0
2
2
0
1
炸
金
花
体
验
房
G
old
e
n
Flo
w
e
r
F
r
e
s
h
R
o
o
m
2
2
0
2
2
0
2
炸
金
花
初
级
房
G
old
e
n
Flo
w
e
r
B
e
gin
n
e
r
’
s
R
o
o
m
2
2
0
2
2
0
3
炸
金
花
中
级
房
G
old
e
n
Flo
w
e
r In
t
e
r
m
e
dia
t
e
R
o
o
m
2
2
0
2
2
0
4
炸
金
花
高
级
房
G
old
e
n
Flo
w
e
r
A
d
v
a
n
c
e
d
R
o
o
m
8
6
0
8
6
0
1
三
公
体
验
房
T
h
r
e
e
-
F
a
c
e
c
a
r
d
F
r
e
s
h
R
o
o
m
8
6
0
8
6
0
2
三
公
初
级
房
T
h
r
e
e
-
F
a
c
e
c
a
r
d
B
e
gin
n
e
r
’
s
R
o
o
m
8
6
0
8
6
0
3
三
公
中
级
房
T
h
r
e
e
-
F
a
c
e
c
a
r
d In
t
e
r
m
e
dia
t
e
R
o
o
m
8
6
0
8
6
0
4
三
公
高
级
房
T
h
r
e
e
-
F
a
c
e
c
a
r
d
A
d
v
a
n
c
e
d
R
o
o
m
8
6
0
8
6
0
5
三
公
至
尊
房
T
h
r
e
e
-
F
a
c
e
c
a
r
d
M
a
s
t
e
r
r
o
o
m
8
6
0
8
6
0
6
三
公
王
者
房
T
h
r
e
e
-
F
a
c
e
c
a
r
d
Kin
g
’
s
R
o
o
m
9
0
0
9
0
0
1
龙
虎
体
验
房
7
2
D
r
a
g
o
n
-
Tig
e
r
F
r
e
s
h
R
o
o
m
9
0
0
9
0
0
2
龙
虎
初
级
房
D
r
a
g
o
n
-
Tig
e
r
B
e
gin
n
e
r
’
s
R
o
o
m
9
0
0
9
0
0
3
龙
虎
中
级
房
D
r
a
g
o
n
-
Tig
e
r In
t
e
r
m
e
dia
t
e
R
o
o
m
9
0
0
9
0
0
4
龙
虎
高
级
房
D
r
a
g
o
n
-
Tig
e
r
A
d
v
a
n
c
e
d
R
o
o
m
6
0
0
6
0
0
1
2
1
点
体
验
房
T
h
e
Bla
c
k
J
a
c
k
F
r
e
s
h
R
o
o
m
6
0
0
6
0
0
2
2
1
点
初
级
房
T
h
e
Bla
c
k
J
a
c
k
B
e
gin
n
e
r
’
s
R
o
o
m
6
0
0
6
0
0
3
2
1
点
中
级
房
T
h
e
Bla
c
k
J
a
c
k In
t
e
r
m
e
dia
t
e
R
o
o
m
6
0
0
6
0
0
4
2
1
点
高
级
房
T
h
e
Bla
c
k
J
a
c
k
A
d
v
a
n
c
e
d
R
o
o
m
8
7
0
8
7
0
1
通
比
牛
牛
体
验
房
C
a
sin
o
B
ullB
ull F
r
e
s
h
R
o
o
m
8
7
0
8
7
0
2
通
比
牛
牛
初
级
房
C
a
sin
o
B
ullB
ull B
e
gin
n
e
r
’
s
R
o
o
m
8
7
0
8
7
0
3
通
比
牛
牛
中
级
房
C
a
sin
o
B
ullB
ull In
t
e
r
m
e
dia
t
e
R
o
o
m
8
7
0
8
7
0
4
通
比
牛
牛
高
级
房
C
a
sin
o
B
ullB
ull A
d
v
a
n
c
e
d
R
o
o
m
8
7
0
8
7
0
5
通
比
牛
牛
至
尊
房
C
a
sin
o
B
ullB
ull M
a
s
t
e
r
r
o
o
m
8
7
0
8
7
0
6
通
比
牛
牛
王
者
房
C
a
sin
o
B
ullB
ull Kin
g
’
s
R
o
o
m
2
3
0
2
3
0
1
极
速
炸
金
花
新
手
房
S
p
e
e
d
G
old
e
n
Flo
w
e
r
F
r
e
s
h
R
o
o
m
2
3
0
2
3
0
2
极
速
炸
金
花
初
级
房
S
p
e
e
d
G
old
e
n
Flo
w
e
r
B
e
gin
n
e
r
’
s
R
o
o
m
2
3
0
2
3
0
3
极
速
炸
金
花
中
级
房
S
p
e
e
d
G
old
e
n
Flo
w
e
r In
t
e
r
m
e
dia
t
e
R
o
o
m
2
3
0
2
3
0
4
极
速
炸
金
花
高
级
房
S
p
e
e
d
G
old
e
n
Flo
w
e
r
A
d
v
a
n
c
e
d
R
o
o
m
7
3
0
7
3
0
1
抢
庄
牌
九
新
手
房
P
aig
o
w
F
r
e
s
h
R
o
o
m
7
3
0
7
3
0
2
抢
庄
牌
九
初
级
房
P
aig
o
w
B
e
gin
n
e
r
’
s
R
o
o
m
7
3
0
7
3
0
3
抢
庄
牌
九
中
级
房
P
aig
o
w In
t
e
r
m
e
dia
t
e
R
o
o
m
7
3
7
3
0
7
3
0
4
抢
庄
牌
九
高
级
房
P
aig
o
w
A
d
v
a
n
c
e
d
R
o
o
m
7
3
0
7
3
0
5
抢
庄
牌
九
至
尊
房
P
aig
o
w
M
a
s
t
e
r
r
o
o
m
7
3
0
7
3
0
6
抢
庄
牌
九
王
者
房
P
aig
o
w
Kin
g
’
s
R
o
o
m
6
1
0
6
1
0
1
斗
地
主
体
验
房
L
a
n
dlo
r
d
F
r
e
s
h
R
o
o
m
6
1
0
6
1
0
2
斗
地
主
初
级
房
L
a
n
dlo
r
d
B
e
gin
n
e
r
’
s
R
o
o
m
6
1
0
6
1
0
3
斗
地
主
中
级
房
L
a
n
dlo
r
d In
t
e
r
m
e
dia
t
e
R
o
o
m
6
1
0
6
1
0
4
斗
地
主
高
级
房
L
a
n
dlo
r
d
A
d
v
a
n
c
e
d
R
o
o
m
6
3
0
6
3
0
1
十
三
水
常
规
场
新
手
房
Pin
e
a
p
ple
P
o
k
e
r
G
e
n
e
r
al M
a
t
c
h
F
r
e
s
h
R
o
o
m
6
3
0
6
3
0
2
十
三
水
常
规
场
初
级
房
Pin
e
a
p
ple
P
o
k
e
r
G
e
n
e
r
al M
a
t
c
h
B
e
gin
n
e
r
’
s
R
o
o
m
6
3
0
6
3
0
3
十
三
水
常
规
场
中
级
房
Pin
e
a
p
ple
P
o
k
e
r
G
e
n
e
r
al M
a
t
c
h In
t
e
r
m
e
dia
t
e
R
o
o
m
6
3
0
6
3
0
4
十
三
水
常
规
场
高
级
房
Pin
e
a
p
ple
P
o
k
e
r
G
e
n
e
r
al M
a
t
c
h
A
d
v
a
n
c
e
d
R
o
o
m
6
3
0
6
3
0
5
十
三
水
极
速
场
新
手
房
Pin
e
a
p
ple
P
o
k
e
r
S
p
e
e
d
M
a
t
c
h
F
r
e
s
h
R
o
o
m
6
3
0
6
3
0
6
十
三
水
极
速
场
初
级
房
Pin
e
a
p
ple
P
o
k
e
r
S
p
e
e
d
M
a
t
c
h
B
e
gin
n
e
r
’
s
R
o
o
m
6
3
0
6
3
0
7
十
三
水
极
速
场
中
级
房
Pin
e
a
p
ple
P
o
k
e
r
S
p
e
e
d
M
a
t
c
h In
t
e
r
m
e
dia
t
e
R
o
o
m
6
3
0
6
3
0
8
十
三
水
极
速
场
高
级
房
Pin
e
a
p
ple
P
o
k
e
r
S
p
e
e
d
M
a
t
c
h
A
d
v
a
n
c
e
d
R
o
o
m
9
1
0
9
1
0
1
百
家
乐
体
验
房
B
a
c
c
a
r
a
t
F
r
e
s
h
R
o
o
m
9
1
0
9
1
0
2
百
家
乐
初
级
房
B
a
c
c
a
r
a
t
B
e
gin
n
e
r
’
s
R
o
o
m
9
1
0
9
1
0
3
百
家
乐
中
级
房
B
a
c
c
a
r
a
t In
t
e
r
m
e
dia
t
e
R
o
o
m
9
1
0
9
1
0
4
百
家
乐
高
级
房
B
a
c
c
a
r
a
t
A
d
v
a
n
c
e
d
R
o
o
m
9
2
0
9
2
0
1
森
林
舞
会
体
验
房
F
o
r
e
s
t
P
a
r
t
y
F
r
e
s
h
R
o
o
m
9
2
0
9
2
0
2
森
林
舞
会
初
级
房
7
4
F
o
r
e
s
t
P
a
r
t
y
B
e
gin
n
e
r
’
s
R
o
o
m
9
2
0
9
2
0
3
森
林
舞
会
中
级
房
F
o
r
e
s
t
P
a
r
t
y In
t
e
r
m
e
dia
t
e
R
o
o
m
9
2
0
9
2
0
4
森
林
舞
会
高
级
房
F
o
r
e
s
t
P
a
r
t
y
A
d
v
a
n
c
e
d
R
o
o
m
9
3
0
9
3
0
1
百
人
牛
牛
体
验
房
Niu
–
niu
f
o
r
t
h
o
u
s
a
n
d
s
p
e
r
s
o
n
F
r
e
s
h
R
o
o
m
9
3
0
9
3
0
2
百
人
牛
牛
初
级
房
Niu
–
niu
f
o
r
t
h
o
u
s
a
n
d
s
p
e
r
s
o
n
B
e
gin
n
e
r
’
s
R
o
o
m
9
3
0
9
3
0
3
百
人
牛
牛
中
级
房
Niu
–
niu
f
o
r
t
h
o
u
s
a
n
d
s
p
e
r
s
o
n In
t
e
r
m
e
dia
t
e
R
o
o
m
9
3
0
9
3
0
4
百
人
牛
牛
高
级
房
Niu
–
niu
f
o
r
t
h
o
u
s
a
n
d
s
p
e
r
s
o
n
A
d
v
a
n
c
e
d
R
o
o
m
1
9
5
0
1
9
5
0
1
万
人
炸
金
花
体
验
房
G
old
e
n
Flo
w
e
r
f
o
r
t
h
o
u
s
a
n
d
s
p
e
r
s
o
n
F
r
e
s
h
R
o
o
m
1
9
5
0
1
9
5
0
2
万
人
炸
金
花
初
级
房
G
old
e
n
Flo
w
e
r
f
o
r
t
h
o
u
s
a
n
d
s
p
e
r
s
o
n
B
e
gin
n
e
r
’
s
R
o
o
m
1
9
5
0
1
9
5
0
3
万
人
炸
金
花
中
级
房
G
old
e
n
Flo
w
e
r
f
o
r
t
h
o
u
s
a
n
d
s
p
e
r
s
o
n In
t
e
r
m
e
dia
t
e
R
o
o
m
1
9
5
0
1
9
5
0
4
万
人
炸
金
花
高
级
房
G
old
e
n
Flo
w
e
r
f
o
r
t
h
o
u
s
a
n
d
s
p
e
r
s
o
n
A
d
v
a
n
c
e
d
R
o
o
m
6
5
0
6
5
0
1
血
流
成
河
体
验
房
Ble
e
din
g
M
a
h
j
o
n
g
F
r
e
s
h
R
o
o
m
6
5
0
6
5
0
2
血
流
成
河
初
级
房
Ble
e
din
g
M
a
h
j
o
n
g
B
e
gin
n
e
r
’
s
R
o
o
m
6
5
0
6
5
0
3
血
流
成
河
中
级
房
Ble
e
din
g
M
a
h
j
o
n
g In
t
e
r
m
e
dia
t
e
R
o
o
m
6
5
0
6
5
0
4
血
流
成
河
高
级
房
Ble
e
din
g
M
a
h
j
o
n
g
A
d
v
a
n
c
e
d
R
o
o
m
8
9
0
8
9
0
1
看
牌
抢
庄
牛
牛
体
验
房
B
a
n
k
e
r
B
ullB
ull A
f
t
e
r
C
h
e
c
k
C
a
r
d
F
r
e
s
h
R
o
o
m
8
9
0
8
9
0
2
看
牌
抢
庄
牛
牛
初
级
房
B
a
n
k
e
r
B
ullB
ull A
f
t
e
r
C
h
e
c
k
C
a
r
d
B
e
gin
n
e
r
’
s
R
o
o
m
8
9
0
8
9
0
3
看
牌
抢
庄
牛
牛
中
级
房
B
a
n
k
e
r
B
ullB
ull A
f
t
e
r
C
h
e
c
k
C
a
r
d In
t
e
r
m
e
dia
t
e
R
o
o
m
8
9
0
8
9
0
4
看
牌
抢
庄
牛
牛
高
级
房
B
a
n
k
e
r
B
ullB
ull A
f
t
e
r
C
h
e
c
k
C
a
r
d
A
d
v
a
n
c
e
d
R
o
o
m
8
9
0
8
9
0
5
看
牌
抢
庄
牛
牛
至
尊
房
B
a
n
k
e
r
B
ullB
ull A
f
t
e
r
C
h
e
c
k
C
a
r
d
M
a
s
t
e
r
r
o
o
m
8
9
0
8
9
0
6
看
牌
抢
庄
牛
牛
王
者
房
B
a
n
k
e
r
B
ullB
ull A
f
t
e
r
C
h
e
c
k
C
a
r
d
Kin
g
’
s
R
o
o
m
7
5
7
4
0
7
4
0
1
二
人
麻
将
体
验
房
2
P
e
r
s
o
n
s
’
M
a
h
j
o
n
g
F
r
e
s
h
R
o
o
m
7
4
0
7
4
0
2
二
人
麻
将
初
级
房
2
P
e
r
s
o
n
s
’
M
a
h
j
o
n
g
B
e
gin
n
e
r
’
s
R
o
o
m
7
4
0
7
4
0
3
二
人
麻
将
中
级
房
2
P
e
r
s
o
n
s
’
M
a
h
j
o
n
g In
t
e
r
m
e
dia
t
e
R
o
o
m
7
4
0
7
4
0
4
二
人
麻
将
高
级
房
2
P
e
r
s
o
n
s
’
M
a
h
j
o
n
g
A
d
v
a
n
c
e
d
R
o
o
m
1
3
5
0
1
3
5
0
1
幸
运
转
盘
L
u
c
k
y
Dial F
r
e
s
h
R
o
o
m
1
3
5
0
1
3
5
0
2
幸
运
转
盘
L
u
c
k
y
Dial B
e
gin
n
e
r's
R
o
o
m
1
3
5
0
1
3
5
0
3
幸
运
转
盘
L
u
c
k
y
Dial In
t
e
r
m
e
dia
t
e
R
o
o
m
1
9
4
0
1
9
4
0
1
金
鲨
银
鲨
体
验
房
G
old
S
h
a
r
k
&
Silv
e
r
S
h
a
r
k
F
r
e
s
h
R
o
o
m
1
9
4
0
1
9
4
0
2
金
鲨
银
鲨
初
级
房
G
old
S
h
a
r
k
&
Silv
e
r
S
h
a
r
k
B
e
gin
n
e
r's
R
o
o
m
1
9
4
0
1
9
4
0
3
金
鲨
银
鲨
中
级
房
G
old
S
h
a
r
k
&
Silv
e
r
S
h
a
r
k In
t
e
r
m
e
dia
t
e
R
o
o
m
1
9
4
0
1
9
4
0
4
金
鲨
银
鲨
高
级
房
G
old
S
h
a
r
k
&
Silv
e
r
S
h
a
r
k
A
d
v
a
n
c
e
d
R
o
o
m
1
9
6
0
1
9
6
0
1
奔
驰
宝
马
体
验
房
B
e
n
z
&
B
M
W
F
r
e
s
h
R
o
o
m
1
9
6
0
1
9
6
0
2
奔
驰
宝
马
初
级
房
B
e
n
z
&
B
M
W
B
e
gin
n
e
r's
R
o
o
m
1
9
6
0
1
9
6
0
3
奔
驰
宝
马
中
级
房
B
e
n
z
&
B
M
W In
t
e
r
m
e
dia
t
e
R
o
o
m
1
9
6
0
1
9
6
0
4
奔
驰
宝
马
高
级
房
B
e
n
z
&
B
M
W
A
d
v
a
n
c
e
d
R
o
o
m
1
9
8
0
1
9
8
0
1
百
人
骰
宝
体
验
房
Sic
B
o
F
r
e
s
h
R
o
o
m
1
9
8
0
1
9
8
0
2
百
人
骰
宝
初
级
房
Sic
B
o
B
e
gin
n
e
r's
R
o
o
m
1
9
8
0
1
9
8
0
3
百
人
骰
宝
中
级
房
Sic
B
o In
t
e
r
m
e
dia
t
e
R
o
o
m
1
9
8
0
1
9
8
0
4
百
人
骰
宝
高
级
房
Sic
B
o
A
d
v
a
n
c
e
d
R
o
o
m
1
8
1
0
1
8
1
0
1
单
挑
牛
牛
体
验
房
1
v
1
B
ullB
ull F
r
e
s
h
R
o
o
m
1
8
1
0
1
8
1
0
2
单
挑
牛
牛
初
级
房
7
6
1
v
1
B
ullB
ull B
e
gin
n
e
r's
R
o
o
m
1
8
1
0
1
8
1
0
3
单
挑
牛
牛
中
级
房
1
v
1
B
ullB
ull In
t
e
r
m
e
dia
t
e
R
o
o
m
1
8
1
0
1
8
1
0
4
单
挑
牛
牛
高
级
房
1
v
1
B
ullB
ull A
d
v
a
n
c
e
d
R
o
o
m
1
8
1
0
1
8
1
0
5
单
挑
牛
牛
至
尊
房
1
v
1
B
ullB
ull S
u
p
r
e
m
e
R
o
o
m
1
8
1
0
1
8
1
0
6
单
挑
牛
牛
王
者
房
1
v
1
B
ullB
ull Kin
g's
r
o
o
m
1
9
9
0
1
9
9
0
1
炸
金
牛
体
验
房
G
old
e
n
B
ull F
r
e
s
h
R
o
o
m
1
9
9
0
1
9
9
0
2
炸
金
牛
初
级
房
G
old
e
n
B
ull B
e
gin
n
e
r's
R
o
o
m
1
9
9
0
1
9
9
0
3
炸
金
牛
中
级
房
G
old
e
n
B
ull In
t
e
r
m
e
dia
t
e
R
o
o
m
1
9
9
0
1
9
9
0
4
炸
金
牛
高
级
房
G
old
e
n
B
ull A
d
v
a
n
c
e
d
R
o
o
m
1
9
9
0
1
9
9
0
5
炸
金
牛
至
尊
房
G
old
e
n
B
ull S
u
p
r
e
m
e
R
o
o
m
1
9
9
0
1
9
9
0
6
炸
金
牛
王
者
房
G
old
e
n
B
ull Kin
g's
r
o
o
m
1
8
5
0
1
8
5
0
1
押
宝
抢
庄
牛
牛
体
验
房
B
e
t
3
Pla
y
e
r
s
B
ullB
ull F
r
e
s
h
R
o
o
m
1
8
5
0
1
8
5
0
2
押
宝
抢
庄
牛
牛
初
级
房
B
e
t
3
Pla
y
e
r
s
B
ullB
ull B
e
gin
n
e
r's
R
o
o
m
1
8
5
0
1
8
5
0
3
押
宝
抢
庄
牛
牛
中
级
房
B
e
t
3
Pla
y
e
r
s
B
ullB
ull In
t
e
r
m
e
dia
t
e
R
o
o
m
1
8
5
0
1
8
5
0
4
押
宝
抢
庄
牛
牛
高
级
房
B
e
t
3
Pla
y
e
r
s
B
ullB
ull A
d
v
a
n
c
e
d
R
o
o
m
1
8
5
0
1
8
5
0
5
押
宝
抢
庄
牛
牛
至
尊
房
B
e
t
3
Pla
y
e
r
s
B
ullB
ull S
u
p
r
e
m
e
R
o
o
m
1
8
5
0
1
8
5
0
6
押
宝
抢
庄
牛
牛
王
者
房
B
e
t
3
Pla
y
e
r
s
B
ullB
ull Kin
g's
r
o
o
m
5
1
0
5
1
0
1
人
鱼
港
口
M
e
r
m
aid
P
o
r
t
5
1
0
5
1
0
2
海
王
遗
迹
S
e
a
Kin
g's
R
elic
s
5
1
0
5
1
0
3
伟
大
航
道
G
r
a
n
d
Lin
e
1
9
7
0
1
9
7
0
1
五
星
宏
辉
体
验
房
Fiv
e
S
t
a
r
s
F
r
e
s
h
R
o
o
m
7
7
1
9
7
0
1
9
7
0
2
五
星
宏
辉
初
级
房
Fiv
e
S
t
a
r
s
B
e
gin
n
e
r
’
s
R
o
o
m
1
9
7
0
1
9
7
0
3
五
星
宏
辉
中
级
房
Fiv
e
S
t
a
r
s In
t
e
r
m
e
dia
t
e
R
o
o
m
1
9
7
0
1
9
7
0
4
五
星
宏
辉
高
级
房
Fiv
e
S
t
a
r
s
A
d
v
a
n
c
e
d
R
o
o
m
1
8
6
0
1
8
6
0
1
赌
场
扑
克
体
验
房
C
a
sin
o
P
o
k
e
r
F
r
e
s
h
R
o
o
m
1
8
6
0
1
8
6
0
2
赌
场
扑
克
初
级
房
C
a
sin
o
P
o
k
e
r
B
e
gin
n
e
r
’
s
R
o
o
m
1
8
6
0
1
8
6
0
3
赌
场
扑
克
中
级
房
C
a
sin
o
P
o
k
e
r In
t
e
r
m
e
dia
t
e
R
o
o
m
1
8
6
0
1
8
6
0
4
赌
场
扑
克
高
级
房
C
a
sin
o
P
o
k
e
r
A
d
v
a
n
c
e
d
R
o
o
m
1
3
7
0
1
3
7
0
1
港
式
梭
哈
新
手
房
H
o
n
g
K
o
n
g
S
t
u
d
F
r
e
s
h
R
o
o
m
1
3
7
0
1
3
7
0
2
港
式
梭
哈
初
级
房
H
o
n
g
K
o
n
g
S
t
u
d
B
e
gin
n
e
r
’
s
R
o
o
m
1
3
7
0
1
3
7
0
3
港
式
梭
哈
中
级
房
H
o
n
g
K
o
n
g
S
t
u
d In
t
e
r
m
e
dia
t
e
R
o
o
m
1
3
7
0
1
3
7
0
4
港
式
梭
哈
高
级
房
H
o
n
g
K
o
n
g
S
t
u
d
A
d
v
a
n
c
e
d
R
o
o
m
1
6
9
0
1
6
9
0
1
血
战
骰
宝
体
验
房
K
a
r
mic
Sic
B
o
F
r
e
s
h
R
o
o
m
1
6
9
0
1
6
9
0
2
血
战
骰
宝
初
级
房
K
a
r
mic
Sic
B
o
B
e
gin
n
e
r
’
s
R
o
o
m
1
6
9
0
1
6
9
0
3
血
战
骰
宝
中
级
房
K
a
r
mic
Sic
B
o In
t
e
r
m
e
dia
t
e
R
o
o
m
1
6
9
0
1
6
9
0
4
血
战
骰
宝
高
级
房
K
a
r
mic
Sic
B
o
A
d
v
a
n
c
e
d
R
o
o
m
1
8
9
0
1
8
9
0
1
水
果
机
体
验
房
F
r
uit
M
a
c
hin
e
F
r
e
s
h
R
o
o
m
1
8
9
0
1
8
9
0
2
水
果
机
初
级
房
F
r
uit
M
a
c
hin
e
B
e
gin
n
e
r
’
s
R
o
o
m
1
8
9
0
1
8
9
0
3
水
果
机
中
级
房
F
r
uit
M
a
c
hin
e In
t
e
r
m
e
dia
t
e
R
o
o
m
1
8
9
0
1
8
9
0
4
水
果
机
高
级
房
F
r
uit
M
a
c
hin
e
A
d
v
a
n
c
e
d
R
o
o
m
1
6
1
0
1
6
1
0
1
幸
运
夺
宝
白
银
宝
箱
Silv
e
r
T
r
e
a
s
u
r
e
1
6
1
0
1
6
1
0
2
幸
运
夺
宝
黄
金
宝
箱
7
8
G
old
T
r
e
a
s
u
r
e
1
6
1
0
1
6
1
0
3
幸
运
夺
宝
铂
金
宝
箱
Pla
tin
u
m
T
r
e
a
s
u
r
e
1
6
1
0
1
6
1
0
4
幸
运
夺
宝
钻
石
宝
箱
Dia
m
o
n
d
T
r
e
a
s
u
r
e
1
9
3
0
1
9
3
0
1
鱼
虾
蟹
体
验
房
Fis
h
-
P
r
a
w
n
-
C
r
a
b
Dic
e
F
r
e
s
h
R
o
o
m
1
9
3
0
1
9
3
0
2
鱼
虾
蟹
初
级
房
Fis
h
-
P
r
a
w
n
-
C
r
a
b
Dic
e
B
e
gin
n
e
r
’
s
R
o
o
m
1
9
3
0
1
9
3
0
3
鱼
虾
蟹
中
级
房
Fis
h
-
P
r
a
w
n
-
C
r
a
b
Dic
e In
t
e
r
m
e
dia
t
e
R
o
o
m
1
9
3
0
1
9
3
0
4
鱼
虾
蟹
高
级
房
Fis
h
-
P
r
a
w
n
-
C
r
a
b
Dic
e
A
d
v
a
n
c
e
d
R
o
o
m
8
1
3
0
8
1
3
0
1
跑
得
快
体
验
房
R
u
n
F
a
s
t
F
r
e
s
h
R
o
o
m
8
1
3
0
8
1
3
0
2
跑
得
快
初
级
房
R
u
n
F
a
s
t
B
e
gin
n
e
r
’
s
R
o
o
m
8
1
3
0
8
1
3
0
3
跑
得
快
中
级
房
R
u
n
F
a
s
t In
t
e
r
m
e
dia
t
e
R
o
o
m
8
1
3
0
8
1
3
0
4
跑
得
快
高
级
房
R
u
n
F
a
s
t
A
d
v
a
n
c
e
d
R
o
o
m
9
5
0
9
5
0
1
红
黑
大
战
体
验
房
R
e
d
&
Bla
c
k
W
a
r
F
r
e
s
h
R
o
o
m
9
5
0
9
5
0
2
红
黑
大
战
初
级
房
R
e
d
&
Bla
c
k
W
a
r
B
e
gin
n
e
r's
R
o
o
m
9
5
0
9
5
0
3
红
黑
大
战
中
级
房
R
e
d
&
Bla
c
k
W
a
r In
t
e
r
m
e
dia
t
e
R
o
o
m
9
5
0
9
5
0
4
红
黑
大
战
高
级
房
R
e
d
&
Bla
c
k
W
a
r
A
d
v
a
n
c
e
d
R
o
o
m
8
4
0
8
4
0
1
疯
狂
抢
庄
牛
牛
新
手
房
C
r
a
z
y
B
a
n
k
e
r
B
ullB
ull F
r
e
s
h
R
o
o
m
8
4
0
8
4
0
2
疯
狂
抢
庄
牛
牛
初
级
房
C
r
a
z
y
B
a
n
k
e
r
B
ullB
ull B
e
gin
n
e
r's
R
o
o
m
8
4
0
8
4
0
3
疯
狂
抢
庄
牛
牛
中
级
房
C
r
a
z
y
B
a
n
k
e
r
B
ullB
ull In
t
e
r
m
e
dia
t
e
R
o
o
m
8
4
0
8
4
0
4
疯
狂
抢
庄
牛
牛
高
级
房
C
r
a
z
y
B
a
n
k
e
r
B
ullB
ull A
d
v
a
n
c
e
d
R
o
o
m
8
4
0
8
4
0
5
疯
狂
抢
庄
牛
牛
至
尊
房
C
r
a
z
y
B
a
n
k
e
r
B
ullB
ull S
u
p
r
e
m
e
R
o
o
m
8
4
0
8
4
0
6
疯
狂
抢
庄
牛
牛
王
者
房
C
r
a
z
y
B
a
n
k
e
r
B
ullB
ull Kin
g's
r
o
o
m
7
9
5
2
0
5
2
0
1
李
逵
捕
鱼
初
级
房
L
K
Fis
hin
g
B
e
gin
n
e
r's
R
o
o
m
5
2
0
5
2
0
2
李
逵
捕
鱼
中
级
房
L
K
Fis
hin
g In
t
e
r
m
e
dia
t
e
R
o
o
m
5
2
0
5
2
0
3
李
逵
捕
鱼
高
级
房
L
K
Fis
hin
g
A
d
v
a
n
c
e
d
R
o
o
m
5
3
0
5
3
0
1
金
元
捕
鱼
初
级
房
C
hin
Y
u
a
n
Fis
hin
g
B
e
gin
n
e
r's
R
o
o
m
5
3
0
5
3
0
2
金
元
捕
鱼
中
级
房
C
hin
Y
u
a
n
Fis
hin
g In
t
e
r
m
e
dia
t
e
R
o
o
m
5
3
0
5
3
0
3
金
元
捕
鱼
高
级
房
C
hin
Y
u
a
n
Fis
hin
g
A
d
v
a
n
c
e
d
R
o
o
m
5
4
0
5
4
0
1
捕
鱼
传
说
初
级
房
B
Y
C
S
Fis
hin
g
B
e
gin
n
e
r's
R
o
o
m
5
4
0
5
4
0
2
捕
鱼
传
说
中
级
房
B
Y
C
S
Fis
hin
g In
t
e
r
m
e
dia
t
e
R
o
o
m
5
4
0
5
4
0
3
捕
鱼
传
说
高
级
房
B
Y
C
S
Fis
hin
g
A
d
v
a
n
c
e
d
R
o
o
m
3
0
0
1
3
0
0
1
1
极
速
百
家
乐
体
验
房
S
p
e
e
d
B
a
c
c
a
r
a
t
F
r
e
s
h
R
o
o
m
3
0
0
1
3
0
0
1
2
极
速
百
家
乐
初
级
房
S
p
e
e
d
B
a
c
c
a
r
a
t
B
e
gin
n
e
r
’
s
R
o
o
m
3
0
0
1
3
0
0
1
3
极
速
百
家
乐
中
级
房
S
p
e
e
d
B
a
c
c
a
r
a
t In
t
e
r
m
e
dia
t
e
R
o
o
m
3
0
0
1
3
0
0
1
4
极
速
百
家
乐
高
级
房
S
p
e
e
d
B
a
c
c
a
r
a
t
A
d
v
a
n
c
e
d
R
o
o
m
2
8
9
0
2
8
9
0
1
看
牌
抢
庄
三
公
体
验
房
T
h
r
e
e
-
F
a
c
e
c
a
r
d
A
f
t
e
r
C
h
e
c
k
C
a
r
d
F
r
e
s
h
R
o
o
m
2
8
9
0
2
8
9
0
2
看
牌
抢
庄
三
公
初
级
房
T
h
r
e
e
-
F
a
c
e
c
a
r
d
A
f
t
e
r
C
h
e
c
k
C
a
r
d
B
e
gin
n
e
r's
R
o
o
m
2
8
9
0
2
8
9
0
3
看
牌
抢
庄
三
公
中
级
房
T
h
r
e
e
-
F
a
c
e
c
a
r
d
A
f
t
e
r
C
h
e
c
k
C
a
r
d In
t
e
r
m
e
dia
t
e
R
o
o
m
2
8
9
0
2
8
9
0
4
看
牌
抢
庄
三
公
高
级
房
T
h
r
e
e
-
F
a
c
e
c
a
r
d
A
f
t
e
r
C
h
e
c
k
C
a
r
d
A
d
v
a
n
c
e
d
R
o
o
m
2
8
9
0
2
8
9
0
5
看
牌
抢
庄
三
公
至
尊
房
T
h
r
e
e
-
F
a
c
e
c
a
r
d
A
f
t
e
r
C
h
e
c
k
C
a
r
d
S
u
p
r
e
m
e
R
o
o
m
2
8
9
0
2
8
9
0
6
看
牌
抢
庄
三
公
王
者
房
T
h
r
e
e
-
F
a
c
e
c
a
r
d
A
f
t
e
r
C
h
e
c
k
C
a
r
d
Kin
g's
R
o
o
m
2
0
0
2
2
0
0
2
1
梭
哈
德
州
扑
克
体
验
房
All-In
o
r
F
old In
t
e
r
m
e
dia
t
e
R
o
o
m
2
0
0
2
2
0
0
2
2
梭
哈
德
州
扑
克
初
级
房
8
0
All-In
o
r
F
old
A
d
v
a
n
c
e
d
R
o
o
m
2
0
0
2
2
0
0
2
3
梭
哈
德
州
扑
克
中
级
房
All-In
o
r
F
old
S
u
p
r
e
m
e
R
o
o
m
2
0
0
2
2
0
0
2
4
梭
哈
德
州
扑
克
高
级
房
All-In
o
r
F
old
Kin
g's
R
o
o
m
3
0
0
2
3
0
0
2
1
金
球
银
球
体
验
房
W
o
rld
C
u
p
G
old
e
n
B
all F
r
e
s
h
R
o
o
m
3
0
0
2
3
0
0
2
2
金
球
银
球
初
级
房
W
o
rld
C
u
p
G
old
e
n
B
all B
e
gin
n
e
r's
R
o
o
m
3
0
0
2
3
0
0
2
3
金
球
银
球
中
级
房
W
o
rld
C
u
p
G
old
e
n
B
all In
t
e
r
m
e
dia
t
e
R
o
o
m
3
0
0
2
3
0
0
2
4
金
球
银
球
高
级
房
W
o
rld
C
u
p
G
old
e
n
B
all A
d
v
a
n
c
e
d
R
o
o
m
3
0
0
3
3
0
0
3
1
十
倍
牛
牛
体
验
房
Te
n
Tim
e
s
B
ullB
ull F
r
e
s
h
R
o
o
m
3
0
0
3
3
0
0
3
2
十
倍
牛
牛
初
级
房
Te
n
Tim
e
s
B
ullB
ull B
e
gin
n
e
r's
R
o
o
m
3
0
0
3
3
0
0
3
3
十
倍
牛
牛
中
级
房
Te
n
Tim
e
s
B
ullB
ull In
t
e
r
m
e
dia
t
e
R
o
o
m
3
0
0
3
3
0
0
3
4
十
倍
牛
牛
高
级
房
Te
n
Tim
e
s
B
ullB
ull A
d
v
a
n
c
e
d
R
o
o
m
5
5
0
5
5
0
1
富
贵
金
龙
初
级
房
G
old
e
n
D
r
a
g
o
n
F
r
e
s
h
R
o
o
m
5
5
0
5
5
0
2
富
贵
金
龙
中
级
房
G
old
e
n
D
r
a
g
o
n In
t
e
r
m
e
dia
t
e
R
o
o
m
5
5
0
5
5
0
3
富
贵
金
龙
至
尊
场
G
old
e
n
D
r
a
g
o
n
Kin
g's
R
o
o
m
3
0
0
5
3
0
0
5
1
欧
式
轮
盘
体
验
房
E
u
r
o
p
e
a
n
R
o
ule
t
t
e
F
r
e
s
h
R
o
o
m
3
0
0
5
3
0
0
5
2
欧
式
轮
盘
初
级
房
E
u
r
o
p
e
a
n
R
o
ule
t
t
e
B
e
gin
n
e
r's
R
o
o
m
3
0
0
5
3
0
0
5
3
欧
式
轮
盘
中
级
房
E
u
r
o
p
e
a
n
R
o
ule
t
t
e In
t
e
r
m
e
dia
t
e
R
o
o
m
3
0
0
5
3
0
0
5
4
欧
式
轮
盘
高
级
房
E
u
r
o
p
e
a
n
R
o
ule
t
t
e
A
d
v
a
n
c
e
d
R
o
o
m
2
0
0
5
2
0
0
5
1
富
贵
三
张
体
验
房
T
h
r
e
e
C
a
r
d
P
o
k
e
r
F
r
e
s
h
R
o
o
m
2
0
0
5
2
0
0
5
2
富
贵
三
张
初
级
房
T
h
r
e
e
C
a
r
d
P
o
k
e
r
B
e
gin
n
e
r's
R
o
o
m
2
0
0
5
2
0
0
5
3
富
贵
三
张
中
级
房
T
h
r
e
e
C
a
r
d
P
o
k
e
r In
t
e
r
m
e
dia
t
e
R
o
o
m
8
1
2
0
0
5
2
0
0
5
4
富
贵
三
张
高
级
房
T
h
r
e
e
C
a
r
d
P
o
k
e
r
A
d
v
a
n
c
e
d
R
o
o
m
3
0
0
6
3
0
0
6
1
官
人
坏
坏
百
J
乐
体
验
房
H
-
B
a
c
c
a
r
a
t
F
r
e
s
h
R
o
o
m
3
0
0
6
3
0
0
6
2
官
人
坏
坏
百
J
乐
初
级
房
H
-
B
a
c
c
a
r
a
t
B
e
gin
n
e
r's
R
o
o
m
3
0
0
6
3
0
0
6
3
官
人
坏
坏
百
J
乐
中
级
房
H
-
B
a
c
c
a
r
a
t In
t
e
r
m
e
dia
t
e
R
o
o
m
3
0
0
6
3
0
0
6
4
官
人
坏
坏
百
J
乐
高
级
房
H
-
B
a
c
c
a
r
a
t
A
d
v
a
n
c
e
d
R
o
o
m
2
0
0
7
2
0
0
7
1
闪
电
2
1
点
体
验
房
Lig
h
t
nin
g
Bla
c
kj
a
c
k
F
r
e
s
h
R
o
o
m
2
0
0
7
2
0
0
7
2
闪
电
2
1
点
初
级
房
Lig
h
t
nin
g
Bla
c
k
J
a
c
k
B
e
gin
n
e
r's
R
o
o
m
2
0
0
7
2
0
0
7
3
闪
电
2
1
点
中
级
房
Lig
h
t
nin
g
Bla
c
k
J
a
c
k In
t
e
r
m
e
dia
t
e
R
o
o
m
2
0
0
7
2
0
0
7
4
闪
电
2
1
点
高
级
房
Lig
h
t
nin
g
Bla
c
k
J
a
c
k
A
d
v
a
n
c
e
d
R
o
o
m
2
0
0
8
2
0
0
8
1
终
极
德
州
扑
克
体
验
房
Ultim
a
t
e
Te
x
a
s
F
r
e
s
h
R
o
o
m
2
0
0
8
2
0
0
8
2
终
极
德
州
扑
克
初
级
房
Ultim
a
t
e
Te
x
a
s
B
e
gin
n
e
r's
R
o
o
m
2
0
0
8
2
0
0
8
3
终
极
德
州
扑
克
中
级
房
Ultim
a
t
e
Te
x
a
s In
t
e
r
m
e
dia
t
e
R
o
o
m
2
0
0
8
2
0
0
8
4
终
极
德
州
扑
克
高
级
房
Ultim
a
t
e
Te
x
a
s
A
d
v
a
n
c
e
d
R
o
o
m
2
0
1
2
2
0
1
2
1
抖
音
牛
牛
体
验
房
Tik
To
k
B
ullB
ull F
r
e
s
h
R
o
o
m
2
0
1
2
2
0
1
2
2
抖
音
牛
牛
初
级
房
Tik
To
k
B
ullB
ull B
e
gin
n
e
r
’
s
R
o
o
m
2
0
1
2
2
0
1
2
3
抖
音
牛
牛
中
级
房
Tik
To
k
B
ullB
ull In
t
e
r
m
e
dia
t
e
R
o
o
m
2
0
1
2
2
0
1
2
4
抖
音
牛
牛
高
级
房
Tik
To
k
B
ullB
ull A
d
v
a
n
c
e
d
R
o
o
m
2
0
1
2
2
0
1
2
5
抖
音
牛
牛
至
尊
房
Tik
To
k
B
ullB
ull S
u
p
e
r
m
e
R
o
o
m
2
0
1
2
2
0
1
2
6
抖
音
牛
牛
王
者
房
Tik
To
k
B
ullB
ull Kin
g's
R
o
o
m
2
0
1
1
2
0
1
1
1
掼
蛋
体
验
房
G
u
a
n
D
a
n
F
r
e
s
h
R
o
o
m
2
0
1
1
2
0
1
1
2
掼
蛋
初
级
房
8
2
G
u
a
n
D
a
n
B
e
gin
n
e
r
’
s
R
o
o
m
2
0
1
1
2
0
1
1
3
掼
蛋
中
级
房
G
u
a
n
D
a
n In
t
e
r
m
e
dia
t
e
R
o
o
m
2
0
1
1
2
0
1
1
4
掼
蛋
高
级
房
G
u
a
n
D
a
n
A
d
v
a
n
c
e
d
R
o
o
m
2
0
1
1
2
0
1
1
5
掼
蛋
至
尊
房
G
u
a
n
D
a
n
S
u
p
r
e
m
e
R
o
o
m
2
0
1
1
2
0
1
1
6
掼
蛋
王
者
房
G
u
a
n
D
a
n
Kin
g's
R
o
o
m
2
0
1
1
2
0
1
1
7
掼
蛋
争
霸
赛
G
u
a
n
D
a
n
C
h
a
m
pio
n
s
hip
2
0
1
3
2
0
1
3
1
土
耳
其
麻
将
体
验
房
O
k
e
y
F
r
e
s
h
R
o
o
m
2
0
1
3
2
0
1
3
2
土
耳
其
麻
将
初
级
房
O
k
e
y
B
e
gin
n
e
r's
R
o
o
m
2
0
1
3
2
0
1
3
3
土
耳
其
麻
将
中
级
房
O
k
e
y In
t
e
r
m
e
dia
t
e
R
o
o
m
2
0
1
3
2
0
1
3
4
土
耳
其
麻
将
高
级
房
O
k
e
y
A
d
v
a
n
c
e
d
R
o
o
m
2
0
1
3
2
0
1
3
5
土
耳
其
麻
将
至
尊
房
O
k
e
y
S
u
p
r
e
m
e
R
o
o
m
2
0
1
3
2
0
1
3
6
土
耳
其
麻
将
王
者
房
O
k
e
y
Kin
g's
r
o
o
m
2
0
1
4
2
0
1
4
1
极
速
牛
牛
体
验
房
S
p
e
e
d
B
ullB
ulll F
r
e
s
h
R
o
o
m
2
0
1
4
2
0
1
4
2
极
速
牛
牛
初
级
房
S
p
e
e
d
B
ullB
ulll B
e
gin
n
e
r's
R
o
o
m
2
0
1
4
2
0
1
4
3
极
速
牛
牛
中
级
房
S
p
e
e
d
B
ullB
ulll In
t
e
r
m
e
dia
t
e
R
o
o
m
2
0
1
4
2
0
1
4
4
极
速
牛
牛
高
级
房
S
p
e
e
d
B
ullB
ulll A
d
v
a
n
c
e
d
R
o
o
m
2
0
1
4
2
0
1
4
5
极
速
牛
牛
至
尊
房
S
p
e
e
d
B
ullB
ulll S
u
p
r
e
m
e
R
o
o
m
2
0
1
4
2
0
1
4
6
极
速
牛
牛
王
者
房
S
p
e
e
d
B
ullB
ulll Kin
g's
r
o
o
m
2
0
1
6
2
0
1
6
0
1
射
门
之
王
S
o
c
c
e
r
Kin
g
9
3
1
9
3
1
1
黑
神
话
百
人
牛
牛
体
验
房
Bla
c
k
M
y
t
h
Niu
–
niu
f
o
r
t
h
o
u
s
a
n
d
s
p
e
r
s
o
n
F
r
e
s
h
R
o
o
m
9
3
1
9
3
1
2
黑
神
话
百
人
牛
牛
初
级
房
Bla
c
k
M
y
t
h
Niu
–
niu
f
o
r
t
h
o
u
s
a
n
d
s
p
e
r
s
o
n
B
e
gin
n
e
r
’
s
8
3
Room
931 9313
黑神话百人牛牛中级房
Black Myth Niu–niu for thousands person Intermediate
Room
931 9314 黑神话百人牛牛高级房
Black Myth Niu–niu for thousands person Advanced Room
2010 20101 癞子牛牛体验房
Lai Zi Niu Niu Fresh Room
2010 20102 癞子牛牛初级房
Lai Zi Niu Niu Beginner’s Room
2010 20103 癞子牛牛中级房
Lai Zi Niu Niu Intermediate Room
2010 20104 癞子牛牛高级房
Lai Zi Niu Niu Advanced Room
2010 20105 癞子牛牛至尊房
Lai Zi Niu Niu Supreme Room
2010 20106 癞子牛牛王者房
Lai Zi Niu Niu King's Room
3011 30111 澳门百家乐幸运六体验房
Macau Baccarat Lucky Six Fresh Room
3011 30112 澳门百家乐幸运六初级房
Macau Baccarat Lucky Six Beginner's Room
3011 30113 澳门百家乐幸运六中级房
Macau Baccarat Lucky Six Intermediate Room
3011 30114 澳门百家乐幸运六高级房
Macau Baccarat Lucky Six Advanced Room
4.2 错误码说明Error Code Description
错误码error 描述description
-1 上下分时，资料库异常回滚 Add score or cut score, database error rollback
0 成功Success
1
TOKEN丢失（重新调用登录接口获取）
TOKEN loss (reinvocation of the login interface)
2 渠道不存在（请检查渠道ID是否正确）
The channel non-existent (check the channel ID is correct or not)
3 验证时间超时（请检查timestamp是否正确）
Authentication time timeout (check if timestamp is correct or not)
4 验证错误Authentication error
5 渠道白名单错误（请联系客服添加服务器白名单）
Channel white list error (contact customer service add server white list)
84
6 验证字段丢失（请检查参数完整性）
Authentication field loss (please check parameter integrity)
7
TOKEN验证失败（重新调用登录界面）
TOKEN failure (reinvocation of the login interface)
8 不存在的请求（请检查子操作类型是否正确）
A non-existent request (check the suboperation type is correct or not)
11 玩家账号不存在
The player’s account is non-existence.
15
渠道验证错误（1.MD5key值是否正确；2.生成key值中的timestamp与参数中的
是否一致；3. 生成key值中的timestamp与代理编号以字符串形式拼接）
Channel authentication error（1.MD5key is correct or not; 2. Does the timestamp
generated in key value the same with the timestamp in parameter? 3. the
timestamp generated in key value stitch in string form with agent number.）
16 数据不存在（当前没有注单）
Data non-existence（no bet list currently）
20 账号禁用Account forbidden
22 DES解密失败DES decrypt failure
24 渠道拉取数据超过时间范围Channel pulls data overtime
26 订单号不存在Order number non-existence
27 数据库异常Database exception
28 ip禁用IP forbidden
29 订单号与订单规则不符
The order number is not in conformity with the order rule
30 获取玩家在线状态失败
Gain access player’s online status failure
31 更新的分数小于或者等于0
The updated score is less than or equal to 0
32 更新玩家信息失败Update player information failure
33 更新玩家金币失败Update player’s gold coin failed
34 订单重复Order duplication
35
获取玩家信息失败（请调用登录接口创建账号）
Gain access player’s infomation failure（Please call the login interface to create an
account）
36 KindID不存在KindID inexistence
38 余额不足导致下分失败
Insufficient balance result in fail to refund
39
禁止同一账号登录带分、上分、下分并发请求，后一个请求被拒
Forbid same account login to get points, charge points, refund and send
application, the last application is refused
40 单次上下分数量不能超过一千万
85
The amount of charge points and refund cannot more than 10 million at one time.
41 拉取对局汇总统计时间范围有误
Pull the data of the range of total time of the match have error
42 代理被禁用Agent has been forbid
43
拉单过于频繁(两次拉单时间间隔，外测服必须大于10秒，正式服必须大于5
秒)
Pull the order too frequent（there must more than 1 second between 2 times of
pull order）
44 订单正在处理中Have the same order being processed
45 参数错误Parameter error
46 时间范围错误Wrong time range
48 游戏维护中 Game is under maintenance
49 语系参数错误 Language parameter error
50 币别参数错误 Currency parameter error
51 超过单次最多账号查询数量Exceeded the maximum number of account queries
at a time
52
玩家有异常盈利或分数异常状况时
呼叫API s=3返回错误码52，当收到此响应再请洽询我方客服人员
Added error code 52, when players have abnormal profits or abnormal scores
calling API s=3 returns error code 52. Please contact our team when receiving this
response.
89 代理余额不足 Agent insufficient balance
91 代理不存在 Agent wallet is not exist
98 进入游戏发生错误 Enter game error
99 系统非预期错误 System unexception error
4.3 加解密代码Encryption And Decryption Code
参考“附件1：加解密代码”
Refer to “Appendix 1: encryption and decryption code”
4.4 CardValue读取规则Cardvalue Reading Rules
● 不同类型的游戏（不同KindId）CardValue表达含义不同
Differnet types of games（different KindId）CardValue expresses different meanings
● 字段名Field name：CardValue
4.4.1 德州扑克Texas Hold'em Poker
如：值为0709292a0000000000000000252b0000211104281d181a3
Example: value is 0709292a0000000000000000252b0000211104281d181a3
● 字段规则第一位是花色，第二位数是牌值，第三位是花色，第四位数是牌值，以此类推
The first byte of field is suit, the second byte is CardValue, the third is suit, the forth is CardValue, and
so on.
● 每个玩家2张手牌共占4位，依次为1-9号座位的玩家
2 hand cards for each player occupy 4 bytes, and the seat number from 1 to 9 in sequence.
86
● 最后面11位是公共牌加上玩家座位号码
The last 11 are public cards and player seat number.
字符character 花色suit
0 方块diamonds♦
1 梅花clubs ♣
2 红桃hearts ♥
3 黑桃spades ♠
4 王（42 ▲ 小王 43 ★ 大王）
字符character 牌值CardValue
1 1
2 2
3 3
4 4
5 5
6 6
7 7
8 8
9 9
A 10
B 11（J）
C 12（Q）
D 13（K）
注：牌值用16进制数表示的
remark：card value is expressed in Hexadecimal number
● 则值为：0709292a0000000000000000252b0000211104281d181a3表示：1号位玩家手牌♦7♦9；2号位
玩家手牌♥9♥10；7号位♥5♥J；9号位♥A♣A；公共牌：♦4♥8♣K♣8♣10；3表示为座位号
Value is：0709292a0000000000000000252b0000211104281d181a3 are present： the hand card for
NO.1 player are♦7♦9；the hand card for NO.2 player are♥9♥10；NO.7♥5♥J；NO.9♥A♣A；public cards：
♦4♥8♣K♣8♣10； 3 is mean seat number.
4.4.2 二八杠Two-Eight Bar
如：值为5326814a3
Example: value is 5326814a3
● 前8位都表示麻将的值
The fist 8 bytes represent MahjongValue
● 最后一位表示庄家座位号,1-4分别对应1-4号位
87
The last byte represents banker’s seat number, the No.1 to No.4 byte respectively corresponding to
seat NO.1-4
● 每个玩家2个麻将占2位，每桌共4人
Each player hands 2 mahjong occupy 2 bytes, 4 players per table
● 字符与牌值对应关系如下：
The corresponding relationship between the character and the CardValue is as follows：
字符character 牌值CardValue
1 一筒1 Dot
2 二筒2 Dot
3 三筒3 Dot
4 四筒4 Dot
5 五筒5 Dot
6 六筒6 Dot
7 七筒7 Dot
8 八筒8 Dot
9 九筒9 Dot
A 白板White Dragon
● 例：Example: 值为：5326814a3表示，1号位玩家是五筒三筒；2号位玩家是二筒六筒；3号位是八筒
一筒；4号位是四筒白板；3号位是庄家
Value are: 5326814a3 represent, Seat No.1 player hands 5 Dot, 3 Dot; Seat No.2 player hands 2 Dot, 6
Dot; No.3 player hands 8 Dot, 1 Dot; Seat No.4 hands 4 Dot, White Dragon; Seat No.3 is Banker
4.4.3 抢庄牛牛Banker Bull-Bull
如：值为360c2c14180000000000360c2c141800000000001
Example: Value is 360c2c14180000000000360c2c141800000000001
● 字段规则第一位是花色，第二位数是牌值，第三位是花色，第四位数是牌值，以此类推
Field rule: the fist byte is Suit, the second is Value, the third is Suit, the forth is Value, and so on.
● 每个玩家5张手牌共占10位，依次为1-4号座位的玩家
5 handcards per player occupy 10 bytes, and the seat number from 1 to 4 in sequence.
● 最后面一位表示庄家的座位号,1-4分别对应1-4号位
The last byte represent the Banker’s seat number, the No.1 to No.4 byte respectively corresponding to
seat NO.1-4
● 字符与花色对应关系、字符与牌值对应关系同德州扑克
It is the same with Texas Hold'em Poker of the corresponding relationship between Character and Suit,
Character and CardValue
● 例Example：值为：360c2c14180000000000360c2c141800000000001表示：1号位玩家手牌♠6♦Q♥
Q♣4♣8；2号位没有玩家；3号位玩家手牌♠6♦Q♥Q♣4♣8；4号位没有玩家；庄家是1号位的玩家
Value is: 360c2c14180000000000360c2c141800000000001 represent: seat NO.1 player hands ♠6♦Q♥
Q♣4♣8, seat NO.2 no player; seat NO.3 player hands ♠6♦Q♥Q♣4♣8; seat NO.4 no player; seat No.1 is
88
Banker
4.4.4 炸金花Golden Flower
如：值为161c1c000000262c2c000000363c3d5
Example: Value is 161c1c000000262c2c000000363c3c5
● 字段规则第一位是花色，第二位数是牌值，第三位是花色，第四位数是牌值，以此类推
Field rule: the first byte is Suit, the second is CardValue, the third it Suit, the forth is CardValue, and so
on
● 每个玩家3张手牌共占6位，依次为1-5号座位的玩家
3 handcards per player occupy 6 bytes, and the seat number from 1 to 5 in sequence
● 最后面一位表示赢家的座位号,1-5分别对应1-5号位
The last byte represent the winner’s seat number, 1-5 respectively corresponding to seat NO.1-5
● 字符与花色对应关系、字符与牌值对应关系同德州扑克
It is the same with Texas Hold'em Poker of the corresponding relationship between Character and Suit,
Character and CardValue
● 例Example：值为：161c1d000000262c2d000000363c3d5表示：1号位玩家手牌♣6♣Q♣K；2号位没有
玩家；3号位玩家手牌♥6♥Q♥K；4号位没有玩家；5号位玩家手牌♠6♠Q♠K；5号位的玩家是赢家
Value is: 161c1d000000262c2d000000363c3d5 represent: seat NO.1 player hands ♣6♣Q♣K; seat
NO.2 no player; seat NO.2 player hands ♥6♥Q♥K; seat NO.4 no player; seat NO.5 player hands
♥6♥Q♥K; the player of seat No.5 is the winner
4.4.5 三公Three-Facecard
如：值为161c1c000000262c2c000000363c3c5
Example: Value is 161c1c000000262c2c000000363c3c5
● 字段规则第一位是花色，第二位数是牌值，第三位是花色，第四位数是牌值，以此类推
Field rule: the first byte is Suit, the second is CardValue, the third it Suit, the forth is CardValue, and so
on
● 每个玩家3张手牌共占6位，依次为1-5号座位的玩家
3 handcards per player occupy 6 bytes, and the seat number from 1 to 5 in sequence
● 最后面一位表示庄家的座位号,1-5分别对应1-5号位
The last byte represent the Banker’s seat number, 1-5 respectively corresponding to seat NO.1-5
● 字符与花色对应关系、字符与牌值对应关系同德州扑克
It is the same with Texas Hold'em Poker of the corresponding relationship between Character and Suit,
Character and CardValue
● 例：值为：161c1d000000262c2d000000363c3d5表示：1号位玩家手牌♣6♣Q♣K；2号位没有玩家；3号
位玩家手牌♥6♥Q♥K；4号位没有玩家；5号位玩家手牌♠6♠Q♠K；5号位的玩家是庄家
Example: 161c1d000000262c2d000000363c3d5 represent: seat NO.1 player hands ♣6♣Q♣K; seat
NO.2 no player; seat NO.2 player hands ♥6♥Q♥K; seat NO.4 no player; seat NO.5 player hands
♠6♠Q♠K; the player of seat No.5 is the Banker
4.4.6 押庄龙虎Dragon-Tiger
如：值为161c0001
Example: Value is 161c0001
89
● 第一位是花色，第二位数是牌值，一二号位组合形成龙的开牌
The first byte is Suit, the second byte is CardValue, the first 2 bytes combined to form the opening of
Dragon
● 第三位是花色，第四位数是牌值，三四号位组合形成虎的开牌
The third byte is Suit, the forth byte is CardValue, the NO.3 and No.4 bytes combined to form the
opening of Tiger
● 第七、八位为开奖结果，01则为龙胜02位虎胜03为和
The 7th and 8th place are the draw results, 01 is the Dragon win, 02 is the Tiger win, and 03 is Tie
● 字符与花色对应关系、字符与牌值对应关系同德州扑克
It is the same with Texas Hold'em Poker of the corresponding relationship between Character and Suit,
Character and CardValue
● 其他多出来的00可忽略不计
Other extra 00 can be ignored
● 字符与开奖点对应关系如下表：
The corresponding relationship between character and openning point are as follows：
字符character 开奖点Opening points
01 龙Dragon
02 虎Tiger
03 和Tie
● 例：值为：161c0002表示：龙开牌♣6，虎开牌♣Q，本局虎赢获胜
Example: Value is: 161c0002 represent: Dragon open ♣6, Tiger open ♣Q, this round Tiger win
4.4.7 21点Blackjack
如：值为02d1317,13d062a,2032703,323253d-333b|41c29|5393b
Example: Value is 02d1317,13d062a,2032703,323253d-333b|41c29|5393b
● 每个逗号内或者竖线内第一位表示玩家座位号，后面每两位表示一张扑克花色和点数。
within each comma or slash, the first byte represent the player’s seat number, and every two behind
represent Suit and Point
● -连接符表示玩家在该座位上进行了分牌，后面每两位表示一张扑克花色和点数。|表示逗号内
的第一个座位号的玩家在某个位置上进行了下注
-dash represent the player distributed cards on this seat，every 2 bytes behind represent suit and
point for 1 card. | represent the player on first seat number within the comma bet on a certain
position
● 第一位是0时表示庄家
When the first byte is 0 represent Banker
● 字符与花色对应关系、字符与牌值对应关系同德州扑克
It is the same with Texas Hold'em Poker of the corresponding relationship between Character and Suit,
Character and CardValue
● 例：值为：02d1317,13d062a,2032703,323253d-233b|41c29|5393b 表示：庄家牌♥K♣3♣7，一号位牌
♠K♦6♥10，二号位牌♦3♥7♦3，三号位进行了分牌：第一墩的牌♥3♥5♠K，第二墩的牌♥3♠J；三号位
在四号空位上进行了下注，四号位的牌为：♣Q♥9 三号位在五号空位上也进行了下注，五号位
90
的牌为：♠9♠J
● Example:
Value is：02d1317,13d062a,2032703,323253d-233b|41c29|5393b represent: Banker hands♥K♣3♣7，
seat No.1 hands♠K♦6♥10，seat No.2 hands♦3♥7♦3，seat No.3 distributed cards：the first set of
cards♥3♥5♠K，the second set of cards♥3♠11；seat No.3 bet on No.4 empty seat, seat No.4 hands：
♣Q♥9 seat No.3 also bet on No.5 empty seat, seat No.5 hands：♠9♠11
4.4.8 通比牛牛Casino Bull-Bull
如：值为360c2c1418000000000000000000000000000000360c2c141800000000001
Example: value is 360c2c1418000000000000000000000000000000360c2c141800000000001
● 字段规则第一位是花色，第二位数是牌值，第三位是花色，第四位数是牌值，以此类推
Field rule: the first byte is Suit, the second is CardValue, the third it Suit, the forth is CardValue, and so
on
● 每个玩家5张手牌共占10位，依次为1-6号座位的玩家
5 handcards per player occupy 10 bytes, and the seat number from 1 to 6 in sequence
● 最后面一位表示赢家的座位号,1-6分别对应1-6号位
The last byte represent the winner’s seat number, 1-6 respectively corresponding to seat NO.1-6
● 字符与花色对应关系、字符与牌值对应关系同德州扑克
It is the same with Texas Hold'em Poker of the corresponding relationship between Character and Suit,
Character and CardValue
● 例：值为：360c2c1418000000000000000000000000000000360c2c141800000000001表示：1号位玩
家手牌♠6♦Q♥ Q♣4♣8；2、3、4号位没有玩家；5号位玩家手牌♠6♦Q♥Q♣4♣8；6号位没有玩家；赢家
是1号位的玩家
● Example:
Value is：360c2c1418000000000000000000000000000000360c2c141800000000001represent: seat
No.1 hands ♠6♦Q♥ Q♣4♣8; seat No.2, 3, 4 has no player; seat No.5 hands ♠6♦Q♥Q♣4♣8; seat No.6 no
player; the winner is seat No.1 player
4.4.9 抢庄牌九Paigow
如：值为14120000151611331
Exampler: Value is 14120000151611331
● 字段规则两个数为一张牌值牌 第一位第二位是一张牌值，第三位第四位是一张牌值，以此类推
two number as one CardValue card, the first and second byte are one CardValue, the third and fourth
byte are one CardValue, and so on
● 字符与牌值对应关系如下：
The corresponding relationship between the character and the CardValue is as follows：
字符character 牌值CardValue
12 丁三D3
24 二四Two four
23 杂五mixed 5
14 杂五mixed 5
91
25 杂七mixed 7
34 杂七mixed 7
26 杂八mixed 8
35 杂八mixed 8
36 杂九mixed 9
45 杂九mixed 9
15 零霖六006
15 零霖六006
16 高脚七High 7
16 高脚七High 7
46 红头十Red head 10
46 红头十Red head 10
56 斧头Axe
56 斧头Axe
22 板凳Bench
22 板凳Bench
33 长三Long 3
33 长三Long 3
55 梅牌Plum card
55 梅牌Plum card
13 鹅牌Goose card
13 鹅牌Goose card
44 人牌Human card
44 人牌Human card
11 地牌Ground card
11 地牌Ground card
66 天牌Sky card
66 天牌Sky card
● 每个玩家2张手牌共占4位，依次为1-4号座位的玩家，最后面一位表示庄家的座位号。 1-4分别对
应1-4号座位
2 handcards per player occupy 4 bytes, and the seat number from 1 to 4 in sequence, the last byte
represent the Banker’s seat number. the No.1 to No.4 byte respectively corresponding to seat NO.1-4
● 例：值为：14120000151611331，表示：1号位玩家手牌14(杂五) 12(丁三)；2号位没有玩家；3号位玩
家手牌15(零霖六) 16(高脚七)；4号位玩家手牌11(地牌) 33(长三)；1号位的玩家是庄家，杂九字符
92
串为36/45，单牌有(上3白+下6白)/(上四红+下5白)
Example: Value is：14120000151611331，represent：handcard of seat No.1 player is 14(mixed 5)
12(D3) no player for seat No.2；handcard of seat No.3 player is 15(006) 16(High 7)；handcard of seat
No.4 player is 11(Ground card) 33(Long 3)； seat No.1 is banker
4.4.10 极速炸金花Speed Golden Flower
如：值为363c3d000000262c2d000000161c1d363c3d000000363c3d0000005
Example: value is 363c3d000000262c2d000000161c1d363c3d000000363c3d0000005
● 字段规则第一位是花色，第二位数是牌值，第三位是花色，第四位数是牌值，以此类推
The first byte of field is suit, the second byte is CardValue, the third is suit, the forth is CardValue, and
so on.
● 每个玩家3张手牌共占6位，依次为1-9号座位的玩家。最后面一位表示赢家的座位号,1-9分别对
应1-9号位
3 cards for each player occupy 6 bytes, and the seat number from 1 to 9 in sequence, the last byte
represent the winner’s seat number, the No.1 to No.9 byte respectively corresponding to seat NO.1-9
● 字符与花色对应关系、字符与牌值对应关系同德州扑克
It is the same with Texas Hold'em Poker of the corresponding relationship between Character and Suit,
Character and CardValue
● 例：值为：363c3d000000262c2d000000161c1d363c3d000000363c3d0000005表示：1号位玩家手牌
♣6♣Q♣K；2号位没有玩家；3号位玩家手牌♥6♥Q♥K；4号位没有玩家；5号位玩家手牌♠6♠Q♠K；6号
位玩家手牌♣6♣Q♣K；7号位没有玩家；8号位玩家手牌♣6♣Q♣K；9号位没有玩家；5号位的玩家是
赢
Example: Value is：161c1d000000262c2d000000363c3d161c1d000000161c1d000000 represent：seat
NO.1 player hands ♣6♣Q♣K；seat NO.2 no player；seat NO.3 player hands ♥6♥Q♥K；NO.4 no player；
seat NO.5 player hands ♠6♠Q♠K；seat NO.6 player hands ♣6♣Q♣K；NO.7 no player；seat NO.8 player
hands ♣6♣Q♣K；NO.9 no player； No.5 is the winner
4.4.11 斗地主Landlord
如：值为Example: Value is:
3611323d092505041c0b222d2414390c29420a16061901151a313a0d2b08272a02073537341726182c38231
333033b431d3c1b2112281
● 字段规则第一位是花色，第二位数是牌值，第三位是花色，第四位数是牌值，以此类推
The first byte of field is suit, the second byte is CardValue, the third is suit, the forth is CardValue, and
so on.
● 每个玩家17张手牌共占34位，依次为1、2、3座位号的玩家
17 handcards per player occupy 34 bytes, and the seat number 1,2,3 in sequence
● 然后是地主牌3张手牌共占6位，最后面一位表示地主的座位号
3 handcards per landlord occupy 6 bytes, the last byte represent the landlord’s seat number.
● 字符与花色对应关系、字符与牌值对应关系同德州扑克
It is the same with Texas Hold'em Poker of the corresponding relationship between Character and Suit,
Character and CardValue
● 则此局：1号位玩家手牌: ♠6 ♣A ♠2 ♠K ♦9 ♥5 ♦5 ♦4 ♣Q ♦J ♥2 ♥K ♥4 ♣4 ♠9 ♦Q ♥9；2号位玩家手牌 小
王 ♦10 ♣6 ♦6 ♣9 ♦A ♣5 ♣10 ♠A ♠10 ♦K ♥J ♦8 ♥7 ♥10 ♦2 ♦7;3号位玩家手牌♠5 ♠7 ♠4 ♣7 ♥6 ♣8 ♥Q ♠8
93
♥3 ♣3 ♠3 ♦3 ♠J 大王 ♣K ♠Q ♣J；地主牌: ♥A ♣2 ♥8; 1号位的玩家是地主
Then this match：NO.1 player hands: ♠6 ♣A ♠2 ♠K ♦9 ♥5 ♦5 ♦4 ♣Q ♦J ♥2 ♥K ♥4 ♣4 ♠9 ♦Q ♥9；NO.2
player hands ：Black joker ♦10 ♣6 ♦6 ♣9 ♦A ♣5 ♣10 ♠A ♠10 ♦K ♥J ♦8 ♥7 ♥10 ♦2 ♦7; NO.3 player hands
♠5 ♠7 ♠4 ♣7 ♥6 ♣8 ♥Q ♠8 ♥3 ♣3 ♠3 ♦3 ♠J Red joker ♣K ♠Q ♣J；landlord card: ♥A ♣2 ♥8; NO.1 player is
landlord
4.4.12 十三水Pineapple Poker
如：值为Example: Value is:
3b2c110,04352607384,323d2d1d0d7,4;342b0b1,2336062a1a2,22123929096,1;083a3c0,33252731011,131
516171c5,2; 1112131415161718191a1b1c1d263;0
● 一个分号分割一个玩家，共4个玩家，最后一个分号后面的0无意义
One divides one player, 4 players in total, the 0 after the last semicolon is meaningless
● 两位表示一张牌，第一位是花色，第二位数是牌值，以此类推
Two bytes as one card, the first byte is suit, the second byte is CardValue, and so on
● 每个分号内，用逗号隔开玩家的3墩牌，分号前一位表示玩家座位号
Within each semicolon, use comma to divide 3 set of cards of each player, the byte before semicolon is
the seat number of the player
● 首墩共3张牌，中墩和尾墩都是5张，多余的字符表示牌型
The first set is 3 cards, the middle and last set is 5 for each, the spare byte represent card mode
● 特殊牌型不分墩，倒数第二三位表示牌型，最后一位表示座位号
Do not divide into sets for special card mode, the last 2nd and 3rd byte represent card mode, the last
byte represents seat number
● 字符与花色对应关系、字符与牌值对应关系同德州扑克
It is the same with Texas Hold'em Poker of the corresponding relationship between Character and Suit,
Character and CardValue
● 字符与牌型对照如下：
The corresponding relationship between the character and the card mode is as follows：
牌型对应Card mode corresponding
0 乌龙oolong 16 六对半Six pairs and half
1 一对One pair 17 五对三条Five pairs and three of a kind
2 两对Two pairs 18 四套三条Four sets and three of a kind
3 三条Three pairs 19 凑一色Gather together color
4 顺子Straight 20 全小All small
5 同花flush 21 全大All big
6 葫芦gourd 22 三分天下thethirded
7 铁支Four of a Kind 23 三同花顺Three straight flush
8 同花顺Straight flush 24 十二皇族12 the royal family
14 三同花Three flush 25 十三水Pineapple Poker
15 三顺子Three straight 26 至尊青龙The supreme tsing lung
94
● 则此局四家的牌分别为（示例只是表示解读规则，不代表真实牌局）：
● 4号位, ♠J♥Q♣A乌龙, ♦4♠5♥6♦7♠8顺子, ♠2♠K♥K♣K♦K铁支
● 1号位, ♠4♥J♦J对子, ♥3♠6♦6♥10♣10两对, ♥2♣2♠9♥9♦9葫芦
● 2号位, ♦8♠10♠Q乌龙, ♠3♥5♥7♠A♦A一对, ♣3♣5♣6♣7♣Q同花
● 3号位, ♣1♣2♣3♣4♣5♣6♣7♣8♣9♣10♣J♣Q♣K至尊青龙
The card for the 4 players are(the example only represents the reading rule, not the real match)
No.4, ♠J♥Q♣A oolong, ♦4♠5♥6♦7♠8 Straight, ♠2♠K♥K♣K♦K Four of a Kind
No.1, ♠4♥J♦J One pair, ♥3♠6♦6♥10♣10 Two pairs, ♥2♣2♠9♥9♦9 gourd
No.2, ♦8♠10♠Q oolong, ♠3♥5♥7♠A♦A One pair, ♣3♣5♣6♣7♣Q flush
No.3, ♣1♣2♣3♣4♣5♣6♣7♣8♣9♣10♣J♣Q♣K The supreme tsing lung
4.4.13 百家乐Baccarat
如：值为2a23332a1c041
Example: Value is 2a23332a1c041
● 前6位是闲，7-12位是庄，12位以后是胜利的下注点ID
the first 6 bytes are Player，7-12 bytes are banker, bytes after 12 are betting point ID of success
● 前12位，第一位是花色，第二位是牌值，第三位是花色，第四位是牌值，以此类推
The first 12 bytes，the first byte is suit，second is CardValu，the third is suit, the forth is CardValue,
and so on.
● 庄闲各最少两张牌最多三张牌，如果第三张牌没发，对应牌值为00
2 cards for the least 3 cards for the most for both Player and Banker, if the third cards does not
distributed, corresponding card value is 00
● 字符与花色对应关系、字符与牌值对应关系同德州扑克
It is the same with Texas Hold'em Poker of the corresponding relationship between Character and Suit,
Character and CardValue
● 下注点与字符对应关系如下表：
The corresponding relationship between the betting point and character as follow ：
字符CharacterBet 下注点ting point
庄Banker 2
闲Player 1
和Tie 3
庄对Banker Pair 6
闲对Player right 7
大Big 8
小Small 9
● 则此局闲牌♥10♥3 ♠3，庄牌♥10♣Q♦4；胜利下注点为1，对应闲赢
Then the Player cards of this match♥10♥3 ♠3，Banker cards♥10♣Q♦4； the betting point of success is 1
4.4.14 森林舞会Forest Party
如：值为5RB08YC16
95
Example ：value is 5RB08YC16
● 字段第一位是事件。1:无事件 2：大三元 3：大四喜 4：霹雳闪电 5 ：送灯。从第二位起，每四位表
示一个开奖结果，多个结果依此类推
the first byte of field is incident。1:no incident 2：big three 3：big four 4：lightning bolt 5 ：get light.
start from the second byte ，each 4 bytes represent a result ，and so on, for each multiple results.
● 第二位是动物的颜色。R：红色,G:绿色,Y:黄色; 第三位是动物类型：A:狮子,B:熊猫,C:猴子,D:兔子；
第四位和第五位组成赔率，08表示赔率是 8 倍。那么以上例子的开奖结果为：送灯，红色熊猫8
倍和黄色猴子16倍。
the second byte is the color of animal 。R：red ,G:green,Y:yellow ; the third byte is animal type ：
A:lion,B:panda,C:monkey ,D:rabbit ；fourth and fifth together as odds，08 represent odds is octuple.so
the result of the above sample is ：get light，red panda octuple and yellow monkey 16 times.
● 注：大三元有3个开奖结果；大四喜油4个开奖结果，送灯有2个开奖结果，霹雳闪电赔率翻倍。
Remark：big three has 3 results ；big four has 4 results ，get light has 2 results ，lighting bolt's odds
double.
4.4.15 百人牛牛Niu-Niu For Thousands Person
● 1-5分别代表天地玄黄庄位置
1-5 represent respectively Sky ,Floor, Xuan and Yellow banker’s seat
● 如：值为12a3a09181522528273d3431b2b1a0706435083739125110d140322020304
example：value is 12a3a09181522528273d3431b2b1a0706435083739125110d140322020304
● Ø 字段规则第一位数是位置 第二位数是花色，第三位数是牌值，第四位是花色，第五位数是牌
值，以此类推
the first byte is seat, the second is Suit, the third it CardValue, the forth is Suit, the fifth is CardValue
and so on.
● 每个位置5张手牌共占11位，依次为天地玄黄庄。后面数字代表赢的位置，每个位置占两个字符
Ø 字符与花色对应关系、字符与牌值对应关系同德州扑克
handcards per seat occupy 11 bytes, and the seats are Sky ,Floor, Xuan and Yellow in sequence.The
numbers followed represent the seat of the winner, each occupy 2 bytes.It is the same with Texas
Hold'em Poker of the corresponding relationship between Character and Suit, Character and
CardValue
● 例如值为：12a3a09181522528273d3431b2b1a0706435083739125110d140322020304表示
天号位手牌为: ♥10♠10♦9♣8♣5
地号位手牌为: ♥5♥8♥7♠K♠4
玄号位手牌为: ♣J♥J♣10♦7♦6
黄号位手牌为: ♠5♦8♠7♠9♣2
庄家手牌为： ♣A♦K♣4♦3♥2
020304表示地 玄 黄三个位置赢了
example：value is 12a3a09181522528273d3431b2b1a0706435083739125110d140322020304
reprexent：
handcards of Sky seat is: ♥10♠10♦9♣8♣5
handcards of Floor seat is: ♥5♥8♥7♠K♠4
handcards of Xuan seat is: ♣J♥J♣10♦7♦6
handcards of Yellow seat is: ♠5♦8♠7♠9♣2
96
handcards of Dealer is: ♣A♦K♣4♦3♥2
020304 represent Floor, Xuan, Yellow these 3 seats wined
4.4.16 万人炸金花Golden Flower For Thousands Person
● 1-5分别代表天地玄黄庄位置
1-5 represent the location of Sky, Floor, Xuan, Yellow and Dealer respectively
● 如：值为13a192623b3612331170242d2a28506052404
For example, the value is 13a192623b3612331170242d2a28506052404
● Ø 字段规则第一位数是位置 第二位数是花色，第三位数是牌值，第四位是花色，第五位数是牌
值，以此类推
The first digit of the field is the position, the second digit is the suit, the third digit is the card number,
the fourth digit is the suit, the fifth digit is the card number, and so on.
● 每个位置3张手牌共占7位，依次为天地玄黄庄。后面数字代表赢的位置，每个位置占两个字符
Each position has Three cards. There are seven places totally, they are Sky, Floor, Xuan, Yellow and
Dealer. The latter number represents the winning position, each of which takes up two characters.
● Ø 字符与花色对应关系、字符与牌值对应关系同德州扑克
The connection between Character and suits, character and card number of Texas Poker
● 例如值为：13a1926 23b3612 3311702 42d2a28 5060524 04表示
天号位手牌为: ♠10♣9♥6
地号位手牌为: ♠J♠6♣2
玄号位手牌为: ♠A♣7♦2
黄号位手牌为: ♥K♥10♥8
庄家手牌为： ♦6♦5♥4
04表示黄位置赢了
For example, the value: 13a192623b3612331170242d2a28506052404 means,
The Sky Position: ♠10♣9♥6
The Floor Position: ♠J♥6♣2
The Xuan Position: ♠A♣7♦2
The Yellow Position: ♥K♥10♥8
The Dealer's hand: ♦6♦5♥4
04 means the Yellow position wins.
4.4.17 血流成河Bleeding Mahjong
如：值为1617182222252515151529292929,121213151617181919193839,
24252626272833353636232323,21222326272833343538383939,3
For example:
1617182222252515151529292929,121213151617181919193839,
24252626272833353636232323,21222326272833343538383939,3
● 第一个逗号前是1号位本局结束时的牌
The tile before the 1st comma is the one that the position 1 player has when the game is over.
● 第二个逗号前是2号位本局结束时的牌，
The tile before the 2nd comma is the one that the position 2 player has when the game is over.
● 第三个逗号前是3号位本局结束时的牌
97
The tile before the 3rd comma is the one that the position 3 player has when the game is over.
● 第四个逗号前是4号位本局结束时的牌
The tile before the 4th comma is the one that the position 4 player has when the game is over.
● 第四个逗号后面表示庄家的座位号
The dealer’s seat number is shown after the 4th comma.
● 执行碰杠的牌值会放在后方
The tiles to be used for claiming a tile to match a triplet and claiming a tile for a quadruplet will be
placed at the back
● 每个牌值占两位，对应关系见下表：
Each tile occupies two characters. Please refer to the following table for correspondence:
字符
Characters
牌值
Tile
字符
Characters
牌值
Tile
字符
Characters
牌值
Tile
11 一万
Character 一
21 一条
One Bamboo
31 一筒
One Circle
12
二万
Character 二
22
二条
Two Bamboos
32
二筒
Two Circles
13 三万
Character 三
23 三条
Three bamboos
33 三筒
Three Circles
14 四万
Character 四
24 四条
Four Bamboos
34 四筒
Four Circles
15 五万
Character 五
25 五条
Five Bamboos
35 五筒
Five Circles
16 六万
Character 六
26 六条
Six Bamboos
36 六筒
Six Circles
17 七万
Character 七
27 七条
Seven Bamboos
37 七筒
Seven Circles
18 八万
Character 八
28 八条
Eight Bamboos
38 八筒
Eight Circles
19 九万
Character 九
29 九条
Nine bamboos
39 九筒
Nine Circles
● 则本局结束
Then, this round of the game is over:
1号位玩家牌为：六万、七万、八万、二条、二条、五条、五条、五万、五万、五万、九条、九条、九
条、九条
2号位玩家牌为：二万、二万、三万、五万、六万、七万、八万、九万、九万、九万、八筒、九筒
3号位玩家牌为：四条、五条、六条、六条、七条、八条、三筒、五筒、六筒、六筒、三条、三条、三
条
4号位玩家牌为：一条、二条、三条、六条、七条、八条、三筒、四筒、五筒、八筒、八筒、九筒、九
筒
3号玩家为庄家
he tiles for position 1 player are: character 六, character 七, character 八, two bamboos, two
98
bamboos, five bamboos, five bamboos, character 五, character 五, character 五, nine bamboos, nine
bamboos, nine bamboos, nine bamboos;
The tiles for position 2 player are: character 二, character 二, character 三, character 五, character 六,
character 七, character 八, character 九, character 九, character 九, eight circles, nine circles;
The tiles for position 3 player are: four bamboos, five bamboos, six bamboos, six bamboos, seven
bamboos, eight bamboos, three circles, five circles, six circles, six circles, three bamboos, three
bamboos, three bamboos.
4.4.18 看牌抢庄牛牛Banker Bull-Bull After Check Card
● 解析规则同抢庄牛牛
Same as Banker Bull-Bull
● 5张牌中前3张表示开局发的3张明牌，最后2张依次为追加的暗牌
The first 3 of the 5 CARDS represent the opening 3 clear CARDS, and the last 2 CARDS are the added
dark CARDS
4.4.19 二人麻将2 Persons’ Mahjong 2
如：值为0203040506070203040506071111,0102030607081212121315151528,0
Example:
Value is 0203040506070203040506071111,0102030607081212121315151528,0
● 第一个逗号前是1号位本局结束时的牌，第二个逗号前是2号位本局结束时的牌，第二个逗号后
面表示庄家的座位号(本游戏没有庄家,固定为0)
The first comma is the card at the end of the first position. The second comma is the card at the end of
the second position. the last byte is meaningless
● 每个牌值占两位，对应关系见下表：
Each card value is two digits, the corresponding relationship is shown in the following table:
字符
Character
牌值
CardValue
字符
Character
牌值
CardValue
01 一万
One Characters
14 北风
North Wind
02
二万
Two Characters
15 中
Red Dragon
03 三万
Three Characters
16 发
Green Dragon
04 四万
Four Characters
17 白
White Dragon
05 五万
Five Characters
21 春
Spring
06 六万
Six Characters
22 夏
Summer
07 七万
Seven Characters
23 秋
Autumn
08 八万 24 冬
99
Eight Characters Winter
09 九万
Nine Characters
25 梅
Plum
11 东风
East Wind
26 兰
Orchid
12 南风
South Wind
27 竹
Bamboo
13 西风
West Wind
28 菊
Chrysanthemum
● 则本局结束，1号位玩家牌为：二万、三万、四万、五万、六万、七万、二万、三万、四万、五万、六
万、七万、东风、东风；2号位玩家牌为：一万、二万、三万、六万、七万、八万、南风、南风、南
风、西风、中、中、中、菊；没有庄家
End of this game, the 1st player card is：Two Characters、Three Characters、Four Characters、Five
Characters、Six Characters、Seven Characters、Two Characters、Three Characters、Four Characters、
Five Characters、Six Characters、Seven Characters、East Wind、East Wind；The 2nd player card is：One
Characters、Two Characters、Three Characters、Six Characters、Seven Characters、Eight Characters、
South Wind、South Wind、South Wind、West Wind、Red Dragon、Red Dragon、Red Dragon、
Chrysanthemum
4.4.20 幸运转盘Lucky Dial
如：值为10
For example, the value is 10
● 玩家在本局中获取的奖金倍数，如值为10代表的意思玩家在本局中获取下注金额的10倍奖金
A multiplier of the bonus that the player receives in the game. If the value is 10, the player receives 10
times the amount of the bet in the game.
4.4.21 金鲨银鲨Golden Shark & Silver Shark
如：值为04121102, 四个位数为一组, 前两位为下注点, 后两位为赔率
For example, the value is 04121102
● 字段前两位是中奖的下注点序号。01：燕子 02：鸽子 03：孔雀 04：老鹰 05：兔子 06：猴子 07：熊
猫 08：狮子 09：银鲨 10：金鲨 10：金鲨11：飞禽12：走兽。
The first two digits of the field are the number of the annotation points for winning the prize. 01:
Swallow 02: Pigeon 03: Peacock 04: Eagle 05: Rabbit 06: Monkey 07: Panda 08: Lion 09: Silver Shark
10: Gold Shark 11:Birds 12:Beasts. The last two digits are odds, 12 means the odds are 12 times.
● 01~04属于飞禽，05~08属于走兽，后两位是赔率，12表示赔率是12倍。
那么以上例子的开奖结果为：老鹰12倍, 飞禽2倍
01~04 are Birds, 05~08 are Beasts.So, the prize-winning result of the above example is: eagle 12 times
birds 2 times
4.4.22 奔驰宝马Benz & BMW
如：值为0140
For example, the value is 0140
100
● 字段前两位是中奖的下注点序号。01：法拉利 02：兰博基尼 03：玛莎拉蒂 04：保时捷 05：雷克
萨斯 06：大众 07：奔驰 08：宝马。后两位是赔率，40表示赔率是40倍。
The first two digits of the field are the number of the annotation points for winning the prize. 01:
Ferrari 02: Lamborghini 03: Maserati 04: Porsche 05: Lexus 06: Volkswagen 07: Benz 08: BMW. The last
two digits are odds, 40means the odds are 40 times.
● 那么以上例子的开奖结果为：法拉利40倍
So, the prize-winning result of the above example is: Ferrari 40 times
4.4.23 百人骰宝Sic Bo
如：值为66600118
For example: the value is 66600118
● 第一位是第一个骰子点数，第二位是第二个骰子点数，第三位是第三个骰子点数
The first is the points on the first dice, the second is the points on the second dice, the third is the
points on the third dice
● 第四位是大小，1是大2是小，如果是0，则表示豹子
The fourth is big and small, 1 is big and 2 is small, if it is 0, it means leopard
● 第五位是单双，1是单2是双，如果是0，则表示豹子
The fifth is single and double, 1 is single and 2 is double, if it is 0, it means leopard
● 第六位为豹子，0是没有豹子，1则表示是豹子
The sixth is leopard, 0 is no leopard, 1 means leopard
● 第七位和第八位为点数总和，3~18点
The seventh and eighth are the sum of points, point 3~18
● 字符与开奖点对应关系如下表：
The relationship between the number and the lottery point is as follows:
● 例：值为：23522010表示：开骰结果为2，3，5 10点小 双
For example: Value: 23522010 means: dice result is 2, 3, 5, 10 points small double
4.4.24 单挑牛牛 1V1 Bull-Bull
● 如：值为36041a313d331928032b02
For example: the value is 36041a313d331928032b02
● 字段规则第一位是花色，第二位数是牌值，第三位是花色，第四位数是牌值，以此类推
Rule of the field: the first is the suit, the second is the card value, the third is the suit, the fourth is the
card value, and so on
● 每个玩家5张手牌共占10位，依次为1-2号座位的玩家
Each player has 5 cards accounting for 10, which are the players in seats 1-2
● 最后面二位表示赢家的座位号,01、02分别对应1-2号位
The last two-digits is the seat number of the winner, 01-02 corresponds to 1-2 respectively
● 字符与花色对应关系、字符与牌值对应关系同德州扑克
The corresponding of the suit and the number and the corresponding of the number and card value
are like Texas Hold’ em
● 例：值为：36041a313d331928032b02 表示：1号位玩家手牌♠6 ♦4 ♣10 ♠A ♠K ；2号位玩家手牌♠3 ♣9
♥8 ♦3 ♥J ；最后二位是02赢家是2号位的玩家
101
For example: The value: 36041a313d331928032b02 means: the first player’s card ♠6 ♦4 ♣10 ♠A ♠K;
the second player’s card ♠3 ♣9 ♥8 ♦3 ♥J; The last two-digits is 02, so the winner is the second player
4.4.25 炸金牛Golden Bull
如：值为3d213331273c2a09161705253a18140000000000392c0c2b080
For example: the value is 3d213331273c2a09161705253a18140000000000392c0c2b080
● 字段规则第一位是花色，第二位数是牌值，第三位是花色，第四位数是牌值，以此类推
Rule of the field: the first is the suit, the second is the card value, the third is the suit, the fourth is the
card value, and so on
● 每个玩家5张手牌共占10位，依次为1-5号座位的玩家
Each player has 5 cards accounting for 10, which are the players in seats 1-5
● 第51位”0”,无意义请忽略
51st " 0 " , meaningless, please ignore
● 黑桃、红桃、梅花和方片编号为3、2、1、0
Spades, hearts, clubs and diamonds are numbered 3, 2, 1, 0
● 字符与花色对应关系、字符与牌值对应关系如下表
The corresponding of the suit and the number and the corresponding of the number and card value
are like the following table
牌点Card
花色Suit
A 2 3 4 5 6 7 8 9 10 J Q K
黑桃3 Spades 3 31 32 33 34 35 36 37 38 39 3a 3b 3c 3d
红桃2 Hearts 2 21 22 23 24 25 26 27 28 29 2a 2b 2c 2d
梅花1 Clubs 1 11 12 13 14 15 16 17 18 19 1a 1b 1c 1d
方片0 Diamonds 0 01 02 03 04 05 06 07 08 09 0a 0b 0c 0d
例值为：3d213331273c2a09161705253a18140000000000392c0c2b080
For example: the value is 3d213331273c2a09161705253a18140000000000392c0c2b080
● 1号玩家手牌：第1位~第10位代表1号玩家手牌为：♠K、♠A、♠3、♠A、♥7
The first player’s cards: 1st~10th represent the first player’s cards are: ♠K、♠A、♠3、♠A、♥7
● 2号玩家手牌：第11位~第20位代表2号玩家手牌为：♠Q、♥10、♦9、♣6、♣7
The second player’s cards: 11th~20th represent the second player’s cards are: ♠Q、♥10、♦9、♣6、♣7
● 3号玩家手牌：第21位~第30位代表3号手牌为：♦5、♥5、♠10、♣8、♣4
The third player’s cards: 21st~30th represent the third player’s cards are: ♦5、♥5、♠10、♣8、♣4
● 4号玩家手牌：第31位~第40位代表4号位：0000000000，表示无人
The fourth player’s cards: 31st~40th represent No. 4: 0000000000, means no one
● 5号玩家手牌：第41位~第50位代表5号玩家牌：♠9、♥Q、♦Q、♥J、♦8
The fifth player’s cards: 41st~50th represent the fifth player’s cards are: ♠9、♥Q、♦Q、♥J、♦8
4.4.26 押宝抢庄牛牛Bet 3 Players Bull-Bull
如：值为3d213331273c2a09161705253a1814392c0c2b080
For example: the value is 3d213331273c2a09161705253a1814392c0c2b080
102
● 字段规则第一位是花色，第二位数是牌值，第三位是花色，第四位数是牌值，以此类推
Rule of the field: the first is the suit, the second is the card value, the third is the suit, the fourth is the
card value, and so on
● 每个玩家5张手牌共占10位，依次为1-4号座位的玩家
Each player has 5 cards accounting for 10, which are the players in seats 1-4
● 第41位0表示庄家的座位号,1~4分别对应1~4号位
No. 41 0 means banker’s seat number, 1~4 corresponds to 1~4 respectively
● 黑桃、红桃、梅花和方片编号为3、2、1、0
Spades, hearts, clubs and diamonds are numbered 3, 2, 1, 0
花色牌点对应编号表：
Corresponding number table of suit and card points:
牌点Card
花色Suit
A 2 3 4 5 6 7 8 9 10 J Q K
黑桃3 Spades 3 31 32 33 34 35 36 37 38 39 3a 3b 3c 3d
红桃2 Hearts 2 21 22 23 24 25 26 27 28 29 2a 2b 2c 2d
梅花1 Clubs 1 11 12 13 14 15 16 17 18 19 1a 1b 1c 1d
方片0 Diamonds 0 01 02 03 04 05 06 07 08 09 0a 0b 0c 0d
● 字符与花色对应关系、字符与牌值对应关系如下表
The corresponding of the suit and the number and the corresponding of the number and card value
are like the following form
例值为：3d213331273c2a09161705253a1814392c0c2b081
For example: the value is 3d213331273c2a09161705253a1814392c0c2b081
● 1号玩家手牌：第1位~第10位代表1号玩家手牌为：黑桃K、红桃A、黑桃3、黑桃A、红桃7
The first player’s cards: 1st~10th represent the first player’s cards are: ♠K、♠A、♠3、♠A、♥7
● 2号玩家手牌：第11位~第20位代表2号玩家手牌为：黑桃Q、红桃10、方片9、梅花6、梅花7
The second player’s cards: 11th~20th represent the second player’s cards are: ♠Q、♥10、♦9、♣6、♣7
● 3号玩家手牌：第21位~第30位代表3号手牌为：方块5、红桃5、黑桃10、梅花8、梅花4
The third player’s cards: 21st~30th represent the third player’s cards are: ♦5、♥5、♠10、♣8、♣4
● 4号玩家手牌：第31位~第40位代表5号玩家牌：黑桃9、红桃Q、方片Q、红桃J、方片8
The fifth player’s cards: 31st~40th represent the fifth player’s cards are: ♠9、♥Q、♦Q、♥J、♦8
● 第41位~1代表庄家为1号位玩家
No. 41~ 1 means banker which is the first player
4.4.27 红包捕鱼Fishing
● 红包捕鱼不需要解析CardValue。
Red envelope fishing doesn’t need analysis card value.
● 查看对局详情即可。
You can check the game details.
103
4.4.28 搏一搏Give A Bet
如：值为3.5
For example: the value is 3.5
● 玩家在本局中获取的奖金倍数，如值为3.5意思玩家在本局中获取下注金额的3.5倍的奖励
The multiple of bonus by the player in the game, such as 3.5 means the 3.5 times of bet amounts by
the player in this game
4.4.29 五星宏辉Five Stars
如：值为2502
For example: the value is 2502
● 字段规则第一位是花色，第二位数是牌值，第三四位为赢得位置
Rule of the field: the 1st is the suit, the 1nd is the card value, the 3rd & 4th is the winning position.
● 字符与花色对应关系、字符与牌值对应关系同德州扑克
Correspondence between character and suit color, character and card value correspondence with
Texas Hold'em
● 黑桃、红桃、梅花、方片和大小王编号为3、2、1、0、4
Spades, hearts, clubs, Diamond, Jokers piece and numbered 0,1,2,3,4
● 赢得位置为01黑桃、02红桃、03梅花、04方片、05大小王
Win position is 01 Spades, 02 Hearts, 03 Clubs, 04 Diamond, 05 Jokers
● 例：2502表示牌值为♥5 赢得位置为红
Example: 2502 brand value indicates the position of red win ♥ 5
● 花色牌点对应编号表：
The color card corresponds to the number table:
牌点Card
花色 Suit
A 2 3 4 5 6 7 8 9 10 J Q K
小王
Black
joker
大王
Red
joker
黑桃3 Spades 3 31 32 33 34 35 36 37 38 39 3a 3b 3c 3d / /
红桃2 Hearts 2 21 22 23 24 25 26 27 28 29 2a 2b 2c 2d / /
梅花1 Clubs 1 11 12 13 14 15 16 17 18 19 1a 1b 1c 1d / /
方片0 Diamond 0 01 02 03 04 05 06 07 08 09 0a 0b 0c 0d / /
大小王4 Jokers 4 / / / / / / / / / / / / / 42 43
4.4.30 赌场扑克Casino Poker
如：值为12010d180b2238140623352a24091d15250
For example: the value is 12010d180b2238140623352a24091d15250
● 字段规则第一位是花色，第二位数是牌值，第三位是花色，第四位数是牌值，以此类推
Rule of the field: the first is the suit, the second is the card value, the third digit is the suit, the fourth
digit is the card value, and so on.
● 第1位~第10位代表公共牌，第11位~第14位代表庄家手牌，第15位~第18位代表1号玩家手牌，第
19位~第22位代表2号玩家手牌，第23位~第26位代表3号手牌，第27位~第30位代表4号玩家牌，
第31位~第34位代表5号玩家牌，第35位0表示庄家的座位号。
The 1st to the 10th digit represent the community cards (board). The 11th to the 14th digit represent
104
the dealer’s hand. The 15th to the 18th digit represent the hand of player no. 1. The 19th to the 22nd
digit represent the hand of player no. 2. The 23rd to 26th digit represent the hand of player no. 3. The
27th to 30th digit represent the hand of player no. 4. The 31st to 34th digit represent the hand of
player no. 5. The 35th digit, 0, represents the seat number of the dealer.
● 公共牌 5张共占10位
5 public cards in 10 places
● 庄家有2张手牌共占4位
The dealer has two hand cards in 4 places
● 每个玩家2张手牌共占4位
Each player two hand cards in 4 places
● 黑桃、红桃、梅花和方片编号为3、2、1、0
Spades, Hearts, Clubs and Diamonds pieces numbered 3,2,1,0
● 花色牌点对应编号表：
The color card corresponds to the number table:
牌点Card
花色Suit
A 2 3 4 5 6 7 8 9 10 J Q K
黑桃3 Spades 3 31 32 33 34 35 36 37 38 39 3a 3b 3c 3d
红桃2 Hearts 2 21 22 23 24 25 26 27 28 29 2a 2b 2c 2d
梅花1 Clubs 1 11 12 13 14 15 16 17 18 19 1a 1b 1c 1d
方片0 Diamonds 0 01 02 03 04 05 06 07 08 09 0a 0b 0c 0d
● 字符与花色对应关系、字符与牌值对应关系如下表
correspondence between characters and suits, and the correspondence between characters and card
values are as follows:
例值为：12010d180b2238140623352a24091d15250
Example value is: 12010d180b2238140623352a24091d15250
● 公共牌：第1位~第10位代表 公共牌为：梅花2、方片A、方片K、梅花8、方片J
Public cards：The first to the tenth represent the public card: ♣2、♦A、♦K、♣8、♦J
● 庄家手牌：第11位~第14位代表 庄家手牌为：红桃2、黑桃8
Bank hand: 11th ~ 14th representative banker's hand: ♥2、♠8
● 1号玩家手牌：第15位~第18位代表1号玩家手牌为：梅花4、方片6、
No. 1 player's hand: 15th ~ 18th represents the 1st player: ♣4、♦6、
● 2号玩家手牌：第19位~第22位代表2号玩家手牌为：红桃3、黑桃5、
No. 2 player's hand: 19th ~ 22nd represents the 2nd player: ♥3、♠5、
● 3号玩家手牌：第23位~第26位代表3号手牌为：红桃10、红桃4
No. 3 player's hand: 23rd ~ 26th represents the 3rd player: ♥10、♥4
● 4号玩家手牌：第27位~第30位代表4号玩家牌：方片9、梅花K
No. 4 player's hand: 27th ~ 30th represents the 4th player: ♦9、♣K
● 5号玩家手牌：第31位~第34位代表5号玩家牌：梅花5、红桃5
No. 5 player's hand: 31st ~ 34th represents 5th player: ♣5、♥5
● 第35位~0代表庄家为0号位玩家（也就是荷官为庄家）
The 35th ~ 0 means the dealer is the 0 player
105
● 如若座位上的数值为0000则表示该座位没有玩家
If the value on the seat is 0000, it means there is no player in the seat.
4.4.31 港式梭哈Hong Kong Stud
如：值为3a283c082c39092a2d0c010a3b0d11000000000018191c38210
For example: the value is 3a283c082c39092a2d0c010a3b0d11000000000018191c38210
● 字段规则第一位是花色，第二位数是牌值，第三位是花色，第四位数是牌值，以此类推
Rule of the field: the first is the suit, the second is the card value, the third digit is the suit, the fourth
digit is the card value, and so on.
● 每个玩家5张手牌共占10位，依次为1-5号座位的玩家
Each player five hand cards in 10 places, followed by the player 1-5 seats
● 第51位0表示庄家的座位号,1~5分别对应1~5号位
The 51st place 0 indicates the seat number of the dealer, and 1~5 corresponds to the 1~5 position
respectively.
● 黑桃、红桃、梅花和方片编号为3、2、1、0
Spades, Hearts, Clubs and Diamonds pieces numbered 3,2,1,0
● 花色牌点对应编号表：
The color card corresponds to the number table:
牌点Card
花色 Suit
A 8 9 10 J Q K
黑桃3 Spades 3 31 38 39 3a 3b 3c 3d
红桃2 Hearts 2 21 28 29 2a 2b 2c 2d
梅花1 Clubs 1 11 18 19 1a 1b 1c 1d
方片0 Diamonds 0 01 08 09 0a 0b 0c 0d
● 字符与花色对应关系、字符与牌值对应关系如下表
The correspondence between characters and suits, and the correspondence between characters and
card values are as follows:
● 例值为：3a283c082c39092a2d0c010a3b0d11000000000018191c3821
Example value is: 3a283c082c39092a2d0c010a3b0d11000000000018191c3821
● 1号玩家手牌：第1位~第10位代表1号玩家手牌为：黑桃10、红桃8、黑桃Q、方块8、红桃Q
No. 1 player's hand: 1st ~ 10th represents the 1st player: ♠10、♥8、♠Q、♦8、♥Q
● 2号玩家手牌：第11位~第20位代表2号玩家手牌为：黑桃9、方块9、红桃10、红桃K、方块Q
No. 2 player's hand: 11th ~ 20th represents the 2nd player: ♠9、♦9、♥10、♥K、♦Q
● 3号玩家手牌：第21位~第30位代表3玩家手牌为：方块A、方块10、黑桃J、方块K、梅花A
No. 3 player's hand: 21th ~ 30th represents the 3rd player: ♦A、♦10、♠J、♦K、♣A
● 4号玩家手牌：第31位~第40位代表4玩家手牌为：空
No. 4 player's hand: 27th ~ 30th represents the 4th player: empty
● 5号玩家手牌：第41位~第50位代表5玩家手牌为：梅花8、梅花9、梅花Q、红桃8、红桃A
No. 5 player's hand: 31st ~ 34th represents 5th player: ♣8、♣9、♣Q、♥8、♥A
106
4.4.32 血战骰宝Karmic SicBo
如：值为5555115155516660000032666161660
For example: the value is 5555115155516660000032666161660
● Ø每个玩家手牌共占5位，从左到右依次为1-6号玩家手牌信息
Each player's hand takes up 5 digits, from left to right , the player's hand information is 1-6
● Ø第31位”0”,无意义请忽略
31st " 0 " , meaningless, please ignore
● Ø骰子的1、2、3、4、5、6点分别用1、2、3、4、5、6代替
The dice 1 , 2 , 3 , 4 , 5 , 6 points are by 1 , 2 , 3 , 4 , 5 , 6 in place of
例值为：5555115155516660000032666161660
Example value is: 5555115155516660000032666161660
● 1号玩家手牌：第1位~第5位代表1号玩家手牌为：55551，牌型为炸弹
No. 1 player's hand: 1st ~ 5th represents the 1st player: 55551，card type is Bomb
● 2号玩家手牌：第6位~第10位代表2号玩家手牌为：15155，牌型为葫芦
No. 2 player's hand: 6th ~ 10th represents the 2nd player: 15155，card type is Full House
● 3号玩家手牌：第11位~第15位代表3号手牌为：51666，牌型为三条
No. 3 player's hand: 11th ~ 15th represents the 3rd player: 51666，card type is Three-Of-A-Kind
● 4号玩家手牌：第16位~第20位代表4号位：0000000000，表示无人，座位为空
No. 4 player's hand: 27th ~ 30th represents the 4th player: 0000000000，expressed nobody seat is
empty
● 5号玩家手牌：第21位~第25位代表5号玩家牌：32666，牌型为三条
No. 5 player's hand: 31st ~ 34th represents 5th player: 32666，card type is Three-Of-A-Kind
● 6号玩家手牌：第26位~第30位代表5号玩家牌：16166，牌型为葫芦
No. 5 player's hand: 31st ~ 34th represents 5th player: 16166，card type is Full House
4.4.33 水果机Fruit Machine
如：值为08010701
For example: the value is 08010701
● 第一第二位为猜大小的点数。00代表玩家不猜大小 ，01~06代表小， 07代表通杀，08~13代表大
The first two digits are the guess points. 00 means the player does not guess the size, 01 ~ 06 means
small, 07 means pass kill, 08 ~ 13 means big
● 第三第四位为开奖事件说明。见表1
The third and fourth digit is the explanation of the lottery event. See table 1
● 从第五位开始，每四位代表一个开奖点，其中前2位代表水果类型(如表2)，后2位代表前端开奖
点(如表3)
Starting from the fifth position, every four digits represent a lottery point, of which the first two digits
represent the type of fruit (as shown in Table 2) and the last two digits represent the front lottery
points (as shown in Table 3)
举例说明：
值为08010701
For example:
The value is 08010701
107
● 猜大小：点数08为大
Guess the size: the number of points is 08
● 开奖事件：无事件
Draw event: No Event
● 开奖点：小铃铛对应前端开奖点为01位置
Lottery: Small bell corresponding to the front of the lottery point for 01 position
事件说明Event Description
1 无事件No Event
2 普通事件Ordinary Event
3 特殊事件Special Event
4 虚假事件False Event
5 大四喜Great Four
6 小三元Small Three
7 大三元Great Three
8 纵横四海Four Seas
9 大满贯Grand Slam
10 开火车Diver Train
11 仙女散花Fairy Flower
12 天龙八部Dragon Oath
13 九天捞月Nine Treasure
表1 事件说明表
Table 1 :Description of the lottery event
水果类型Fruit Type
1 苹果Apple
2 橘子Orange
3 小橘子Small Orange
4 柠檬Lemon
5 小柠檬Small Lemon
6 铃铛Bell
7 小铃铛Small Bell
8 西瓜Watermelon
9 小西瓜Small Watermelon
10 星星Star
11 小星星Small Stars
108
12 77
13 小77 Small 77
14 BAR
15 小BAR Small BAR
16 左LUCKY Left LUCKY
17 右LUCKY Right LUCKY
表2 水果类型表
Table 2 :Fruit type table
前端开奖点Front Lottery Points
1 小铃铛Small Bell
2 橘子Orange
3 铃铛Bell
4 小BAR Small BAR
5 大满贯 Grand Slam
6 BAR
7 苹果Apple
8 柠檬Lemon
9 西瓜Watermelon
10 小西瓜Small Watermelon
11 右LUCKY Right LUCKY
12 苹果Apple
13 小橘子Small Orange
14 橘子Orange
15 铃铛Bell
16 小77 Small 77
17 77
18 苹果Apple
19 小柠檬Small Lemon
20 柠檬Lemon
21 星星Star
22 小星星Small Stars
23 左LUCKY Left LUCKY
109
24 苹果Apple
表3 前端开奖点表
Table 3:Front Lottery Points
4.4.34 幸运夺宝Lucky Treasure
如：值为60013_123456,80000123,500
For example: the value is 60013_123456,80000123,500
● 60013_123456为获奖用户，80000123为中奖号码，500为500游戏币场次
60013_123456 represents the Winner, 80000123 represents the reward number, and 500 represents
sessions of 500 Game Currency.
4.4.35 鱼虾蟹Fish-Prawn-Crab Dice
如：值为223070809293100
Example: Value as 223070809293100
● 第1位代表第一个骰子的点数
The first byte represents the number of the first dice
● 第2位代表第二个骰子的点数
The second byte represents the number of the second dice
● 第3位代表第三个骰子的点数
The third byte represents the number of the third dice
● 第4、5位代表三个骰子之和
The fourth and fifth bytes represent the sum of the three dice
● 第6、7位代表大、小或者任意豹子（07为大， 08为小，41为任意豹子）
The sixth and seven bytes represent big, small or any leopard (07, 08, and 41 each represents big,
small, and any leopard respectively.)
● 第8、9位代表单、双或者豹子（09为单，10为双，35 36 37 38 39 40为豹子）
The eighth and ninth bytes represent single, double or leopard (09 and 10 are single and double
respectively, whereas 35, 36, 37, 38, 39, and 40 are leopards.)
● 第10到第15位代表开奖点的颜色
The tenth to fifteenth bytes represent the colors of the prize opening.
图案与点数及颜色对应关系如下表：
The correlations between the pictures, numbers, and colors are as below:
图案Picture 点数Number 颜色Color
鱼Fish 1点 红Red
虾Prawn 2点 绿Green
葫芦Gourd 3点 蓝Blue
铜钱Coin 4点 蓝Blue
蟹Crab 5点 绿Green
公鸡Cock 6点 红Red
开奖点与字符对应关系如下表：
110
The correlations between Prize Opening Point and Character are as below:
开奖点Prize Opening Point 字符Character
鱼Fish 1
虾Prawn 2
葫芦Gourd 3
铜钱Coin 4
蟹Crab 5
公鸡Cock 6
大Big 7
小Small 8
单Single 9
双Double 10
4 11
5 12
6 13
7 14
8 15
9 16
10 17
11 18
12 19
13 20
14 21
15 22
16 23
17 24
单红Single Red 25
双红Double Reds 26
三红Triple Reds 27
单绿Single Green 28
双绿Double Greens 29
三绿Triple Greens 30
单蓝Single Blue 31
111
双蓝Double Blues 32
三蓝Triple Blues 33
任意三色Any Triple Colors 34
三鱼Triple Fish 35
三虾Triple Prawns 36
三葫芦Triple Gourds 37
三铜钱Triple Coins 38
三蟹Triple Crabs 39
三公鸡Triple Cocks 40
任意豹子Any Leopard 41
● 举例说明：
当值为223070809293100时，开骰结果对应为2 2 3，点数之和7点，08小09单，开奖颜色为双绿 单
蓝
Example Description：
From the set of values 2307080929310, the outcome of the dice rolled is 2 2 3, which totaled up to 7.
Meanwhile, 08 is small, 09 is single, and the colors for prize opening are double Greens and a single
Blue.
4.4.36 跑得快Run Fast
如：值为
011121331827062435293a3b0d2d3d1d1b2b2a03230a2c0c3c1c17370715052532362628380b34041314160
81a390919
Example: Value as
011121331827062435293a3b0d2d3d1d1b2b2a03230a2c0c3c1c17370715052532362628380b34041314160
81a390919
● 将长度为（ 3x32 = ）96的 牌值原始序列均分成三组
Split the 96-long (3x32) card values into three groups according to the original order.
● 如 011121331827062435293a3b0d2d3d1d为01 11 21 33 18 27 06 24 35 29 3a 3b 0d 2d 3d 1d
Example 011121331827062435293a3b0d2d3d1d would be 01 11 21 33 18 27 06 24 35 29 3a 3b 0d 2d
3d 1d
● 如 1b2b2a03230a2c0c3c1c173707150525为1b 2b 2a 03 23 0a 2c 0c 3c 1c 17 37 07 15 05 25
Example 1b2b2a03230a2c0c3c1c173707150525 would be1b 2b 2a 03 23 0a 2c 0c 3c 1c 17 37 07 15 05
25
● 如 32362628380b3404131416081a390919为32 36 26 28 38 0b 34 04 13 14 16 08 1a 39 09 19
Example 32362628380b3404131416081a390919 would be32 36 26 28 38 0b 34 04 13 14 16 08 1a 39
09 19
● 每个扑克牌数字由高字节的花色和低字节的牌值构成：
● 对于高字节： 0 -->♦; 1 -->♣; 2 -->♥; 3 -->♠
● 对于低字节： 为该牌值的十六进制表示， 如 2 -->2; b -->11; d -->13;
112
Each card’s digit is composed of a high byte for suit, and a low byte for rank:
For high bytes: 0 -->♦; 1 -->♣; 2 -->♥; 3 -->♠
For low bytes: Represented by the hexadecimal value of the card, such as 2 -->2; b -->11; d -->13;
● 如 2a -->♥10
Example 2a -->♥10
● 如 ：
Example ：
字符Characters 牌值Card Value 字符Characters 牌值Card Value
01 ♦A 35 ♠5
11 ♣A 29 ♥9
21 ♥A 3a ♠10
33 ♠3 3b ♠J
18 ♣8 0d ♦K
27 ♥7 2d ♥K
06 ♦6 3d ♠K
24 ♥4 1d ♣K
例如: 值为
Example: Value as
011121331827062435293a3b0d2d3d1d1b2b2a03230a2c0c3c1c17370715052532362628380b34041314160
81a390919
● 三个玩家手牌情况将是：
The hands of three players are as such:
● 1号位玩家手牌: ♦A ♣A ♥A ♠3 ♣8 ♥7 ♦6 ♥4 ♠5 ♥9 ♠T ♠J ♦K ♥K ♠K ♣K
● 2号位玩家手牌: ♣J ♥J ♥T ♦3 ♥3 ♦T ♥Q ♦Q ♠Q ♣Q ♣7 ♠7 ♦7 ♣5 ♦5 ♥5
● 3号位玩家手牌: ♠2 ♠6 ♥6 ♥8 ♠8 ♦J ♠4 ♦4 ♣3 ♣4 ♣6 ♦8 ♣T ♠9 ♦9 ♣9
Player No.1’s hand: ♦A ♣A ♥A ♠3 ♣8 ♥7 ♦6 ♥4 ♠5 ♥9 ♠T ♠J ♦K ♥K ♠K ♣K
Player No.2’s hand: ♣J ♥J ♥T ♦3 ♥3 ♦T ♥Q ♦Q ♠Q ♣Q ♣7 ♠7 ♦7 ♣5 ♦5 ♥5
Player No3’s hand: ♠2 ♠6 ♥6 ♥8 ♠8 ♦J ♠4 ♦4 ♣3 ♣4 ♣6 ♦8 ♣T ♠9 ♦9 ♣9
● 拥有♠3的玩家即是首先出牌者，所以是1号位玩家先出牌。
The player with ♠3 will play their cards first. Therefore, Player No.1 will be the first to play their cards.
4.4.37 红黑大战Red & Black War
如：值为032601113d1d23
Example: Value is 032601113d1d23
● 第一位是花色，第二位数是牌值，以此类推，一~六号位组合形成红区的开牌
The first byte is Suit, the second byte is CardValue, the first 6 bytes combined to form the opening of
Red area
● 第七位是花色，第八位数是牌值，以此类推，七~十二号位组合形成黑区的开牌
The 7th byte is Suit, the 8th byte is CardValue, from the NO.7 to No.12 bytes combined to form the
opening of Black area
113
● 第十三、十四位为开奖结果，若无幸运一击则十四位为空，1代表红赢，2代表黑赢,13代表红赢且
幸运一击，以此类推
The 13th and 14th place are the draw results. If the lucky-hit event not happened, the 14th place is
empty. 1 means red area wins and 2 means black area wins. 13 means red area wins and lucky-hit
event happened.
● 字符与花色对应关系、字符与牌值对应关系同炸金花
It is the same with Golden Flower of the corresponding relationship between Character and Suit,
Character and CardValue
● 字符与开奖点对应关系如下表：
The corresponding relationship between character and openning point are as follows：
字符character 开奖点Opening points
1 红Red Area
2 黑Black Area
3 幸运一击Lucky Hit
● 例：
值为：032601113d1d23表示：红开牌♦3♥6♦1，黑开牌♣1♠K♣K，本局黑赢获胜,且开出幸运一击
Example:
Value is: 032601113d1d23 represent: Red area open ♦3♥6♦1, Black area open ♣1♠K♣K, this round
Black area wins and event of lucky-hit happened.
4.4.38 疯狂抢庄牛牛Crazy Banker Bull-Bull
● 解析规则同抢庄牛牛
Same as Banker Bull-Bull
● 总共六个座位
There are 6 seats total in this game
4.4.39 李逵捕鱼LK Fishing
● 李逵捕鱼不需要解析CardValue。
LK fishing doesn’t need analysis card value.
● 查看对局详情即可。
There are 6 seats total in this game
4.4.40 金元捕鱼ChinYuan Fishing
● 金元捕鱼不需要解析CardValue。
Chin Yuan fishing doesn’t need analysis card value.
● 查看对局详情即可。
You can check the game details.
4.4.41 捕鱼传说BYCS Fishing
● 捕鱼传说不需要解析CardValue。
BYCS fishing doesn’t need analysis card value.
● 查看对局详情即可。
You can check the game details.
114
4.4.42 极速百家乐Speed Baccarat
如：值为2a23332a1c041
Example: Value is 2a23332a1c041
● 前6位是闲，7-12位是庄，12位以后是胜利的下注点ID
the first 6 bytes are Player，7-12 bytes are banker, bytes after 12 are betting point ID of success
● 前12位，第一位是花色，第二位是牌值，第三位是花色，第四位是牌值，以此类推
The first 12 bytes，the first byte is suit，second is CardValu，the third is suit, the forth is CardValue,
and so on.
● 庄闲各最少两张牌最多三张牌，如果第三张牌没发，对应牌值为00
2 cards for the least 3 cards for the most for both Player and Banker, if the third cards does not
distributed, corresponding card value is 00
● 字符与花色对应关系、字符与牌值对应关系同德州扑克
It is the same with Texas Hold'em Poker of the corresponding relationship between Character and Suit,
Character and CardValue
● 下注点与字符对应关系如下表：
The corresponding relationship between the betting point and character as follow ：
字符Character 下注点Betting point
庄Banker 2
闲Player 1
和Tie 3
幸运七Lucky 7 10
任意对子Any Pair 11
大Big 8
小Small 9
● 则此局闲牌♥10♥3 ♠3，庄牌♥10♣Q♦4；胜利下注点为1，对应闲赢
Then the Player cards of this match♥10♥3 ♠3，Banker cards♥10♣Q♦4； the betting point of success is 1
4.4.43 看牌抢庄三公Three-Face Card After Check Card
如：值为161c1c000000262c2c000000363c3c5
Example: Value is 161c1c000000262c2c000000363c3c5
● 字段规则第一位是花色，第二位数是牌值，第三位是花色，第四位数是牌值，以此类推
Field rule: the first byte is Suit, the second is CardValue, the third it Suit, the forth is CardValue, and so
on
● 每个玩家3张手牌共占6位，依次为1-5号座位的玩家
3 handcards per player occupy 6 bytes, and the seat number from 1 to 5 in sequence
● 最后面一位表示庄家的座位号,1-5分别对应1-5号位
The last byte represent the Banker’s seat number, 1-5 respectively corresponding to seat NO.1-5
● 字符与花色对应关系、字符与牌值对应关系同德州扑克
It is the same with Texas Hold'em Poker of the corresponding relationship between Character and Suit,
115
Character and CardValue
● 例：值为：161c1d000000262c2d000000363c3d5表示：1号位玩家手牌♣6♣Q♣K；2号位没有玩家；3号
位玩家手牌♥6♥Q♥K；4号位没有玩家；5号位玩家手牌♠6♠Q♠K；5号位的玩家是庄家
Example: 161c1d000000262c2d000000363c3d5 represent: seat NO.1 player hands ♣6♣Q♣K; seat
NO.2 no player; seat NO.3 player hands ♥6♥Q♥K; seat NO.4 no player; seat NO.5 player hands
♠6♠Q♠K; the player of seat No.5 is the Banker
4.4.44 梭哈德州扑克All-In or Fold
如：值为2302163a3306242b1a0a353b2a0b3c0121
Example: Value is 2302163a3306242b1a0a353b2a0b3c0121
● 字段规则第一位是花色，第二位数是牌值，第三位是花色，第四位数是牌值，以此类推
Field rule: the first byte is Suit, the second is CardValue, the third it Suit, the forth is CardValue, and so
on
● 每个玩家2张手牌共占6位，依次为1-6号座位的玩家, 共占24位,若座位为空则显示0000
2 handcards per player occupy 4 bytes, and the seat number from 1 to 6 in sequence. So all players
occupy 24 bytes. 0000 stands for empty seat.
● 第25-30位代表翻牌, 31位32位代表转牌,33位34位代表河牌
The 25th to 30th bytes are Flop cards, the 31st to 32nd bytes are Turn card, and the 33rd to 34th bytes
are River card.
● 字符与花色对应关系、字符与牌值对应关系同德州扑克
It is the same with Texas Hold'em Poker of the corresponding relationship between Character and Suit,
Character and CardValue
● 如：值为2302163a3306242b1a0a353b2a0b3c0121表示: 1号玩家手牌♥3♦2, 2号手牌♣6♠10, 3号手
牌♠3♣6, 4号手牌♥4♥J, 5号手牌♣10♦10, 6号手牌♠5♠Q, 翻牌为♥10♦J♠Q, 转牌为♦A, 河牌为♥A
Example: 2302163a3306242b1a0a353b2a0b3c0121 represent: seat NO.1 player hands ♥3♦2; seat
NO.2 hands ♣6♠10; seat NO.3 player hands ♠3♣6; seat NO.4 hands ♥4♥J; seat NO.5 player hands
♣10♦10; seat NO.6 hands ♠5♠Q; the flop cards are ♥10♦J♠Q, the turn card is ♦A, and the river card is
♥A
4.4.45 金球银球World Cup Golden Ball
如：值为02100
For example, the value is 02100
● 字段前两位是中奖的下注点序号。01：红手套 02：红哨子 03：红鞋 04：红衣 05：蓝手套 06：蓝哨
子 07：蓝鞋 08：蓝衣 09：银球 10：金球。
● 后二到三位是赔率，100表示赔率是100倍。
The first two digits of the field are the number of the annotation points for winning the prize. 01: Red
Gloves 02: Red Whistle 03: Red Shoes 04: Red Clothes 05: Blue Gloves 06: Blue Whistle 07: Blue Shoes
08: Blue Clothes 09: Silver Ball 10: Gold Ball. The last two to three digits are odds, 100 means the odds
are 100 times.
● 那么以上例子的开奖结果为：红哨子100倍
So, the prize-winning result of the above example is: Red Whistle 100 times
116
4.4.46 十倍牛牛Ten Times Bull-Bull
● 1-5分别代表天地玄黄庄位置
1-5 represent respectively Sky ,Floor, Xuan and Yellow banker’s seat
● 如：值为12a3a09181522528273d3431b2b1a0706435083739125110d140322020304
example：value is 12a3a09181522528273d3431b2b1a0706435083739125110d140322020304
● Ø 字段规则第一位数是位置 第二位数是花色，第三位数是牌值，第四位是花色，第五位数是牌
值，以此类推
the first byte is seat, the second is Suit, the third it CardValue, the forth is Suit, the fifth is CardValue
and so on.
● 每个位置5张手牌共占11位，依次为天地玄黄庄。后面数字代表赢的位置，每个位置占两个字符
Ø 字符与花色对应关系、字符与牌值对应关系同德州扑克
handcards per seat occupy 11 bytes, and the seats are Sky ,Floor, Xuan and Yellow in sequence.The
numbers followed represent the seat of the winner, each occupy 2 bytes.It is the same with Texas
Hold'em Poker of the corresponding relationship between Character and Suit, Character and
CardValue
● 例如值为：12a3a09181522528273d3431b2b1a0706435083739125110d140322020304表示
天号位手牌为: ♥10♠10♦9♣8♣5
地号位手牌为: ♥5♥8♥7♠K♠4
玄号位手牌为: ♣J♥J♣10♦7♦6
黄号位手牌为: ♠5♦8♠7♠9♣2
庄家手牌为： ♣A♦K♣4♦3♥2
020304表示地 玄 黄三个位置赢了
example：value is 12a3a09181522528273d3431b2b1a0706435083739125110d140322020304
reprexent：
handcards of Sky seat is: ♥10♠10♦9♣8♣5
handcards of Floor seat is: ♥5♥8♥7♠K♠4
handcards of Xuan seat is: ♣J♥J♣10♦7♦6
handcards of Yellow seat is: ♠5♦8♠7♠9♣2
handcards of Dealer is: ♣A♦K♣4♦3♥2
020304 represent Floor, Xuan, Yellow these 3 seats wined
4.4.47 富贵金龙Golden Dragon
● 富贵金龙不需要解析CardValue。
Golden Dragon doesn’t need analysis card value.
● 查看对局详情即可。
You can check the game details.
4.4.48 欧式轮盘European Roulette
如：值为119
Example: Value is 119
● 字段第一位是颜色0：绿 1：红 2：黑，第二位后面为数字。
The first byte is Color, 0: Green 1:Red 2:Black, bytes after second are numbers.
● 那么以上例子的开奖结果为：红19。
the prize-winning result of the above example is: Red 19
117
4.4.49 富贵三张Three Card Poker
如：值为171c3b063426000000041b150
For example: the value is 171c3b063426000000041b150
● 字段规则第一位是花色，第二位数是牌值，第三位是花色，第四位数是牌值，以此类推
the first is the suit, the second is the card value, the third is the suit, the fourth is the card value, and
so on
● 每个玩家3张手牌共占6位，依次为1-3号座位的玩家
Each player has 3 cards accounting for 10, which are the players in seats 1-5
● 第一个字段一律为庄家牌其余为玩家手牌
1st~6th means banker
● 最后一个数字0无意义
Last char " 0 " , meaningless, please ignore
● 当位子为空时则为"000000"
When the seat is empty that is "000000"
● 黑桃、红桃、梅花和方片编号为3、2、1、0
Spades, hearts, clubs and diamonds are numbered 3, 2, 1, 0
● 值为：171c3b063426000000041b150 表示：1号位玩家手牌♦6 ♠4 ♥6 ；3号位玩家手牌♦4 ♣J ♣5 ；庄
家位是♣7 ♣Q ♠J
For example: the value is 171c3b063426000000041b150: The first player’s cards: 7st~12th represent
the first player’s cards are:♦6 ♠4 ♥6，The third player’s cards: 19th~24th represent the second player’s
cards are: ♦4 ♣J ♣5，The banker’s cards: 1th~6th represent the banker’s cards are: ♣7 ♣Q ♠J
4.4.50 官人坏坏百J乐H-Baccarat
如：值为33340033340003
Example: Value is 33340033340003
● 前6位是闲，7-12位是庄，12位以后是胜利的下注点ID
The first 6 bytes are Player，7-12 bytes are banker, bytes after 12 are betting point ID of success
● 前12位，第一位是花色，第二位是牌值，第三位是花色，第四位是牌值，以此类推
The first 12 bytes，the first byte is suit，second is CardValue，the third is suit, the forth is CardValue,
and so on
● 庄闲各最少两张牌最多三张牌，如果第三张牌没发，对应牌值为00
2 cards for the least 3 cards for the most for both Player and Banker, if the third cards does not
distributed, corresponding card value is 00
● 字符与花色对应关系、字符与牌值对应关系同德州扑克
It is the same with Texas Hold'em Poker of the corresponding relationship between Character and Suit,
Character and CardValue
● 下注点与字符对应关系如下表：
The corresponding relationship between the betting point and character as follow ：
字符Character
下注点Betting
point
庄Banker 2
118
闲Player 1
和Tie 3
则此局闲家牌值 ♠3♠4 ,庄家牌值 ♠3♠4；胜利下注点为3，对应和赢
Then the Player cards of this match♠3♠4，Banker cards♠3♠4； the betting point of success is 3
4.4.51 闪电21点Lightning Blackjack
如：值为02d1317,13d062a,2032703,323253d-333b
Example: Value is 02d1317,13d062a,2032703,323253d-333b
● 每个逗号内或者竖线内第一位表示玩家座位号，后面每两位表示一张扑克花色和点数。
within each comma or slash, the first byte represent the player’s seat number, and every two behind
represent Suit and Point
● -连接符表示玩家在该座位上进行了分牌，后面每两位表示一张扑克花色和点数。
-dash represent the player distributed cards on this seat，every 2 bytes behind represent suit and
point for 1 card.
● 第一位是0时表示庄家
When the first byte is 0 represent Banker
● 字符与花色对应关系、字符与牌值对应关系同德州扑克
It is the same with Texas Hold'em Poker of the corresponding relationship between Character and Suit,
Character and CardValue
● 例：值为：02d1317,13d062a,2032703,323253d-233b 表示：庄家牌♥K♣3♣7，一号位牌♠K♦6♥10，二
号位牌♦3♥7♦3，三号位进行了分牌：第一墩的牌♥3♥5♠K，第二墩的牌♥3♠J
Example:
Value is：02d1317,13d062a,2032703,323253d-233b|41c29|5393b represent: Banker hands♥K♣3♣7，
seat No.1 hands♠K♦6♥10，seat No.2 hands♦3♥7♦3，seat No.3 distributed cards：the first set of
cards♥3♥5♠K，the second set of cards♥3♠11
4.4.52 终极德州扑克Ultimate Texas
如：值为000005212709232d353c38332c0
For example: the value is 000005212709232d353c38332c0
● 字段规则第一位是花色，第二位数是牌值，第三位是花色，第四位数是牌值，以此类推
the first is the suit, the second is the card value, the third is the suit, the fourth is the card value, and
so on
● 每个玩家2张手牌共占4位，依次为1-3号座位的玩家, 共占12位，若座位为空则显示0000
2 handcards per player occupy 4 bytes, and the seat number from 1 to 3 in sequence. So all players
occupy 12 bytes. 0000 stands for empty seat.
● 第13-16位为庄家手牌
13th-16th means banker’s handcards
● 第17-26位是公共牌
17th-26th are public cards.
● 最后一个数字0无意义
Last char " 0 " , meaningless, please ignore
● 黑桃、红桃、梅花和方片编号为3、2、1、0
119
Spades, hearts, clubs and diamonds are numbered 3, 2, 1, 0
● 值为：000005212709232d353c38332c0表示：1号位玩家为空；2号位玩家手牌♦5 ♥A；3号位玩家手
牌♥7 ♦9；庄家手牌♥3 ♥K；公共牌♠5 ♠Q ♠8 ♠3 ♥Q
For example: the value is 171c3b063426000000041b150: The first player is empty, the second player’s
cards are: ♦5 ♥A, the third player’s cards are: ♥7 ♦9, the banker’s cards are: ♥3 ♥K, public cards are ♠5
♠Q ♠8 ♠3 ♥Q.
4.4.53 炸财神Bombing Fortune
● 炸财神不需要解析CardValue。
Bombing Fortune doesn’t need analysis card value.
● 查看对局详情即可。
You can check the game details.
4.4.54 幸运熊猫Lucky Panda
● 幸运熊猫不需要解析CardValue。
Lucky Panda doesn’t need analysis card value.
● 查看对局详情即可。
You can check the game details.
4.4.55 财神发发发Fortune FaFaFa
● 财神发发发不需要解析CardValue。
Fortune FaFaFa doesn’t need analysis card value.
● 查看对局详情即可。
You can check the game details.
4.4.56 麻将胡了3 Mahjong Master
● 麻将胡了3不需要解析CardValue。
Mahjong Master doesn’t need analysis card value.
● 查看对局详情即可。
You can check the game details.
4.4.57 抖音牛牛TikTok Bull-BullGuandan
如：值为360c2c14180000000000360c2c141800000000001
Example: Value is 360c2c14180000000000360c2c141800000000001
● 字段规则第一位是花色，第二位数是牌值，第三位是花色，第四位数是牌值，以此类推
Field rule: the fist byte is Suit, the second is Value, the third is Suit, the forth is Value, and so on.
● 每个玩家5张手牌共占10位，依次为1-4号座位的玩家
5 handcards per player occupy 10 bytes, and the seat number from 1 to 4 in sequence.
● 最后面一位表示庄家的座位号,1-4分别对应1-4号位
The last byte represent the Banker’s seat number, the No.1 to No.4 byte respectively corresponding to
seat NO.1-4
● 字符与花色对应关系、字符与牌值对应关系同德州扑克
It is the same with Texas Hold'em Poker of the corresponding relationship between Character and Suit,
Character and CardValue
120
● 例Example：
值为：360c2c14180000000000360c2c141800000000001表示：1号位玩家手牌♠6♦Q♥ Q♣4♣8；2号位
没有玩家；3号位玩家手牌♠6♦Q♥Q♣4♣8；4号位没有玩家；庄家是1号位的玩家
Value is: 360c2c14180000000000360c2c141800000000001 represent: seat NO.1 player hands ♠6♦Q♥
Q♣4♣8, seat NO.2 no player; seat NO.3 player hands ♠6♦Q♥Q♣4♣8; seat NO.4 no player; seat No.1 is
Banker
4.4.58 掼蛋Guandan
如：值为
080d2d042b26153418281c2a0d0c3d391b2437111c123717212428070b35113d09012316193c141d421a26
083b18130a321925293525380b290c033117010903433b331b1523221a3a0227362704123c05342b061d39
4222060a21320213332d2a162c073a36433805142c31
Example: Value is
080d2d042b26153418281c2a0d0c3d391b2437111c123717212428070b35113d09012316193c141d421a26
083b18130a321925293525380b290c033117010903433b331b1523221a3a0227362704123c05342b061d39
4222060a21320213332d2a162c073a36433805142c31
● 字段规则第一位是花色，第二位数是牌值，第三位是花色，第四位数是牌值，以此类推
Field rule: the fist byte is Suit, the second is Value, the third is Suit, the forth is Value, and so on.
● 每个玩家27张手牌共占10位，依次为1-4号座位的玩家
27 handcards per player occupy 10 bytes, and the seat number from 1 to 4 in sequence.
● 最后面一位表示庄家的座位号,1-4分别对应1-4号位
The last byte represent the Banker’s seat number, the No.1 to No.4 byte respectively corresponding to
seat NO.1-4
● 字符与花色对应关系、字符与牌值对应关系同德州扑克
It is the same with Texas Hold'em Poker of the corresponding relationship between Character and Suit,
Character and CardValue
● 例Example：
值为：
080d2d042b26153418281c2a0d0c3d391b2437111c123717212428070b35113d09012316193c141d42
1a26083b18130a321925293525380b290c033117010903433b331b1523221a3a0227362704123c0534
2b061d394222060a21320213332d2a162c073a36433805142c31表示：1号位玩家手牌
♣A♥A♠K♦K♥K♦K♣Q♣Q♦Q♥J♣J♥10♠9♦8♥8♣8♥8♠7♠7♣7♥6♣5♦4♥4♥4♠4♣2；2号位玩家手牌小王
♣3♥3♦A♣A♣K♠K♠Q♠J♦J♦10♣10♥9♣9♦9♣9♦8♣8♦7♣6♥6♥5♠5♠5♥5♣4♠2；3号位玩家手牌大王
♦3♠3♦3♥3♠A♦A♠Q♦Q♣J♦J♠J♣10♠10♦9♥9♠8♥7♥7♣7♠6♣5♦5♦4♥2♣2♦2；4号位玩家手牌
♣3♠3♥A♠A♥K♣K♥Q♥Q♥J♦10♥10♠10♠9♠8♦7♣6♠6♦6♦6♦5♣4♠4♠2♦2♥2
Value is:
080d2d042b26153418281c2a0d0c3d391b2437111c123717212428070b35113d09012316193c141d42
1a26083b18130a321925293525380b290c03311
7010903433b331b1523221a3a0227362704123c05342b061d394222060a21320213332d2a162c073a3
6433805142c31 means: Position 1 player’s hand ♣A♥A♠K♦K♥K♦K♣
Q♣Q♦Q♥J♣J♥10♠9♦8♥8♣8♥8♠7♠7♣7♥ 6♣5♦4♥4♥4♠4♣2; The player in position 2 has the trump card
♣3♥3♦A♣A♣K♠K♠Q♠J♦J♦10♣10♥9♣9♦9 ♣9♦8♣8♦7♣6♥6♥5♠5♠5♥5♣4♠2; The player in position 3 has
the king of cards ♦3♠3♦3♥3♠A♦A♠Q♦Q♣J ♦J♠J♣10♠10♦9♥9♠8♥7♥7♣7♠6♣5♦5♦4♥2♣2♦2; Player No.
121
4’s hand is ♣3♠3♥A♠A♥ K♣K♥Q♥Q♥J♦10♥10♠10♠9♠8♦7♣6♠6♦6♦6♦5♣4♠4♠2♦2♥2
4.4.59 黑神话百人牛牛 Black Myth Niu-Niu For Thousands Person
● 1-5分别代表白龙 悟空 悟能 悟净 庄位置
1-5 represent respectively Sky ,Floor, Xuan and Yellow banker’s seat
● 如：值为12a3a09181522528273d3431b2b1a0706435083739125110d140322020304
example：value is 12a3a09181522528273d3431b2b1a0706435083739125110d140322020304
● Ø字段规则第一位数是位置 第二位数是花色，第三位数是牌值，第四位是花色，第五位数是牌
值，以此类推
the first byte is seat, the second is Suit, the third it CardValue, the forth is Suit, the fifth is CardValue
and so on.
● 每个位置5张手牌共占11位，依次为白龙 悟空 悟能 悟净庄。后面数字代表赢的位置，每个位置
占两个字符
● Ø字符与花色对应关系、字符与牌值对应关系同德州扑克
handcards per seat occupy 11 bytes, and the seats are Sky ,Floor, Xuan and Yellow in sequence.The
numbers followed represent the seat of the winner, each occupy 2 bytes.It is the same with Texas
Hold'em Poker of the corresponding relationship between Character and Suit, Character and
CardValue
● 例如值为：12a3a09181522528273d3431b2b1a0706435083739125110d140322020304表示
白龙号位手牌为: ♥10♠10♦9♣8♣5
悟空位手牌为: ♥5♥8♥7♠K♠4
悟净号位手牌为: ♣J♥J♣10♦7♦6
悟能位手牌为: ♠5♦8♠7♠9♣2
庄家手牌为： ♣A♦K♣4♦3♥2
020304表示悟空 悟净 悟能三个位置赢了
example：value is 12a3a09181522528273d3431b2b1a0706435083739125110d140322020304
reprexent：
handcards of Sky seat is: ♥10♠10♦9♣8♣5
handcards of Floor seat is: ♥5♥8♥7♠K♠4
handcards of Xuan seat is: ♣J♥J♣10♦7♦6
handcards of Yellow seat is: ♠5♦8♠7♠9♣2
handcards of Dealer is: ♣A♦K♣4♦3♥2
020304 represent Floor, Xuan, Yellow these 3 seats wined
4.4.60 逃离五指山 Escape from Wuzhishan
● 用;区隔数值：下注倍数;开讲倍数
Values seperated by semicolon: bet_times;reward_times
● 如：值为1.01;1.85
example：value is 1.01;1.85
4.4.61 西游黑悟空Monkey king black wukong
● 西游黑悟空不需要解析CardValue
Monkey king : black wukong doesn’t need analysis card value.
122
● 查看对局详情即可。
You can check the game details.
4.4.62 癞子牛牛Lai Zi Niu Niu
如：值为19393525044141431a071d2d4133082c22112841413b3d0c013641411
Example: Value is 19393525044141431a071d2d4133082c22112841413b3d0c013641411
● 字段规则第一位是花色，第二位数是牌值，第三位是花色，第四位数是牌值，以此类推
Field rule: the fist byte is Suit, the second is Value, the third is Suit, the forth is Value, and so on.
● 每 14 位为一组，依次表示 1-4 号位的 5 张手牌、1 张小王变化的牌、1 张大王变化的牌
Every 14 digits is a group, which successively represents the 5 pieces cards of 1 to 4 positions, 1
changing card of little joker and 1 changing card of king
● 最后面一位表示庄家的座位号,1-4分别对应1-4号位
The last byte represent the Banker’s seat number, the No.1 to No.4 byte respectively corresponding to
seat NO.1-4
● 字符与花色对应关系、字符与牌值对应关系同德州扑克（41 表示空）
It is the same with Texas Hold'em Poker of the corresponding relationship between Character and Suit,
Character and CardValue (41 for null)
● 例Example：
值为：19393525044141431a071d2d4133082c22112841413b3d0c013641411表示：
1 号位：♣9 ♠9 ♠5 ♥5 ♦4 空 空
2 号位：大王 ♣10 ♦7 ♣K ♥K 空 ♠3
3 号位：♦8 ♥Q ♥2 ♣A ♥8 空 空
4 号位：♠J ♠K ♦Q ♦A ♠6 空 空
1 号位是庄家
For example:value is 19393525044141431a071d2d4133082c22112841413b3d0c013641411.
The first position：♣9 ♠9 ♠5 ♥5 ♦4 null null
The second position: king ♣10 ♦7 ♣K ♥K null ♠3
The third position: ♦8 ♥Q ♥2 ♣A ♥8 null null
The fourth position: ♦8 ♥Q ♥2 ♣A ♥8 null null.
The banker is in the first position.
4.4.63 比大小 HI-LO
● 用; 区隔动作：第一位是动作, 后面是卡片编号
Values seperated by semicolon: action;card number
动作action:
0: 起始牌 first card
1: 猜>= guess big
2: 猜<= guess small
3: 猜黑 guess black
4: 猜红 guess red
5: 换牌 change card
● 如：值为13;522;56
example：value is 13;522;56
123
4.4.64 土耳其麻将 Okey
● 以逗号分隔, 前4组对应1~4号玩家最终手牌, 每张牌以两位数表示, 如: 2 -> 02 or 14 -> 14, 牌值
可参考牌值定义, 第5组为庄家座位号, 第6组为公牌
Separated by commas, the first 4 groups correspond to the final hand of players 1 to 4, each card is
represented by a two-digit number, such as: 2 -> 02 or 14 -> 14, the card value can refer to the card
value definition, the 5th group is the dealer's seat number, and the 6th group is the public card
● 牌值定义如下:
红色1~13 1~13
黑色1~13 14~26蓝色1~13 27~39
黄色1~13 40~52
百搭牌 53
The card values are defined as follows:
Red 1~13 1~13
Black 1~13 14~26 Blue 1~13 27~39
Yellow 1~13 40~52
Wild Card 53
● 如：值为
020607081618192022303233343435404042464747,02050507081115181921272831324141424444
4549,0304041415,14,4,2
1号玩家最终手牌: 020607081618192022303233343435404042464747
2号玩家最终手牌: 020505070811151819212728313241414244444549
3号玩家最终手牌: 0304041415
4号玩家最终手牌: 14
庄家座位号: 4
公牌: 2
example：value is
020607081618192022303233343435404042464747,020505070811151819212728313241414244444
549,0304041415,14,4,2
Player 1's final hand: 020607081618192022303233343435404042464747
Player 2's final hand: 020505070811151819212728313241414244444549
Player 3's final hand: 0304041415
Player 4's final hand: 14
Dealer seat number: 4
Public Card:: 2
4.4.65 极速牛牛 Speed Bull-Bulll
● 不区隔直接串接，两码为一张卡牌，按座位号依序组合，如该座位没人则补十个0，最后一码为
庄家座位号
Values are concatenated directly with two digits representing one card, assembled in order of seat
number. If a seat is unoccupied, ten zeros are added to indicate an empty position, with the last digit
being the banker's seat number.
● 如：值为00000000000226123823000000000031191b1c15070518012b361d17032d4
124
表示牌局为..
1-无
2-
3-无人
4-
5-
6-
庄家牌:
example：value is 00000000000226123823000000000031191b1c15070518012b361d17032d4
means the result is..
1- empty
2-
3- empty
4-
5-
6-
Banks’s hand:
4.4.66 澳门百家乐幸运六 Macau Baccarat Lucky Six
● 不区隔直接串接，两码为一张卡牌，先闲后庄，如没有第三张牌则补两个0示之，最尾端为获胜
点位Values will be concatenated directly in the order of the player’s hands, followed by banker’s hand.
Two digits represent a card and will contain two extra zeros if there is no third card in that hand. And
the rest number represent the winning bet positions.
● 如：值为193a00133a0001
表示 闲- 庄example：value is 193a00133a0001
means Player- Banker4.4.67 铸剑 Forging a sword
● 第一位代表炼化成功/失败 0/1 , 后两位代表炼化到的等级 00 ~ 10
The first digit represents the success/failure of refining 0/1, and the last two digits represent the level
of refining 00 ~ 10
● 如：值为005
表示炼化失败，最高等级+5
如：值为108
表示炼化成功，最高等级+8
125
For example: the value is 005,
which means the refining failed, and the highest level is +5.
For example: the value is 108,
which means the refining is successful, and the highest level is +8.
4.4.68 射门之王 Soccer King
● 数字为赢分设定倍率
The digit represents the winning odds.
● 如：值为0
表示射门失败，游戏解析显示为 0x
如：值为3
表示射门成功，游戏解析显示为 3x
For example: the value is 0,
which means shooting failed, and the result will be 0x.
For example: the value is 3,
which means shooting succeeded, and the result will be 3x.
4.5游戏币兑换比例 Game Currency Exchange Ratio
编号 No 币种Currency 兑换比例 Exchange Ratio
1 人民币（RMB）
Ren min bi
1人民币=1.0000游戏币
1 RMB =1.0000 game currency
2 美元（USD）
United States dollar
1 美元=6 游戏币
1 USD =6.0000 game currency
3 马币（MYR）
Malaysian ringgit
1马币=1游戏币
1 MYR =1.0000 game currency
4 越南盾（VND）
Vietnamese dong
1越南盾=0.0003游戏币
1 VND =0.0003 game currency
5 泰铢（THB）
Thai baht
1泰铢=0.2游戏币
1 THB =0.2000 game currency
6 印度尼西亚盾(IDR)
Indonesian rupiah
1印度尼西亚盾=0.0005游戏币
1 IDR=0.0005 game currency
7 日元（JPY）
Japanese Yen
1日元=0.05游戏币
1 JPY =0.0500 game currency
8 澳元（AUD）
Australian Dollar
1澳元=5游戏币
1 AUD =5.0000 game currency
9 欧元（EUR）
Europe
1欧元=7游戏币
1 RMB =1.0000 game currency
10 英镑（GBP）
Great British Pound
1英镑=8游戏币
1 GBP =8.0000 game currency
11 印度卢比（INR）
Indian Rupee
1印度卢比=0.05游戏币
1 INR =0.050 game currency
126
12 韩元（KRW）
Korean Won
1韩元=0.005游戏币
1 KRW =0.0050 game currency
13 缅元（MMK）
Myanmar Kyat
1缅元=0.004游戏币
1 MMK =0.0040 game currency
14 新加坡元（SGD）
Singapore dollar
1新加坡元=5游戏币
1 SGD =5.0000 game currency
15 泰达币（USDT）
Tether
1泰达币=6游戏币
1 USDT =6.0000 game currency
16 里奥(BRL)
Brazilian Real
1里奥=1.3游戏币
1 BRL =1.3000 game currency
17 新台币（TWD）
New Taiwan dollar
1新台币=0.2游戏币
1 TWD =0.2000 game currency
18 菲律宾比绍（PHP）
Philippine peso
1菲律宾比绍=0.1游戏币
1 PHP =0.1000 game currency
19 文莱元（BND）
Brunei Dollar
1文莱元=4游戏币
1 BND =4.0000 game currency
20 瑞典克朗（SEK）
Swedish krona
1瑞典克朗=0.5游戏币
1 SEK =0.5000 game currency
21 南非兰特（ZAR）
South African rand
1南非兰特=0.5游戏币
1 ZAR =0.5000 game currency
22 瑞士法郎（CHF）
Swiss franc
1瑞士法郎=6游戏币
1 CHF =6.0000 game currency
23 津巴布韦元（ZWD）
Zimbabwean dollar
1津巴布韦元=0.01游戏币
1 ZWD =0.0100 game currency
24 罗威克朗（NOK）
Norwegian krone
1罗威克朗=0.5游戏币
1 RMB =1.0000 game currency
25 加拿大元（CAD）
Canadian dollar
1加拿大元=5游戏币
1 CAD =5.0000 game currency
26 新西兰元（NZD）
New Zealand dollar
1新西兰元=4游戏币
1 ZND =4.0000 game currency
4.6 运动类型 Sport Type
Sport Type Id Enum value Actual value that our API will return
1 Soccer 足球
2 IceHockey 冰球
3 Basketball 篮球
4 Rugby 橄榄球
5 Tennis 网球
127
6 American Football 美国足球
7 Baseball 棒球
8 Handball 手球
10 Floorball 地板球
12 Golf 高尔夫球
13 Volleyball 排球
14 Cricket 玩板球
15 TableTennis 乒乓球
16 Snooker 斯诺克台球
17 Futsal 五人制足球
18 MixedMartialArts 综合格斗
19 Boxing 拳击
20 Darts 飞镖
21 Bowls 草地滚球
24 WaterPolo 水球
25 Cycling 自行车
47 Badminton 羽毛球
51 BeachVolleyball 沙滩排球
92 Formula 1 F1赛车
93 Specials 特殊投注
94 Stock Car Racing 赛车
100 Olympic 奥林匹克
164 Dota2 刀塔2
165 LOL 英雄联盟
177 E-Football 电子足球
178 E-Basketball 电子篮球
180 KOG 王者荣耀
179 CS:GO 反恐精英
1001
Virtual Soccer(Support market type:
common) 虚拟足球 （支持玩法：普通）
1020
Virtual Horse(Support market type:
common) 虚拟赛马 （支持玩法：普通）
1021
Virtual Greyhounds(Support market
type: common) 虚拟赛狗 （支持玩法：普通）
128
1022
Virtual Speedway(Support market
type: common) 虚拟沙地摩托车 （支持玩法：普通）
1023
Virtual Motorbike(Support market
type: common) 虚拟摩托车 （支持玩法：普通）
4.7 体育注单状态 Sport Order status
4.7.1 订单状态 Order status
CODE DESC_EN DESC_CN
0 Created 未确认
1 Confirming 确认中
2 Rejected 已拒单
3 Canceled 已取消
4 Confirmed 已接单
5 Settled 已结算
4.7.2 结算结果 Outcome
CODE DESC_EN DESC_CN
0 NoResulted 无结果
2 Return 和
3 Lost 输
4 Won 赢
5 WinReturn 赢半
6 LooseReturn 输半
7 Cancel 取消
4.8 盘口 Market Type
CODE DESC_EN DESC_CN
1000 Soccer Handicap 足球让球
1002 Soccer European Handicap 足球欧盘让球
1005 Soccer 1X2 足球独赢（胜平负）
1006 Soccer Draw No Bet 足球平局退款
1007 Soccer Over/Under 足球亚盘大小球
1008 Soccer Total Goals Odd/Even 足球单双
1009 Soccer Corner 1x2 足球角球胜平负
1010 Soccer Corner Over/Under 足球角球大小球
1011 Soccer Conner Handicap 足球角球让球
129
1012 Soccer Double Chance 足球双重机会
1015 Soccer Corner Odd/Even 足球角球数单双
1016 Soccer Home No Bet 足球主胜退款
1017 Soccer Away No Bet 足球客胜退款
1018 Soccer Winning Margin 足球胜分差
1019 Soccer Last Goal 足球最后的进球
1021 Soccer Over/Under Home 足球主队大小球
1022 Soccer Over/Under Away 足球客队大小球
1025 Soccer Clean Sheet Home 足球主队零封对手
1026 Soccer Clean Sheet Away 足球客队零封对手
1027 Soccer Both Teams To Score 足球双方均有进球
1028 Soccer Which Team To Score 足球哪支球队进球
1030 Soccer 1x2 & Over/Under 足球胜平负和大小
1031 Soccer 1x2 & Xth Goal 足球独赢 & 第几个进球球
队
1032 Soccer 1x2 & Both Team To Score 足球胜平负和双方均有进球
1033 Soccer Half Time/Full Time 足球半场全场胜平负
1034 Soccer Both Halves Over X 足球上/下半场均大于x
1035 Soccer Both Halves Under X 足球上/下半场均小于x
1036 Soccer Home To Score In Both Halves 足球主队上/下半场均进球
1037 Soccer Away To Score In Both Halves 足球客队上/下半场均进球
1038 Soccer Home To Win Both Halves 足球主队赢得所有半场
1039 Soccer Home To Win Both Halves 足球主队赢得任一半场
1040 Soccer Away To Win Both Halves 足球客队赢得所有半场
1041 Soccer Away To Win Either Half 足球客队赢得任一半场
1042 Soccer The Highest Scoring Half 足球得分最高的半场
1043 Soccer The Highest Scoring Half Home 足球客队得分最高的半场
1044 Soccer The Highest Scoring Half Away 足球客队得分最高的半场
1046 Soccer To Qualify 足球晋级球队
1047
Soccer How Exactly Will The Match Be
Decided 足球比赛结束形式
1048 Soccer Will There Be Overtime 足球比赛会有加时
1049 Soccer Will There Be A Goal 足球比赛会进球
1050 Soccer Will There Be A Penalty Shootout 足球比赛会有点球大战
130
1051
Soccer When Will The 1st Goal Be Scored
(15 Min Interval)
足球第一个进球时间(15分
钟以内)
1054 Soccer Corner Race To X 足球最先达到x个角球球队
1055 Soccer Last Corner 足球最后的角球
1057 Soccer Corners Over/Under Home 足球主队角球数大小
1058 Soccer Corners Over/Under Away 足球客队角球数大小
1060 Soccer Booking Handicap 足球得牌让牌
1061 Soccer Booking 1x2 足球得牌胜平负
1063 Soccer Bookings Over/Under 足球罚牌大小
1065 Soccer Bookings Over/Under Home 足球主队罚牌大小
1066 Soccer Bookings Over/Under Away 足球客队罚牌大小
1067 Soccer Yellow Cards Handicap 足球黄牌让牌
1068 Soccer Yellow Cards Over/Under 足球黄牌大小
1069 Soccer Yellow Cards 1X2 足球黄牌胜平负
1070 Soccer Total Booking Points 足球罚牌时间
1072 Soccer Sending Off 足球是否有球员被罚下
1073 Soccer Player Sent Off Home 足球主队有球员罚下
1074 Soccer Player Sent Off Away 足球客队有球员罚下
1075 Soccer Xth Goalscorer 足球第几个进球的球员
1076 Soccer Anytime Goalscorer 足球任何时间进球的球员
1077 Soccer Last Goalscorer 足球最后一个进球的球员
1078 Soccer Double Chance & Over/Under 足球双重机会和大小
1079
Soccer Double Chance & Both Team To
Score
足球双重机会和双方均有
进球
1080 Soccer MultiScores 足球波胆多重选择
1082 Soccer Odd/Even Home 足球主队单双
1083 Soccer Odd/Even Away 足球客队单双
1086 Soccer Red Cards Handicap 足球红牌让牌
1087 Soccer Red Cards Over/Under 足球红牌大小
1088 Soccer Red Cards 1X2 足球红牌胜平负
1089 Soccer Xth Goal 足球第几个进球球队
1090 Soccer Which Team Wins The Rest 足球剩余时间获胜球队
1091 Soccer Home To Win 足球主队获胜
1092 Soccer Away To Win 足球客队获胜
131
1093 Soccer Any Team To Win 足球任意球队获胜
1094 Soccer Xth Corner 足球第x个角球
1097 Soccer 1st/2nd Half Both Teams To Score
足球上下半场双方是否进
球
1098 Soccer Penalty Shootout Winner 足球点球大战获胜球队
1099 Soccer Correct Score(Max 4-4)
足球足球波胆（任意球队进
球大于等于5判定选项”其他
“赢）
1100 Soccer Correct Score(Max 2-2)
足球波胆（任意球队进球大
于等于3判定选项”其他
“赢）
1101 Soccer Goal Range(7+) 足球进球范围（选项0-1， 2-3
，4-6，7+）
1102 Soccer Exact Goals(6+) 足球精确进球数（选项0，1，
2，3，4，5，6+）
1103 Soccer Exact Goals(3+) 足球精确进球数（选项0，1，
2，3+）
1104 Soccer Exact Goals(2+) 足球精确进球数（选项0，1，
2+）
1105 Soccer Exact Goals Home(3+) 足球主队精确进球数（选项0
，1，2，3+）
1106 Soccer Exact Goals Away(3+) 足球客队精确进球数（选项0
，1，2，3+）
1107 Soccer Corner Range(12+) 足球角球范围（选项 0-8，
9-11，12+）
1108 Soccer Corner Range(7+) 足球角球范围（选项 0-4，5-6
，7+）
1109 Soccer Corner Range Home(7+) 足球主队角球范围（选项0-2
，3-4，5-6，7+）
1110 Soccer Corner Range Away(7+) 足球客队角球范围（选项0-2
，3-4，5-6，7+）
1111 Soccer Correct Score(Max 9-9) 足球波胆（选项中任意球队
进球小于等于9）
1112 Exact Goals Home(4+) 足球主队精确进球数（选项0
，1，2，3，4+）
1113 Exact Goals Away(4+) 足球客队精确进球数（选项0
，1，2，3，4+）
1114 Soccer Winning Method 足球获胜方法
1115 Soccer Goals O/U& Both Teams To Score 足球大小&两队均进球
1116 Soccer Player To Score 足球球员是否进球
132
1118 Soccer Xth Scoring Type 足球进球方式
1119 Soccer Which Team Will Win The Final 足球获得冠军
1120
Soccer Which Team Will Win The 3rd
Place Final 足球获得季军
1123 Soccer Correct Score(PEN) 足球点球波胆
1124 Soccer Winner & Over/Under 足球获胜 & 大小
1125 Soccer Exact Goals (10+) 足球精确进球数（选项0-4，5
，6，7，8，9，10+）
1126 Soccer Bookign Odd/Even 足球得牌单双
1127 Soccer Which Team Kicks Off 足球哪队开球
1128 Xth Penalty Scored 足球第x个点球是否进球
1129 Winning Margin 3+(Pen) 足球点球阶段胜分差
1130 1st Penalty Scored Home
足球主队第一个点球是否
进球
1131 1st Penalty Scored Away
足球客队第一个点球是否
进球
1132 2nd Penalty Scored Home
足球主队第二个点球是否
进球
1133 2nd Penalty Scored Away
足球客队第二个点球是否
进球
1134 3rd Penalty Scored Home
足球主队第三个点球是否
进球
1135 3rd Penalty Scored Away
足球客队第三个点球是否
进球
1136 4th Penalty Scored Home
足球主队第四个点球是否
进球
1137 4th Penalty Scored Away
足球客队第四个点球是否
进球
1138 5th Penalty Scored Home
足球主队第五个点球是否
进球
1139 5th Penalty Scored Away
足球客队第五个点球是否
进球
1140 Round 1 足球点球第一回合胜平负
1141 Round 2 足球点球第二回合胜平负
1142 Round 3 足球点球第三回合胜平负
1143 Round 4 足球点球第四回合胜平负
1144 Round 5 足球点球第五回合胜平负
1145 Finishing Round 足球点球结束的回合
133
1146 1st Corner(Two Way) 足球第一个角球（两项）
1147 Last Corner(Two Way) 足球最后一个角球（两项）
1148 1st Booking(Two Way) 足球第一个得牌
1149 Last Booking(Two Way) 足球最后一个得牌
1150 1st Substitution 足球第一个换人
1151 Last Substitution 足球最后一个换人
1152 1st Goal Kick 足球第一个球门球
1153 Last Goal Kick 足球最后一个球门球
1154 1st Offside 足球第一个越位
1155 Last Offside 足球最后一个越位
1156 1st Throw In 足球第一个界外球
1157 Last Throw In 足球最后一个界外球
1158 1st Free Kick 足球第一个任意球
1159 Last Free Kick 足球最后一个任意球
1160 Corner Highest Scoring Half 足球角球最高得分半场
1161 Corner Highest Scoring Half(Two Way) 足球角球最高得分半场(两
项)
1162 Highest Scoring Half(Has Line) 足球最高得分半场让分
1163 Own Goal 足球是否有乌龙球
1164 First Penalty Awarded 足球常规时间是否判罚第一
个点球
1165 First Penalty To Score
足球常规时间判罚的第一个
点球是否打进
1166 To Win From Behind 足球哪队会反超获胜
1167 Home Win To Nil 足球主队零失球获胜
1168 Away Win To Nil 足球客队零失球获胜
1169 Xth Booking(3 Way) 足球第几个得牌
1170 Exact Bookings(12+) 足球精确得牌（12+）
1171 Home Exact Bookings(4+) 足球主队精确得牌（4+）
1172 Away Exact Bookings(4+) 足球客队精确得牌（4+）
1173 Exact Bookings(6+) 足球精确得牌（6+）
1174 Home Exact Bookings(3+) 足球主队精确得牌（3+）
1175 Away Exact Bookings(3+) 足球客队精确得牌（3+）
1176 Which Half First Goal 足球第一个进球发生在哪
个半场
134
1177 Home Which Half First Goal 足球主队第一个进球发生在
哪个半场
1178 Away Which Half First Goal 足球客队第一个进球发生在
哪个半场
1179 Which Team To Take The First Penalty
足球哪支球队踢第一个点
球
1180 Go to Sudden Death 足球是否进行点球骤死赛
1181 Round 1 Woodwork 足球点球第一个回合踢中
门柱
1182 Round 2 Woodwork 足球点球第二个回合踢中
门柱
1183 Round 3 Woodwork 足球点球第三个回合踢中
门柱
1184 Round 4 Woodwork 足球点球第四个回合踢中
门柱
1185 Round 5 Woodwork 足球点球第五个回合踢中
门柱
1186 Half Time/Full Time Correct Score 足球半/全场正确比分
3001 basketball 1x2 篮球胜平负（3项）
3002 Handicap 篮球让分
3003 Over/under 篮球总分大小
3004 Winner 篮球独赢（2项）
3005 Odd/Even 篮球单双
3006 European/Handicap 篮球欧盘让分(已删除)
3007 Winning Margin 26+
篮球胜分差（选项 主胜1-5，
主胜6-10，主胜11-15，主胜
16-20，主胜21-25，主胜26+
，客胜1-5，客胜6-10，客胜
11-15，客胜16-20，客胜
21-25，客胜26+）
3008 Race To X Points 篮球首次达到x分球队
3012 Over/Under Home 篮球主队总分大小
3013 Over/Under Away 篮球客队总分大小
3014 Winner & Over/Under 篮球独赢和大小
3015 Will There Be Overtime 篮球会有加时
3016 The Highest Scoring Quarter 篮球最高得分的节
3017 Half Time/Full Time
篮球半/全场胜平负（常规时
间）
135
3020 Money line 独赢（两项）
3021 Last Point 篮球最后一分的球队
3022 Odd/Even Home 篮球主队总得分单双
3023 Odd/Even Away 篮球客队总得分单双
3026 Total (Over-Exact-Under) 篮球全场大小（包含精确）
3027 Quarter Winner Margin 篮球单节胜分差
3028 Half Time/Full Time(Incl OT) 篮球半/全场(包含加时)
3029 Basketball Quarter Race To X Points
篮球单节首次到达x分的球
队
3030 Basketball Xth Point Scoring Type 篮球第x分的得分类型
3031
Basketball Any Team Xth Point Scoring
Type
篮球任意球队第X分的得分
类型
3032 Basketball Xth Point 篮球第X分的球队
3033 Basketball The Highest Scoring Half 篮球最高得分半场
3034 Basketball Xth Timeout 篮球第x个暂停球队
3035 Basketball Xth Free Throw Scored 篮球第x个罚球得分球队
3036
Basketball Which Team Wins The Jump
Ball 篮球哪对赢得争球
3037 Basketball Last Digit 篮球得分最后一位数
3038 Basketball Last Digit Home 篮球主队得分最后一位数
3039 Basketball Last Digit Away 篮球得分最后一位数
3040 Basketball Correct Quarter Odd/Even 篮球单节单双组合
3041 Basketball Handicap & Over/Under 篮球让分大小组合
19001 boxing Over/Under 拳击大小
19002 boxing Winner 拳击独赢（两项）
19003 boxing Fight To Go The Distance 拳击是否会奋战到底
19004 boxing Winning Method 拳击获胜方式
2001 Ice Hockey Handicap 冰球让球
2002 Ice Hockey Over/Under 冰球大小球
2003 Ice Hockey 1x2 冰球胜平负
2004 Ice Hockey Odd/Even 冰球单双
2005 Ice Hockey Over/Under Home 冰球主队大小球
2006 Ice Hockey Over/Under Away 冰球客队大小球
2007 Ice Hockey Winner 冰球胜负
136
2008 Ice Hockey Winning Margin 3+ 冰球胜分差
2009 Ice Hockey Which Team Wins The Rest 冰球剩余时间获胜球队
2010 Ice Hockey Xth Goal 冰球第x粒进球
2011 Ice Hockey Last Goal 冰球最后的进球
2012 Ice Hockey Correct Score(Max 7) 冰球正确比分
2013 Ice Hockey Will There Be Overtime 冰球比赛会有加时
2014 Ice Hockey The Highest Scoring Period 冰球最高得分节
2015 Ice Hockey Double Chance 冰球双重机会
15001 Table Tennis Winner 乒乓球独赢（两项）
15002 Table Tennis Point Handicap 乒乓球让分
15003 Table Tennis Points Over/Under 乒乓球大小分
15004 Table Tennis Correct Score(BO5) 乒乓球正确比分(BO5)
15005 Table Tennis Correct Score(BO7) 乒乓球正确比分(BO7)
15006 Table Tennis Game Odd/Even 乒乓球单双
15008 Table Tennis Game Winner 乒乓球单局独赢（两项）
179001 CSGO 2Way CSGO 独赢（两项）
13001 Volleyball Winner 排球独赢（两项）
13002 Volleyball Point Handicap 排球让分
13003 Volleyball Points Over/Under 排球大小分
13004 Volleyball Correct Score(BO5) 排球正确比分(BO5)
13005 Volleyball Correct Score(BO7) 排球正确比分(BO7)
13006 Volleyball Set Winner 排球局独赢
13007 Volleyball Odd/Even 排球单双
5001 Tennis Winner 网球独赢（两项）
5002 Tennis Game Handicap 网球让局
5003 Tennis Games Over/Under 网球总局数
5004 Tennis Set Handicap 网球让盘
5005 Tennis Sets Over/Under 网球总盘数
5006 Tennis Correct Score(BO3) 网球正确比分(BO3)
5007 Tennis Correct Score(BO5) 网球正确比分(BO5)
5008 Tennis Games Over/Under Home 网球选手1总局数
5009 Tennis Games Over/Under Away 网球选手2总局数
5010 Tennis Games Odd/Even 网球局数单双
137
5011 Tennis Set Correct Score 网球正确盘分
5012 Tennis Set Winner 网球盘独赢
5013 Tennis Game X Winner 网球第几局胜者
5014 Tennis Will There Be A Tiebreak 网球是否会有抢七
5015 Tennis Double Result (1st Set/Match) 网球第一盘/整场比赛胜负
7001 Baseball Handicap 棒球让分
7002 Baseball Over/Under 棒球大小分
7003 Baseball Winner 棒球独赢（两项）
7004 Baseball Over/Under Home 棒球主队大小分
7005 Baseball Over/Under Away 棒球客队大小分
7006 Baseball 1x2 棒球独赢（三项）
7007 Baseball Odd/Even 棒球单双
7008 Baseball Which Team Wins The Rest 棒球剩余时间获胜
7009 Will There Be An Extra Inning 棒球是否有加时
7010 Baseball Winning Margin 棒球胜分差
7011 Baseball Hits Over/Under 棒球安打大小分
7012 Baseball Home Runs Over/Under 棒球本垒打大小分
7013 Baseball Moneyline 棒球独赢（两项）
47001 Badminton Winner 羽毛球 独赢（两项）
47002 Badminton Point Handicap 羽毛球 让分
47003
Badminton Points
Over/UnderBASEBALL_HOME_SCORE 羽毛球 总分大小分
47004 Badminton Correct Score(BO3) 羽毛球 正确比分(BO3)
47005 Badminton Correct Score(BO5) 羽毛球 正确比分(BO5)
47006 Badminton Game Winner 羽毛球 局独赢
47007 Badminton Game Odd/Even 羽毛球 局单双
47008 Badminton Xth Point 羽毛球 局内第X分的球队
16001 Frame Handicap 斯诺克让局数
16002 Frame Over/Under 斯诺克局大小
16003 Winner 斯诺克独赢（两项）
16004 Points Handicap 斯诺克单局让分
16005 Points Over/Under 斯诺克单局大小分
16006 Frame Winner 斯诺克单局独赢（两项）
138
16007 Frame Odd/Even 斯诺克局数单双
16008 Race To X Frames 斯诺克最先赢得X局的选手
16009 Which Player Wins The Rest 斯诺克剩余时间获胜
16010 Will There Be a Deciding Frame 斯诺克是否会有决胜局
16011 Points Odd/Even 斯诺克总分单双
16012 Race To X Points 斯诺克最先获得X分的选手
16013 layer With Highest Break 斯诺克单杆最高分选手
16014 1x2 斯诺克独赢（三项）
16015 Break 50+ 斯诺克是否有单杆得分50+
16016 Break 100+ 斯诺克是否有单杆得分100+
16017 1x2 Frame 1 to 斯诺克前X局独赢（三项）
6001 Football Handicap 美式橄榄球让球
6002 Football Over/Under 美式橄榄球大小
6003 Football Winner 美式橄榄球胜负
6004 Football Over/Under Home 美式橄榄球主队大小
6005 Football Over/Under Away 美式橄榄球客队大小
6006 americanFootball Odd/Even 美式橄榄球单双
6007 Football Odd/Even Home 美式橄榄球主队单双
6008 Football Odd/Even Away 美式橄榄球客队单双
6009 Football 1x2 美式橄榄球独赢(三项)
6010 Football Moneyline 美式足球平局退款
6011 Football Will There Be Overtime 美式橄榄球是否有加时
6012 Football The Highest Scoring Quarter 美式橄榄球最高得分节
6013 Football The Highest Scoring Half 美式橄榄球最高得分半场
6014 Football Race To X Points 美式橄榄球最先到达x分
6015 Football Half Time/Full Time 美式橄榄球半/全场
6016 Football Touchdowns Over/Under 美式橄榄球达阵大小
6017 Football Field Goals Over/Under 美式橄榄球射门大小
6018 Football Xth Field Goal 美式橄榄球第x个射门球队
6019 Football Next Score
美式橄榄球下一个得分的
球队
6020 Football Next Scoring Type
美式橄榄球下一个得分类
型
51001 beach volleyball Winner 沙滩排球独赢（两项）
139
51002 beach volleyball Point Handicap 沙滩排球让分
51003 beach volleyball Points Over/Under 沙滩排球大小分
51004 beach volleyball Correct Score(BO5) 沙滩排球正确比分(BO5)
51005 beach volleyball Correct Score(BO3) 沙滩排球正确比分(BO3)
51006 beach volleyball Set Winner 沙滩排球局独赢
51007 beach volleyball Odd/Even 沙滩排球单双
4001 Rugby Handicap 橄榄球让球
4002 Rugby Over/Under 橄榄球大小
4003 Rugby 1x2 橄榄球独赢(三项)
4004 Rugby Moneyline 橄榄球平局退款
4005 Rugby Over/Under Home 橄榄球主队大小
4006 Rugby Over/Under Away 橄榄球客队大小
4007 Rugby Odd/Even 橄榄球单双
4008 Rugby To Qualify 橄榄球晋级球队
8001 handball Handicap 手球让球
8002 handball Over/Under 手球大小
8003 handball Over/Under Home 手球主队大小
8004 handball Over/Under away 手球客队大小
8005 handball 1x2 手球胜平负
8006 handball Moneyline 手球平局退款
8007 handball Odd/Even 手球单双
8008 handball Winner 手球胜负
18001 MMA Over/Under 混合格斗大小
18002 MMA Winner 混合格斗独赢（两项
18003 MMA Fight To Go The Distance 混合格斗是否会奋战到底
18004 MMA Winning Method 混合格斗获胜方式
24001 Water Polo Over/Under 水球大小
24002 Water Polo 1x2 水球独赢
177001 E-Soccer Handicap 电子足球让球
177002 E-Soccer Over/Under 电子足球大小球
177003 E-Soccer 1X2 电子足球独赢(胜平负)
177004 E-Soccer Over/Under Home 电子足球主队大小球
177005 E-Soccer Over/Under Away 电子足球客队大小球
140
177006 e-soccer the first few goals 电子足球第X个进球
177007 E-Soccer Odd/Even 电子足球单双
177008 E-Soccer Which Team Wins The Rest 电子足球剩余时间获胜
177009 E-Soccer Draw No Bet 电子足球平局退款
177010 E-Soccer Home No Bet 电子足球主胜退款
177011 E-Soccer Away No Bet 电子足球客胜退款
177012 E-Soccer Double Chance 电子足球双重机会
177013 E-Soccer European Handicap 电子足球足球欧盘让球
177014 E-Soccer Exact Goals Home(3+) 电子足球主队精确进球数
（选项0，1，2，3+）
177015 E-Soccer Exact Goals Away(3+) 电子足球客队精确进球数
（选项0，1，2，3+）
177016 E-Soccer Home To Win 电子足球足球主队是否获胜
177017 E-Soccer Away To Win 电子足球足球客队是否获胜
177018 E-Soccer Any Team To Win 电子足球任意球队获胜
178001 E-BasketBall Handicap 电子篮球让分
178002 E-BasketBall Over/under 电子篮球大小分
178003 E-BasketBall Winner 电子篮球独赢（2项
178004 E-BasketBall Over/Under Home 电子篮球主队总分大小
178005 E-BasketBall Over/Under Away 电子篮球客队总分大小
178006 E-BasketBall Odd/Even 电子篮球单双
178007 E-BasketBall 1x2 电子篮球独赢（三项）
178008 E-BasketBall Draw No Bet 电子篮球平局退款
178009 E-BasketBall inner & Over/Under 电子篮球独赢和大小
1999 Dynamic Outright Market 足球冠军赛事动态玩法
1998 Winner 足球冠军赛事胜者
1997 Top 2 足球冠军赛事A组前2名球
队
1996 Top 3 足球冠军赛事A组前两名球
队
1995 Top 4 足球冠军赛事A组前两名球
队
1994 Top 6 足球冠军赛事A组前6名球
队
1993 Top 8 足球冠军赛事A组前8名球
队
141
1
9
9
2
To
Finis
h in
To
p
H
alf
足
球
冠
军
赛
事
跻
身
前
半
部
分
球
队
1
9
9
1
To
Finis
h in
B
o
t
t
o
m
H
alf
足
球
冠
军
赛
事
跻
身
后
半
部
分
球
队
1
9
9
0
R
ele
g
a
tio
n
足
球
冠
军
赛
事
降
级
球
队
1
9
8
9
P
r
o
m
o
tio
n
足
球
冠
军
赛
事
晋
级
球
队
1
9
8
8
G
r
o
u
p
A
Win
n
e
r
足
球
冠
军
赛
事
A
组
胜
者
1
9
8
7
G
r
o
u
p
B
Win
n
e
r
足
球
冠
军
赛
事
B
组
胜
者
1
9
8
6
G
r
o
u
p
C
Win
n
e
r
足
球
冠
军
赛
事
C
组
胜
者
1
9
8
5
G
r
o
u
p
D
Win
n
e
r
足
球
冠
军
赛
事
D
组
胜
者
1
9
8
4
G
r
o
u
p
E
Win
n
e
r
足
球
冠
军
赛
事
E
组
胜
者
1
9
8
3
G
r
o
u
p
F
Win
n
e
r
足
球
冠
军
赛
事
F
组
胜
者
1
9
8
2
G
r
o
u
p
G
Win
n
e
r
足
球
冠
军
赛
事
G
组
胜
者
1
9
8
1
G
r
o
u
p
H
Win
n
e
r
足
球
冠
军
赛
事
H
组
胜
者
1
9
6
8
G
r
o
u
p I Win
n
e
r
足
球
冠
军
赛
事I组
胜
者
1
9
6
7
G
r
o
u
p
J
Win
n
e
r
足
球
冠
军
赛
事
J
组
胜
者
1
9
8
0
G
r
o
u
p
A
To
p
2
足
球
冠
军
赛
事
A
组
前
两
名
球
队
1
9
7
9
G
r
o
u
p
B
To
p
2
足
球
冠
军
赛
事
B
组
前
两
名
球
队
1
9
7
8
G
r
o
u
p
C
To
p
2
足
球
冠
军
赛
事
C
组
前
两
名
球
队
1
9
7
7
G
r
o
u
p
D
To
p
2
足
球
冠
军
赛
事
D
组
前
两
名
球
队
1
9
7
6
G
r
o
u
p
E
To
p
2
足
球
冠
军
赛
事
E
组
前
两
名
球
队
1
9
7
5
G
r
o
u
p
F
To
p
2
足
球
冠
军
赛
事
F
组
前
两
名
球
队
1
9
7
4
G
r
o
u
p
G
To
p
2
足
球
冠
军
赛
事
G
组
前
两
名
球
队
1
9
7
3
G
r
o
u
p
H
To
p
2
足
球
冠
军
赛
事
H
组
前
两
名
球
队
1
9
6
6
G
r
o
u
p I To
p
2
足
球
冠
军
赛
事I组
前
两
名
球
队
1
9
6
5
G
r
o
u
p
J
To
p
2
足
球
冠
军
赛
事
J
组
前
两
名
球
队
1
9
7
2
To
R
e
a
c
h
t
h
e
Q
u
a
r
t
e
r
Fin
al 足
球
冠
军
赛
事
进
入
四
分
之
一
决
赛
球
队
1
4
2
1971 To Reach the Semi Finaleach 足球冠军赛事进入半决赛球
队
1970 To Finish Bottom 足球冠军赛事垫底球队
1969 Top Goalscorer 足球冠军赛事最高得分球员
3999 Dynamic Outright Market 篮球冠军赛事动态玩法
3900 Dynamic Outright Market 篮球系列赛冠军
3901 Series Handicap 篮球系列赛让分
3902 Series Correct Score 篮球系列赛正确比分
3903 Regular Season Wins 篮球常规赛胜利
3904 To Reach the Playoffs 篮球是否进入季后赛
3905 Series Game End 篮球系列赛第几场结束
3906 Series Correct Score After Game 3 篮球系列赛第三场比赛后比
分
3907 Series Correct Score After Game 4 篮球系列赛第四场比赛后比
分
3998 Dynamic Outright Market 篮球冠军赛事动获胜者
3997 Top 2 篮球冠军赛事A组前2名球
队
3996 Top 3 篮球冠军赛事A组前3名球
队
3995 Top 4 篮球冠军赛事A组前4名球
队
3994 Group A Winner 篮球冠军赛事A组胜者
3993 Group B Winner 篮球冠军赛事B组胜者
3992 Group C Winner 篮球冠军赛事C组胜者
3991 Group D Winner 篮球冠军赛事D组胜者
3990 Group E Winner 篮球冠军赛事E组胜者
3989 Group F Winner 篮球冠军赛事F组胜者
3988 Group G Winner 篮球冠军赛事G组胜者
3987 Group H Winner 篮球冠军赛事H组胜者
3986 Western Conference Winner 篮球冠军赛事西部冠军
3985 Eastern Conference Winner 篮球冠军赛事东部冠军
3984 Division Central Winner 篮球冠军赛事中部冠军
3983 Division Southwest Winner 篮球冠军赛事西南南冠军
3982 Division Southeast Winner 篮球冠军赛事东南冠军
143
3981 Division Northwest Winner 篮球冠军赛事西北冠军
3980 Division Pacific Winner 篮球冠军赛事太平洋区冠军
3979 Division Atlantic Winner 篮球冠军赛事大西洋区冠军
3978 Awards Coach Of The Year 篮球冠军赛事年度最佳教练
3977 Group H Winner
篮球冠军赛事年度最佳防守
球员
3976 Group H Winner
篮球冠军赛事Regular
Season MVP
3975 Awards Rookie Of The Year 篮球冠军赛事年度最佳新秀
3974 Awards Most Improved Player
篮球冠军赛事最具进步的球
员
3973 Awards Sixth Man Of The Year
篮球冠军赛事年度最佳第六
人奖
3971
Regular Season Rebounds Per Game
Leader
篮球冠军赛事年度最佳第六
人奖
3970
Regular Season Three Pointers Made Per
Game Leader
篮球冠军赛事常规赛每场篮
板数冠军
3969 Regular Season Points Per Game Leader
篮球冠军赛事年度常规赛每
场得分领先者
3968 Regular Season Assists Per Game Leader
篮球冠军赛事常规赛每场助
攻王
3967 Regular Season Winner 篮球冠军赛事常规赛冠军
3966 Finals MVP 篮球冠军赛事总决赛MVP
3965 Winning Conference 篮球获胜联盟
3964 Winning Division 篮球获胜赛区
3963 Straight Forecast 1-2 篮球第一二名预测
5999 Dynamic Outright Market 网球冠军赛事冠军
5998 Winner 网球冠军赛事冠军
13999 Dynamic Outright Market 排球冠军赛事冠军
13998 Winner 排球冠军赛事冠军
15999 Dynamic Outright Market 乒乓球冠军赛事冠军
15998 Winner 乒乓球冠军赛事冠军
47999 Dynamic Outright Market 羽毛球冠军赛事冠军
47998 Winner 羽毛球冠军赛事冠军
2999 iceHockey Dynamic Outright Market 冰球冠军赛事冠军
2998 iceHockey Winner 冰球冠军赛事冠军
144
2997 iceHockey Western Conference Winner 冰球冠军赛事冠军
2996 iceHockey Eastern Conference Winner 冰球东部冠军
2995 iceHockey Metropolitan Division Winner 冰球大都会赛区冠军
2994 iceHockey Pacific Division Winner 冰球太平洋赛区冠军
2993 iceHockey Central Division Winner 冰球中央赛区冠军
2992 iceHockey Atlantic Division Winner 冰球大西洋赛区冠军
177999 Dynamic Outright Market 电子足球冠军赛事冠军
177998 Winner 电子足球冠军赛事冠军
178999 Dynamic Outright Market 电子篮球冠军赛事冠军
178998 Winner 电子篮球冠军赛事冠军
4999 Dynamic Outright Market 橄榄球冠军赛事冠军
4998 Winner 橄榄球冠军赛事冠军
6999
americanFootball Dynamic Outright
Market 美式足球冠军赛事冠军
6998 americanFootball Winner 美式足球冠军赛事冠军
6997 americanFootball AFC Conference Winner 美式足球亚足联会议获胜者
6996 americanFootball NFC Conference Winner 美式足球NFC会议获胜者
6995
americanFootball AFC Division East
Winner
美式足球亚足联分区东部冠
军
6994
americanFootball AFC Division South
Winner
美式足球亚足联分区南冠军
6993
americanFootball AFC Division West
Winner
美式足球亚足联西区冠军
6992
americanFootball AFC Division North
Winner
美式足球亚足联赛区北冠军
6991
americanFootball NFC Division East
Winner
美式足球NFC 部门东部冠军
6990
americanFootball NFC Division South
Winner
美式足球NFC 部门南优胜者
6989
americanFootball NFC Division West
Winner
美式足球NFC 部门西部冠军
6988
americanFootball NFC Division North
Winner
美式足球NFC 部门北获胜者
6987 americanFootball Winning Conference 美式足球获胜联盟
6986 americanFootball Winning Division 美式足球获胜赛区
7999 Dynamic Outright Market 棒球冠军赛事冠军
145
7998 Winner 棒球冠军赛事冠军
7997 American League Winner 棒球冠军赛事美国联盟冠军
7996 National League Winner 棒球冠军赛事国家联盟冠军
7995 American League Central Winner
棒球冠军赛事美国联盟中区
冠军
7994 American League East Winner
棒球冠军赛事美国联盟东区
冠军
7993 American League West Winner
棒球冠军赛事美国联盟西区
冠军
7992 National League Central Winner
棒球冠军赛事国家联盟中区
冠军
7991 National League East Winner
棒球冠军赛事国家联盟东区
冠军
7990 National League West Winner
棒球冠军赛事国家联盟西区
冠军
8999 Dynamic Outright Market 手球冠军赛事冠军
8998 Winner 手球冠军赛事冠军
12999 Dynamic Outright Market 高尔夫冠军赛事冠军
12998 Winner 高尔夫冠军赛事冠军
14999 Dynamic Outright Market 板球冠军赛事冠军
14998 Winner 板球冠军赛事冠军
16999 Dynamic Outright Market 斯诺克冠军赛事冠军
16998 Winner 斯诺克冠军赛事冠军
17999 Dynamic Outright Market 五人足球冠军赛事冠军
17998 Winner 五人足球冠军赛事冠军
19999 Dynamic Outright Market 拳击冠军赛事冠军
19998 Winner 拳击冠军赛事冠军
20999 Dynamic Outright Market 飞镖冠军赛事冠军
20998 Winner 飞镖冠军赛事冠军
21999 Dynamic Outright Market BOWLS冠军赛事冠军
21998 Winner 保龄球冠军赛事冠军
164999 Dynamic Outright Market DOTA2冠军赛事冠军
164998 Winner DOTA2冠军赛事冠军
165999 Dynamic Outright Market LOL冠军赛事冠军
165998 Winner 英雄联盟冠军赛事冠军
146
179999 Dynamic Outright Market CSGO冠军赛事冠军
179998 Winner CSGO冠军赛事冠军
180999 Dynamic Outright Market 王者荣耀冠军赛事冠军
180998 Winner 王者荣耀冠军赛事冠军
10999 Floor ball Dynamic Outright Market 地板球冠军赛事冠军
10998 Floor ball Winner 地板球冠军赛事冠军
18999 MMA Dynamic Outright Market 格斗冠军赛事冠军
18998 MMA Winner 格斗冠军赛事冠军
25999 Cycling Dynamic Outright Market 自行车冠军赛事冠军
25998 Cycling Winner 自行车冠军赛事冠军
51999 BeachVolleyball Dynamic Outright Market 沙滩排球冠军赛事冠军
51998 BeachVolleyball Winner 沙滩排球冠军赛事冠军
92999 Formula 1 Dynamic Outright Market F1赛车冠军赛事冠军
92998 Formula 1 Drivers' Champion F1赛车车手冠军
92997 Formula 1 Constructors Winner F1赛车车队冠军
93999 Specials Dynamic Outright Market 特殊投注赛事冠军
93998 Specials Winner 特殊投注冠军赛事冠军
93997 Specials Best Actor (Oscar) 特殊投注最佳男演员(奥斯
卡)
93996 Specials Best Actress (Oscar) 特殊投注最佳女演员(奥斯
卡)
93995
Specials Best Animated Feature Film
(Oscar)
特殊投注最佳动画电影（奥
斯卡）
93994 Specials Best Cinematography (Oscar) 特殊投注最佳摄影（奥斯
卡）
93993 Specials Best Costume Design (Oscar) 特殊投注最佳服装设计（奥
斯卡）
93992 Specials Best Director (Oscar) 特殊投注最佳导演（奥斯
卡）
93991
Specials Best Documentary Feature
(Oscar)
特殊投注最佳纪录片（奥斯
卡）
93990 Specials Best Film Editing (Oscar) 特殊投注最佳影片剪辑（奥
斯卡）
93989
Specials Best International Feature Film
(Oscar)
特殊投注最佳国际剧情片
（奥斯卡）
93988
Specials Best Makeup and Hairstyling
(Oscar)
特殊投注优化妆发型（奥斯
卡）
147
93987
Specials Best Music - Original Score
(Oscar)
特殊投注最佳音乐-原创乐
谱（奥斯卡）
93986 Specials Best Music - Original Song (Oscar) 特殊投注最佳音乐-原创歌
曲（奥斯卡）
93985 Specials Best Picture (Oscar) 特殊投注最佳影片（奥斯
卡）
93984 Specials Best Production Design (Oscar) 特殊投注最佳艺术指导（奥
斯卡）
93983 Specials Best Sound (Oscar) 特殊投注最佳音响（奥斯
卡）
93982 Specials Best Supporting Actress (Oscar) 特殊投注最佳女配角（奥斯
卡）
93981 Specials Best Visual Effects (Oscar) 特殊投注最佳视觉效果奖
（奥斯卡）
93980
Specials Best Writing - Adapted
Screenplay (Oscar)
特殊投注最佳编剧-改编剧
本（奥斯卡）
93979
Specials Best Writing - Original Screenplay
(Oscar)
特殊投注最佳编剧-原创剧
本（奥斯卡）
93978 Specials Best Actor (Bafta) 特殊投注最佳男演员（英国
电影学院）
93977 Specials Best Actress (Bafta) 特殊投注最佳女演员（英国
电影学院）
93976 Specials Best Director (Bafta) 特殊投注最佳导演（英国电
影学院）
93975 Specials Best Film (Bafta) 特殊投注最佳影片（英国电
影学院）
93974 Specials Best Supporting Actor (Bafta) 特殊投注最佳男配角（英国
电影学院）
93973 Specials Best Supporting Actress (Bafta) 特殊投注最佳女配角（英国
电影学院）
93972 Specials Outstanding British Film (Bafta) 特殊投注英国杰出电影（英
国电影学院）
100999 OLYMPIC Dynamic Outright Market 奥林匹克冠军赛事冠军
100998 OLYMPIC Winner 奥林匹克冠军赛事冠军
100997 OLYMPIC Most Gold Medals 奥林匹克冠军最多金牌
100996 OLYMPIC Most Medals 奥林匹克冠军大多数奖牌
24999 WaterPolo Dynamic Outright Market 水球冠军赛事冠军
24998 WaterPolo Winner 水球冠军赛事冠军
94999
Stock Car Racing Dynamic Outright
Market 赛车动态冠军赛事玩法
148
94998 Stock Car Racing Winner 赛车冠军赛事冠军
16018 Will There Be A Foul Committed 斯诺克是否会有犯规
16019 Player To Pot Xth Ball 斯诺克打第X个球的选手
16020 Player To Pot Last Ball 斯诺克打最后球的选手
16021 Last Points Scored 斯诺克最后得分的类型
16022 Correct Score(BO5) 斯诺克正确比分（BO5）
16023 Correct Score(BO7) 斯诺克正确比分（BO7）
16024 Correct Score(BO9) 斯诺克正确比分（BO9）
16025 Correct Score(BO11) 斯诺克正确比分（BO11）
1001003 1x2 虚拟足球独赢
1001015 Half Time/Full Time 虚拟足球半/全场
1001004 Double Chance 虚拟足球双重机会
1001006 Correct Score(Max6) 虚拟足球波胆（Max6）
1001007 Exact Goals（Max6） 虚拟足球精确进球数（Max6
）
1001008 Both Teams To Score 虚拟足球双方都进球
1001002 Over/Under 虚拟足球大/小
1001016 1x2 & Over/Under 虚拟足球独赢 & 大/小
1001011 Multi Goal Range 虚拟足球进球区间（多项）
1001001 Asian Handicap 虚拟足球让球
1001005 European Handicap 虚拟足球欧盘让球
1001012 Goal Range Home(3+) 虚拟足球主队进球区间
1001013 Goal Range Away(3+) 虚拟足球客队进球区间
1001010 Correct Score(Max3) 虚拟足球波胆（Max3）
1001009 Odd/Even 虚拟足球单双
1001014 Winning Margin 虚拟足球胜分差
1020001 Winner 虚拟赛马冠军
1020002 Place 虚拟赛马前二
1020003 Show 虚拟赛马前三
1020004 Quinella 前二组合
1020005 Exacta 准确前二
1020006 Over/Under 大小
1020007 Odd/Even 单双
149
1021001 Winner 虚拟赛狗冠军
1021002 Place 虚拟赛狗前二
1021003 Show 虚拟赛狗前三
1021004 Quinella 前二组合
1021005 Exacta 准确前二
1021006 Over/Under 大小
1021007 Odd/Even 单双
1022001 Winner 虚拟沙地摩托冠军
1022002 Place 虚拟沙地摩托前二
1022003 Show 虚拟沙地摩托前三
1022004 Quinella 前二组合
1022005 Exacta 准确前二
1022006 Over/Under 大小
1022007 Odd/Even 单双
1023001 Winner 虚拟摩托冠军
1023002 Place 虚拟摩托前二
1023003 Show 虚拟摩托前三
1023004 Quinella 前二组合
1023005 Exacta 准确前二
1023006 Over/Under 大小
1023007 Odd/Even 单双
92001 Formula 1 Head To Head F1赛车对垒赛
14001 Cricket 1x2 板球独赢(胜平负)
14002 Cricket Winner 板球独赢
14006 Cricket Odd/Even 板球单双
14007 Cricket Highest Opening Partnership
板球在每队第一人出局前
得分最高球队
14008 Cricket Will There Be A Super Over 板球是否有加时
14009 Cricket Will There Be A Tie 板球是否有平局
14010 Cricket To Win The Toss 板球抛币获胜
14011 Cricket Most Fours 板球得四分最多的球队
14012 Cricket Most Sixes 板球得六分最多的球队
14013 Cricket Xth Over Over/Under 板球第X回合大小
150
14015 Cricket Xth Dismissal Method (2 Way) 板球第X出局方式
14016 Cricket Xth Dismissal Method (6 Way) 板球第X出局方式(6项)
4.9 虚拟体育产品代码 Virtual Sport Product Codes
Product Code Product Name
INST_BRAWLSTARS Brawl Stars
INST_CLASHROYALE Clash Royale
INST_CSGO CSGO
INST_FIFASHOOTOUT FIFA Shootout
INST_FALLGUYS Fall Guys
RETRO_INFINITEFIGHT Infinite Fighting
RETRO_KINGDERBY King Derby '86
RETRO_KOF98 KoF '98
INST_MLBSHOW MLB Strikeout
INST_NBA2K NBA2K
INST_NHL NHL
INST_SFVPRO Street Fighter V
INST_KOFXIV The King of Fighters
INST_UFC UFC
INST_WORLDSNOOKER Virtual World Snooker
INST_CRICKET22 Cricket 22
INST_LOL League of Legends
SIM_EAFC24 EA FC 24
SIM_NBA2K23 NBA2K23
Product Type Key Product Name
INST Virtual games
SIM Inplay Simulation Games
4.10 体育登入语系表 Sport Login Language Code
Language Code Description (EN) Description (CN)
151
ENG English 英文
CMN Chinese (Simplified) 中文（简体）
ZHO Chinese (Traditional) 中文（繁體）
JPN Japanese 日文
KOR Korean 韓文
SPA Spanish 西班牙文
VIE Vietnamese 越南文
THA Thai 泰文
MSA Malay 馬來文 
IND Indonesian 印尼文
HIN Hindi 印地文
SAU Arabic 阿拉伯文
DEU German 德文
FRA French 法文
BRA Brazilian Portuguese 巴西葡萄牙文
RUS Russian 俄文
TR Turkish 土耳其文
152