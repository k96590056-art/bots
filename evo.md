User Authentication
1 Overview
User Authentication API provides an interface which can be used to create new player and/or login existing player, create game session and launch the game.

1.1 Invocation details
Supported methods: POST
Response format: JSON
User Authentication 2.0 API service endpoint URL should never be revealed to the player and placed on Licensee website.
User authentication request must be posted in server- to-server mode.
User Authentication 2.0 API service endpoint URL must always use 'domain name' instead of IP address
User Authentication 2.0 API is served over HTTPS - to ensure security and data privacy, unencrypted HTTP is not supported
All IP addresses that need access to User Authentication 2.0 API must be white-listed in advance
1.2 Response codes and errors
User Authentication 2.0 API uses standard RFC 2616 HTTP response codes to indicate the success or failure of an API request:

Codes in the 2xx range indicate success

Codes in the 4xx range indicate a problem with the request

Codes in the 5xx range indicate an error with EVO's servers

2 User Authentication API service endpoint
https://{hostname}/ua/v1/{casino.key}/{api.token}
In order to launch game, Licensee has to send user authentication request to the service endpoint URL (see above). User authentication request body must be sent in JSON format using POST method. The default
behavior for a successful request is to redirect player to the game page based on the parameters provided in the request body. An authentication token string will be appended to the returned URL to identify the player's
session in EVO system. After receiving player's request for returned URL, EVO system will add the authentication token to a cookie, therefore player needs to ensure to have cookies enabled on his side.

URL parameters:
Name	Description	Mandatory/ Optional
casino.key	Casino key for User Authentication service, provided by EVO	M
api.token	API token for User Authentication service, provided by EVO	M
hostname	Licensee hostname, provided by Licensee. Licensee must provide SSL(s) for hostname(s) of production game launch host(s). EVO installs SSL and provides CNAME to configure	M
User authentication request body must be sent in following format:
  {
        "uuid": "unique request identifier",
        "player": {
            "id": "a1a2a3a4",
            "update": true,
            "firstName": "firstName",
            "lastName": "lastName",
            "country": "DE",
            "nickname": "nickname",
            "language": "en",
            "currency": "EUR",
            "session": {
                "id": "111ssss3333rrrrr45555",
                "ip": "192.168.0.1"
            }
        },
        "config": {
            "game": {
                "category": "roulette",
                "interface": "view1",
                "table": {
                    "id": "vip-roulette-123"
                }
            },
            "channel": {
                "wrapped": false,
                "mobile": false
            }
        }
    }
3 User Authentication 2.0 API request parameters
Name	Data Type	Description	Mandatory/Optional
uuid	String	Unique request id, that identifies concrete user authentication request (attempt).	M
player	Object	Object containing player details.	M
player.id	String (50)	Player's ID. Unique identifier of a player, assigned by Licensee.	M
player.update	Boolean	Indicates if player details should be updated. True if system is asked to update player records. False if player data is relevant for current session only. Updates firstName, lastName, nickname, country, language values.	M
player.firstName	String (50)	Player's first name.	M
player.lastName	String (50)	Player's last name.	M
player.nickname	String (35)	Player's preferred nickname (screen name). If not passed then player will be prompted to enter nickname on first Live casino visit.	O
player.country	String (2)	Player's country code (ISO 3166, 2 letter code).	M
player.language	String (2)	Player's preferred language (ISO 639-1, 2 letter code).	M
player.currency	String (3)	Player's currency (ISO 4217, 3 letter code).	M
player.session	Object	Object containing player session details.	M
player.session.id	String (250)	Player's session ID, assigned by Licensee.	M
player.session.ip	String	Player's session IP address. Both IPv4 and IPv6 are acceptable formats.	M
config	Object	Object containing game launch configuration options.	M
config.game	Object	Object containing game launch configuration and direct table launch options.	O
config.game.category	String	Specifies game category what needs to be launched:
-game_shows
-baccarat_sicbo
-poker
-top_games
-roulette
-blackjack
-slots
(no respective category in Evolution lobby) The category is not used for direct game launch and only can be used for lobby category launch.	O
config.game.interface	String	Specifies the game interface version:
view1 - launch game in 3D view;
view2 - launch game in classic view;
MLR - launch game in mini live roulette view;
Slingshot - launch game in slingshot view (for auto-roulette only);
hd1 - roulette immersive view and used in CSP.
Must be used in conjunction with config.game.table object.	O
config.game.table	Object	Object containing table details for direct game launch.	O
config.game.table.id	String	Specifies table ID for the game table which needs to be launched. either table ID or virtual table ID has to be specified for direct table launch. Direct table launch of a virtual table must submit tables's virtual ID list of table ID's for generic tables for UAT and Live environments can be found in document "Integration manual". Virtual table IDs are different for each casino and should be requested separately each slot game is assigned a table ID that is to be used for slot game direct launch	M
config.channel	Object	Object containing game channel configuration options.	M
config.channel.wrapped	Boolean	Specifies if client is wrapped or standalone. Should only be sent as true for standalone native or mobile apps.	M
config.channel.mobile	Boolean	Specifies if game is launched using mobile device.	O
1.4 User Authentication API 2.0 response format
1.4.1 Successful response
In case of successful initialization call response, User Authentication 2.0 API will return HTTP status 200 and following response body:

{
    
    "entry": "/entry?params=c2l0ZT1fX2RlZmF1bHRfXwpnYW1lPWhvOPTNlYmQ5NWY1NWEwOTQyNmRiYmFjOTcxNmNiNzEw&JSESSIONID=3ebd95f55a09426dbbac9716cb7101a40c3a9a20", 
    "entryEmbedded": "/entry?params=c2l0ZT1fX2RlZmF1bHRfXwpnYW1lPWhvOPTNlYmQ5NWY1NWEwOTQyNmRiYmFjOTcxNmNiNzEw&JSESSIONID=3ebd95f55a09426dbbac9716cb7101a40c3a9a20&embedded"
}

Response attributes:
Name	Type	
Description
entry	String	Contains the URL to be added to host name and used for user redirection
entryEmbedded	String	Contains the URL to be added to host name and used for user redirection
In order to create game launch URL for the player, returned entry or entryEmbedded attribute value should be combined with according host name:

https://<<hostname>><<entry>>
or
https://<<hostname>><<entryEmbedded>>
Please note that EVO keeps the right to change content and format of returned URLs in the values of parameters entry and entryEmbedded.

1.4.2 Failure response
In case of failure, User Authentication 2.0 API will return HTTP status 4XX or HTTP status 5XX and following response body:

{
"errors": [
    {
        "code": "G.0",
        "message": "Could not authenticate, please review sent data and try again. 
                    If problem persists, contact customer support "
    }
  ]
}

Response attributes:
Name	Type	
Description
errors	Array	Array of error objects that contain failure/error codes and optional message
code	String	Error code
message	String	Optional message of failure reason
1.5 User Authentication 2.0 API error handling
Error codes are classified into following categories:

G - generic failures
V - validation of input parameters failed
1.5.1 Generic failures
Code	Text	Description
G.0	Could not authenticate, please review sent data and try again. If problem persists, contact customer support	System error, should be retried, in case of constant occurrences should be reported to EVO.
G.1	Unknown casino $casinoKey	$casinoKey will be provided by EVO
G.2	Provided $apiToken for casino $casinoKey is incorrect	$apiToken will be provided by EVO
G.3	Player session creation is not configured for casino $casinoKey	$apiToken have not been configured on EVO side
G.4	Unable to issue token	System error, should be retried, in case of constant occurrences should be reported to EVO
G.5	Unable to authenticate user	System error, should be retried, in case of constant occurrences should be reported to EVO
G.6	Unable to create user	System error, should be retried, in case of constant occurrences should be reported to EVO
G.7	Unable to save player data	System error, should be retried, in case of constant occurrences should be reported to EVO
G.8	Unable to authenticate user due to: $status	Most likely client system returned invalid $status
G.9	Clients IP address have been rejected	Provided to EVO client IP address for white listing is incorrect.
1.5.2 Validation failures
Code	Text
V.1	player.update' is a boolean and accepts only true/false
V.2	firstName' length must be at least 1 character long
V.3	firstName' length must be no more than 50 characters
V.4	lastName' length must be at least 1 character long
V.5	lastName' length must be no more than 50 characters
V.6	nickname' length must be at least 2 characters long
V.7	nickname' length must be no more than 35 characters
V.8	player.session' is missing
V.9	player.session.ip' is not correct. Should be 0-255.0-255.0-255.0-255
V.10	player.session.id' is empty or missing
V.11	player.country' is missing
V.12	player.currency' is missing
V.13	player.language' is missing
V.16	uuid can't be empty
V.17	player' is empty or missing
V.18	config' is empty or missing
V.19	config.brand' is missing or empty
V.20	config.channel' is missing or empty
V.21	config.brand.id' is empty
V.22	config.brand.id' too long
V.23	config.brand.skin' is empty
V.24	config.brand.skin' too long
V.25	config.game.type' or 'config.game.category' must be defined
V.26	config.game.table.id' is missing or empty
V.27	config.channel.wrapped' is missing or empty
V.28	Provided 'config.game.type' is not supported
V.29	Provided 'config.urls.$urlType' is not valid. Should start with http://, https://, (see page 8) native://, app://
V.30	player.nickname' $nickname already exists
V.31	player.country' $country is not valid
V.32	player.currency' $currency is not valid
V.33	player.currency' $currency can not be updated for player from FT casino
V.34	Table with id $tableId does not exist
V.35	player.firstName' is missing
V.36	player.lastName' is missing
V.37	config.brand.id' must be a string
V.38	config.brand.skin' must be a string
V.39	config.game.category' does not exist
V.40	config.channel.mobile' is not boolean
V.41	player.id' is missing
V.42	player.nickname' is missing - does`t present now
One Wallet Integration
2 Overview
For One Wallet integration, EVO system accesses the player's wallet in the licensee's system in real time (expected call processing time: <2sec ) to retrieve player's balance
and to perform credit, debit and cancel transactions. This communication is handled by the EVO One Wallet server

RESTful service with lightweight JSON-formatted requests/responses

Requests are made via HTTP POST method, containing JSON request object in request body (all responses should contain header "content-type: application/json")
Served over HTTPS - to ensure security and data privacy, unencrypted HTTP is not supported
Requests are sent out asynchronously. For example, for multi-step games settlement of 1st and 3rd bet can be sent out before late bet cancel of 2nd bet. Another example, Blackjack multi seat bets will be sent out for all seats as soon as betting time over.
All service calls will pass authentication token (API token) in query parameter "authToken" - it's a string, issued/generated per integration to add authentication/validation to service calls.
API token is configured and used in all service calls
API token value is URL encoded
2.1 One Wallet API methods
Assuming that REST service is deployed on URL https://my.service.host.com/api/ and authentication token value ("authToken" parameter) is "s3cr3tV4lu3" following API methods are accessible:

check: https://my.service.host.com/api/check?authToken=s3cr3tV4lu3 (CheckUserRequest / CheckUserResponse)
balance: https://my.service.host.com/api/balance?authToken=s3cr3tV4lu3 (BalanceRequest / StandardResponse)
debit: https://my.service.host.com/api/debit?authToken=s3cr3tV4lu3 (DebitRequest / StandardResponse)
credit: https://my.service.host.com/api/credit?authToken=s3cr3tV4lu3 (CreditRequest / StandardResponse)
cancel: https://my.service.host.com/api/cancel?authToken=s3cr3tV4lu3 (CancelRequest / StandardResponse)
For testing purposes following service should be implemented on test environments

sid: https://my.service.host.com/api/sid?authToken=s3cr3tV4lu3 (CheckUserRequest / CheckUserResponse)
2.2 One Wallet API request parameters
All request and response objects contains "uuid" field which represents unique identifier for each message. There should not be any additional handling based on this field and should be used only for informative purposes (e.g logging, tracing, etc)

Request	Attribute	Type	
Attribute description
CheckUserRequest	userId	string	Player's ID which is sent by Licensee in UserAuthentication call (player.id)
sid	string	Player's session ID which is sent by Licensee in UserAuthentication call (session.id).
channel	object	Object containing channel details
channel.type	string	Channel type for player in game. By default "M" for mobile clients, "P" for all other.
uuid	string	Unique request id, that identifies CheckUserRequest
BalanceRequest	sid	string	Player's session ID
userId	string	Player's ID, assigned by Licensee
currency	string	Currency code (ISO 4217 3 letter code)
game	object	Object containing game details In case of non-game related balance request (e.g user enters lobby) this object will be empty or null Could be used to apply limits for specific game data, e.g limit by game.type
game.type	string	The game type value (e.g. "slots")
game.details	object	Object containing additional game details
game.details.table	object	Object containing table details for the game
game.details.table.Id	string	string Unique table identifier
game.details.table.vid	string	Unique virtual table identifier (can be null in case there is no virtual table id)
uuid	string	Unique request id, that identifies BalanceRequest
DebitRequest	sid	string	Player's session ID
userId	string	Player's ID, assigned by Licensee
currency	string	Currency code (ISO 4217 3 letter code)
game	object	Object containing game details
game.id	string	Unique game round id in game Only provided with DebitRequest/ CreditRequest/CancelRequest, not provided with BalanceRequest
game.type	string	The game type value (e.g. "slots")
game.details	object	Object containing additional game round details
game.details.table	object	Object containing table details for the game Round
game.details.table.id	string	Unique table identifier
game.details.table.vid	string	Unique virtual table identifier (can be null in case there is no virtual table id)
transaction	object	Object containing transaction details
transaction.id	string	The unique identifier of transaction (e.g: used to avoid duplicate bets and other validations)
transaction.refId	string	Reference identifier for transaction, to be able to link (correlate) and/or validate credit/cancel requests to appropriate debit request
transaction.amount	decimal	Amount of transaction, rounded to 2 decimal Symbols
uuid	string	Unique request id, that identifies DebitRequest
CreditRequest	sid	string	Player's session ID
userId	string	Player's ID, assigned by Licensee
currency	string	Currency code (ISO 4217 3 letter code)
game	object	Object containing game details
game.id	string	Unique game round id in game only provided with DebitRequest/ CreditRequest/CancelRequest, not provided with BalanceRequest
game.type	string	The game type value (e.g. "blackjack", "holdem", "roulette", etc)
game.details	object	Object containing additional game round details
game.details.table	object	Object containing table details for the game Round
game.details.table.id	string	Unique table identifier
game.details.table.vid	string	Unique virtual table identifier (can be null in case there is no virtual table id)
transaction	object	Object containing transaction details
transaction.id	string	The unique identifier of transaction (e.g: used to avoid duplicate bets and other validations)
transaction.refId	string	Reference identifier for transaction, to be able to link (correlate) and/or validate credit/cancel requests to appropriate debit request
transaction.amount	decimal	Amount of transaction, rounded to 2 decimal Symbols
uuid	string	Unique request id, that identifies CreditRequest
CancelRequest	sid	string	Player's session ID
userId	string	Players ID, assigned by Licensee
currency	string	Currency code (ISO 4217 3 letter code)
game	object	Object containing game details
game.id	string	Unique game round id in game only provided with DebitRequest/CreditRequest/CancelRequest, not provided with BalanceRequest
game.type	string	The game type value (e.g. "slots")
game.details	object	Object containing additional game round details
game.details.table	object	Object containing table details for the game Round
game.details.table.id	string	Unique table identifier
game.details.table.vid	string	Unique virtual table identifier (can be empty or null in case there is no virtual table id)
transaction	object	Object containing transaction details
transaction	string	The unique identifier of transaction (e.g: used to avoid duplicate bets and other validations) * transaction.id will contain a transaction ID which needs to be canceled. Example: debit was made with transaction.id = abc12345 cancel request will contain transaction.id = abc12345 Note on expected behavior: transaction amount should not be taken when processing cancel, it could be used for additional validation only. Cancelation should be executed using transaction.id only.
transaction.refId	string	Reference identifier for transaction, to be able to link (correlate) and/or validate credit/cancel requests to appropriate debit request
transaction.amount	decimal	Amount of transaction, rounded to 2 decimal Symbols
uuid	string	Unique request id, that identifies CancelRequest
2.3 One Wallet API response parameters
Response	Attribute	Type	
Attribute description
CheckUserResponse	status	string	Describes status of request.
- One of the "status" enumerated value
- If response header is not HTTP 200, it is mapped to TEMPORARY_ERROR If response cannot be parsed, it is mapped to TEMPORARY_ERROR
- Any values that are not in the list are mapped to UNKNOWN_ERROR
sid	string	Player's session ID which will be used in all further API service calls.
- If null, then one that is passed in UserAuthentication call will be used for all further calls.
- If empty, empty value
uuid	string	Unique response id, that identifies
CheckUserResponse
StandardResponse	status	string	Describes status of request.
- One of the "status" enumerated values
- If response header is not HTTP 200, it is mapped to TEMPORARY_ERROR
- If response cannot be parsed, it is mapped to TEMPORARY_ERROR
- Any values that are not in the list are mapped to UNKNOWN_ERROR
balance	decimal	Player's balance value (real money, excluding bonus). Should be filled out with player's balance, however can be empty in the following cases:
A) as a response to requests other than BalanceRequest if the licensee cannot reasonably obtain an accurate user balance in response to the request,
B) in case balance cannot be obtained due to error/ failed action. Balance returned should have a precision of 2 decimal digits. EVO does not round returned value, only uses 2 decimal values.
retransmission	boolean	"true" if response is a retransmission of original response (e.g if request is retried due to network failure and an original response needs to be received with "retransmission" = true). In all other cases this should be 'false' or not included in response completely.
- Optional field
uuid	string	Unique response id, that identifies
StandardResponse
2.3.1 One Wallet API Status Type
Statuses and Error messages
These are error codes and messages that user get on game UI; all errors are related to statuses listed in Status Types

Status	Error Message Description	System Behavior
TEMPORARY_ERROR	Error Message: There is a temporary problem with the game serverError Code: 1001	Players bet rejectedPlayer receive toast message with an information about temporary problem with the game serverPlayer remain in the game
INVALID_TOKEN_ID	Error Message: Your session has expired. Please log in againError Code: 10003	Player’s bet rejectedPlayer receive popup messageClicks OK buttonPlayer get black error screen with message “There has been a problem with the Live Casino. User authentication failed or your session may be expired, please close the browser and try again. Error Code: EV01”Player required to launch games again
INVALID_SID	Error Message: Your session has expired. Please log in againError Code: 10003	Player’s bet rejectedPlayer receive popup messageClicks OK buttonPlayer get black error screen with message “There has been a problem with the Live Casino. User authentication failed or your session may be expired, please close the browser and try again. Error Code: EV01”Player required to launch games again
UNKNOWN_ERROR	Error Message: Please contact Customer Support for assistanceError Code: 1049	Player’s bet rejectedPlayer receive toast message to contact customer supportPlayer remain in the game
INVALID_PARAMETER	Error Message:Please contact Customer Support for assistanceError Code: 10002	Player’s bet rejectedPlayer receive toast message to contact customer supportPlayer remain in the game
BET_DOES_NOT_EXIST	Error Message: Please contact Customer Support for assistanceError Code: 10005	Player’s bet rejectedPlayer receive toast message to contact customer supportPlayer remain in the game
INSUFFICIENT_FUNDS	Error Message: You do not have sufficient funds to place this betError Code: 10008	Player’s bet rejectedPlayer receive toast message about insufficient fundsPlayer remain in the game
Status types
Enumerated values for status parameter in One Wallet API responses.

These are possible One Wallet response codes. Only codes with the type Retryable Error will be retried.

Status	Type	Message for player
OK	Success	
TEMPORARY_ERROR	Retryable Error	There is a temporary problem with the game server.
INVALID_TOKEN_ID	Fatal Error	There has been a problem with the casino. User authentication failed or your session may be expired, please close the browser and try again. Error Code: EV01
INVALID_SID	Fatal Error	There has been a problem with the casino. User authentication failed or your session may be expired, please close the browser and try again. Error Code: EV01
ACCOUNT_LOCKED	Fatal Error	There has been a problem with the casino. User authentication failed or your session may be expired, please close the browser and try again. Error Code: EV01
FATAL_ERROR_CLOSE_USER_SESSION	Fatal Error	There has been a problem with the casino. User authentication failed or your session may be expired, please close the browser and try again. Error Code: EV01
UNKNOWN_ERROR	Final Error	Please contact Customer Support for assistance.
INVALID_PARAMETER	Final Error	Please contact Customer Support for assistance.
BET_DOES_NOT_EXIST	Final Error	Please contact Customer Support for assistance.
BET_ALREADY_EXIST	Success	Bet already exists in third party system.
BET_ALREADY_SETTLED	Success	Bet has been already settled in third party system.
INSUFFICIENT_FUNDS	Final Error	You do not have sufficient funds to place this bet.
2.4 One Wallet API request/response examples
For all examples authentication token ("authToken" parameter) value is "s3cr3tV4lu3"

API method	
Check
Description	Should be used for additional validation of redirected user and sid.
URL	https://my.service.host.com/api/check?authToken=s3cr3tV4lu3
Request	CheckUserRequest
{
"sid":"sid-parameter-from-UserAuthentication-call",
"userId":"euID-parameter-from-UserAuthentication-call",
"channel":{
"type":"P"
},
"uuid":"ce186440-ed92-11e3-ac10-0800200c9a66"
}
Response	CheckUserResponse
{
"status":"OK",
"sid:"new-sid-to-be-used-for-api-calls-qwerty",
"uuid":"ce186440-ed92-11e3-ac10-0800200c9a66"
}
API method	Sid
Description	Should be used for additional validation of redirected user and sid.
URL	https://my.service.host.com/api/check?authToken=s3cr3tV4lu3
Request	CheckUserRequest
{
"sid":"sid-parameter-from-UserAuthentication-call",
"userId":"euID-parameter-from-UserAuthentication-call",
"channel":{
"type":"P"
},
"uuid":"ce186440-ed92-11e3-ac10-0800200c9a66"
}
Response	CheckUserResponse
{
"status":"OK",
"sid:"new-sid-to-be-used-for-api-calls-qwerty",
"uuid":"ce186440-ed92-11e3-ac10-0800200c9a66"
}
API method	Balance
Description	Used to get user's balance
URL	https://my.service.host.com/api/balance?authToken=s3cr3tV4lu3
Request	BalanceRequest (lobby, or table unknown)
{
"sid":"sid-parameter-from-UserAuthentication-call",
"userId":"euID-parameter-from-UserAuthentication-call",
"game": null,
"currency":"EUR",
"uuid":"ce186440-ed92-11e3-ac10-0800200c9a66"
}
BalanceRequest (from known table)
{
"sid":"sid-parameter-from-UserAuthentication-call",
"userId":"euID-parameter-from-UserAuthentication-call",
"game":{
"type":"blackjack",
"details" : {
"table" : {
"id" : "aaabbbcccdddeee111",
"vid" : "aaabbbcccdddeee111"
}
}
},
"currency":"EUR",
"uuid":"ce186440-ed92-11e3-ac10-0800200c9a66"
}
Response	StandardResponse
{
"status":"OK",
"balance":999.00,
"uuid":"ce186440-ed92-11e3-ac10-0800200c9a66"
}
API method	Debit
Description	Used to debit from account (place bets)
URL	https://my.service.host.com/api/debit?authToken=s3cr3tV4lu3
Request	DebitRequest
{
"sid":"sid-parameter-from-UserAuthentication-call",
"userId":"euID-parameter-from-UserAuthentication-call",
"currency":"EUR",
"game":{
"id":"7kfwqku4jb4mtas1n4k4irqa",
"type":"blackjack",
"details" : {
"table" : {
"id" : "aaabbbcccdddeee111",
"vid" : "aaabbbcccdddeee111"
}
}
},
"transaction":{
"id":"D9fb6f838-6b31-4c87-9c2e-2db90afd50e1",
"refId":"9fb6f838-6b31-4c87-9c2e-2db90afd50e1",
"amount":1.55
},
"uuid":"ce186440-ed92-11e3-ac10-0800200c9a66"
}
Response	StandardResponse
{
"status":"OK",
"balance":999.00,
"uuid":"ce186440-ed92-11e3-ac10-0800200c9a66"
}
API method	Credit
Description	Used to credit user's account (settle bets)
- "sid" validation should be optional or accept empty sids. This may be needed some cases:
- game result was corrupted and money need to be transferred to user
- when user logged out but game continues and settlement needs to be done even if user went offline
- other environmental issues (e.g service was down / network is down, etc)
URL	https://my.service.host.com/api/credit?authToken=s3cr3tV4lu3
Request	CreditRequest
Example (in case of win): CreditRequest {
"sid":"sid-parameter-from-UserAuthentication-call",
"userId":"euID-parameter-from-UserAuthentication-call",
"currency":"EUR",
"game":{
"id":"7kfwqku4jb4mtas1n4k4irqa",
"type":"blackjack",
"details" : {
"table" : {
"id" : "aaabbbcccdddeee111",
"vid" : "aaabbbcccdddeee111"
}
}
},
"transaction":{
"id":"C9fb6f838-6b31-4c87-9c2e-2db90afd50e1",
"refId":"14599fb6f838-6b31-4c87-9c2e-2db90afd50e1zzz",
"amount":1.55
},
"uuid":"ce186440-ed92-11e3-ac10-0800200c9a66"
}

Example (in case of loose): CreditRequest
{
"sid":"sid-parameter-from-UserAuthentication-call",
"userId":"euID-parameter-from-UserAuthentication-call",
"currency":"EUR",
"game":{
"id":"7kfwqku4jb4mtas1n4k4irqa",
"type":"blackjack",
"details" : {
"table" : {
"id" : "aaabbbcccdddeee111",
"vid" : "aaabbbcccdddeee111"
}
}
},
"transaction":{
"id":"C1459zzz",
"refId":"1459zzz",
"amount":0.00
},
"uuid":"ce186440-ed92-11e3-ac10-0800200c9a66"
}
Response	StandardResponse
{
"status":"OK",
"balance":999.00,
"uuid":"ce186440-ed92-11e3-ac10-0800200c9a66"
}

API method	Cancel
Description	Use to cancel bets (e.g late bet)
- "sid" validation should be optional or accept empty sids.This may be needed some cases:
- game result was corrupted and money need to be transferred to user;
- when user logged out but game continues and settlement needs to be done even if user went offline;
- other environmental issues (e.g service was down / network is down, etc)
URL	https://my.service.host.com/api/cancel?authToken=s3cr3tV4lu3
Request	CancelRequest
{
"sid":"sid-parameter-from-UserAuthentication-call",
"userId":"euID-parameter-from-UserAuthentication-call",
"currency":"EUR",
"game":{
"id":"7kfwqku4jb4mtas1n4k4irqa",
"type":"blackjack",
"details" : {
"table" : {
"id" : "aaabbbcccdddeee111",
"vid" : "aaabbbcccdddeee111"
}
}
},
"transaction":{
"id":"D9fb6f838-6b31-4c87-9c2e-2db90afd50e1",
"refId":"9fb6f838-6b31-4c87-9c2e-2db90afd50e1",
"amount":1.55
},
"uuid":"ce186440-ed92-11e3-ac10-0800200c9a66"
}
Response	StandardResponse
{
"status":"OK",
"balance":999.00,
"uuid":"ce186440-ed92-11e3-ac10-0800200c9a66"
}
2.5 One Wallet settlement types
A settlement type is a configurable option per integration. One Wallet settlement method is "Gamewise" and it's preferable to agree on the specific settlement types before the actual integration is started.

Game wise settlement:

It does not matter how many Debit request (transactions) are in the game round, there will be single Credit request at the end of the game, having aggregated amounts to be transferred to the users' wallet

Gamewise settlement type is best suit when Licensee would like track game round state (Licensees will know that game ended, when single aggregated Credit call is being issued)

It is expected that once a Credit request is accepted, the game (game round) becomes completely closed and any other further Credit request for the same game should not be accepted and should not
affect player's balance regardless if the second Credit request comes with the same transaction id or with the new one.

Note, if Debit requests are late for the game, there will be no Credit request issued for those, only Cancel request for each transaction.

Please refer to events flow description per each of types below :-

Case 1

Player loads BlackJack.
Places bet of 10, Evolution sends Debit call.
This call will have a transaction.id (e.g. "abc123") and a game.id ("def456").
Cards are dealt and player wins hand.
Evolution sends a Credit call for 20.
The request will have different transaction.id (e.g. "abc789").
The game.id will be the same ("def456").
The transaction will contain a transaction.refid to original transaction id of "abc123".
Credit request will be unique if Evolution receives “OK” response (there will be no subsequent requests with particular transaction id).
If the response is not “OK” a retry mechanism might be applied, depending on the error code received in response.
Case 2

Player loads BlackJack.
Places bet of 10, Evolution sends Debit call.
This call will have a transaction.id (e.g."abc123") and a game.id ("def456").
Cards are dealt and player looses the hand.
Evolution sends a Credit call for 0.
The request will have different transaction.id (e.g. "abc789").
The game.id will be the same ("def456").
The transaction will contain a transaction.refid to original transaction.id of "abc123".
Credit request will be unique if Evolution receives “OK” response (there will be no subsequent requests with particular transaction.id).
If the response is not “OK” a retry mechanism might be applied, depending on the error code received in response.
Case 3

Player loads BlackJack.
Places bet of 10, Evolution sends Debit call
This call will have a transaction.id (e.g. "abc123") and a game.id ("def456").
Player is dealt a pair of 10s.
Player decides to split and therefore another 10 bet for which Evolution sends a second Debit.
The request will have different transaction.id (e.g. "abc789").
The game.id will be the same ("def456").
The transaction will not contain a transaction.refid to original transaction.id of "abc123".
Hands are played out and player wins both hands.
Evolution sends one Credit call for 40.
Evolution will send a single credit even though there were 2 debits as it is GAME WISE settlement type.
The request will have different transaction.id (e.g. “abc890”).
The game.id will be the same ("def456").
This transaction will contain transaction.refid of one of initial debit requests (transaction.refid of "abc123" or transaction.refid of "abc789").
2.6 One Wallet transaction re-try policy
Each call for a bet is assigned with a transaction identifier to maintain consistency and integrity of all financial transactions from-to One Wallet. As server-to-server requests may time out or respond with an error, transaction retry mechanism is being used to get the state of transaction (bet).

Request timeout value, number of retries and delays between each retry attempt is configurable in One Wallet. Default re-try configuration in OneWallet is: 5 retries with 1 min delay in between -> 10 retries with 5 min delay in between -> 24 retries with 10 min delay in between.
Retries are triggered when EVO fails to get a successful response from server and/or transaction state is not known.

Retries are processed in background and do not affect user experience and try to resolve status of transaction. Retries are persistent, therefore they are not lost and have their final state available (all failed or expired retries are stored in a FAILED or EXPIRED state). One Wallet provides a retry mechanism on following operations:

Debit
Following operations are not retried:

Balance
Check
General logic for retries:

retries are executed until Licensee service returns a response with status for transaction:

Debit retries

if Licensee responds with status "OK" or "BET_ALREADY_EXIST", a rollback will be requested (cancellation is executed to return the funds to the user, executed in background via retry cancel queue)

if Licensee responds with an error code for the bet, which is not recoverable (e.g "INSUFFICIENT_FUNDS" or "INVALID_TOKEN_ID"), One Wallet will assume that transaction didn't happen on Licensee side and cancellation will not be executed

Credit (or Cancel) retries:

if Licensee responds with status "OK" or "BET_ALREADY_EXIST", Credit retry will be considered as successful and retries will be stopped
if Licensee responds with an non-retryable error (e.g "ACCOUNT_LOCKED" or
"INVALID_TOKEN_ID"), retry will be considered as failed.
failed or expired retries will be updated with FAILED or EXPIRED state on EVO side and retry mechanism for the particular operation will stop. .

User Authentication
1 Overview
User Authentication API provides an interface which can be used to create new player and/or login existing player, create game session and launch the game.

1.1 Invocation details
Supported methods: POST
Response format: JSON
User Authentication 2.0 API service endpoint URL should never be revealed to the player and placed on Licensee website.
User authentication request must be posted in server- to-server mode.
User Authentication 2.0 API service endpoint URL must always use 'domain name' instead of IP address
User Authentication 2.0 API is served over HTTPS - to ensure security and data privacy, unencrypted HTTP is not supported
All IP addresses that need access to User Authentication 2.0 API must be white-listed in advance
1.2 Response codes and errors
User Authentication 2.0 API uses standard RFC 2616 HTTP response codes to indicate the success or failure of an API request:

Codes in the 2xx range indicate success

Codes in the 4xx range indicate a problem with the request

Codes in the 5xx range indicate an error with EVO's servers

2 User Authentication API service endpoint
https://{url}/ua/v1/{casino.key}/{api.token}
In order to launch game, Licensee has to send user authentication request to the service endpoint URL (see above). User authentication request body must be sent in JSON format using POST method. The default
behavior for a successful request is to redirect player to the game page based on the parameters provided in the request body. An authentication token string will be appended to the returned URL to identify the
player's session in EVO system. After receiving player's request for returned URL, EVO system will add the authentication token to a cookie, therefore player needs to ensure to have cookies enabled on his side.


URL parameters:
Name	
Description
Mandatory/ Optional
casino.key	Casino key for User Authentication service, provided by EVO	M
api.token	API token for User Authentication service, provided by EVO	M
hostname	Licensee hostname, provided by Licensee. Licensee must provide SSL(s) for hostname(s) of production game launch host(s). EVO installs SSL and provides CNAME to configure	M
User authentication request body must be sent in following format:
    {
        "uuid": "unique request identifier",
        "player": {
            "id": "a1a2a3a4",
            "update": true,
            "firstName": "firstName",
            "lastName": "lastName",
            "country": "DE",
            "nickname": "nickname",
            "language": "en",
            "currency": "EUR",
            "session": {
                "id": "111ssss3333rrrrr45555",
                "ip": "192.168.0.1"
            }
        },
        "config": {
            "game": {
                "category": "roulette",
                "interface": "view1",
                "table": {
                    "id": "vip-roulette-123"
                }
            },
            "channel": {
                "wrapped": false,
                "mobile": false
            }
        }
    }
3 User Authentication 2.0 API request parameters
Name	Data Type	Description	Mandatory/Optional
uuid	String	Unique request id, that identifies concrete user authentication request (attempt).	M
player	Object	Object containing player details.	M
player.id	String (50)	Player's ID. Unique identifier of a player, assigned by Licensee.	M
player.update	Boolean	Indicates if player details should be updated. True if system is asked to update player records. False if player data is relevant for current session only. Updates firstName, lastName, nickname, country, language values.	M
player.firstName	String (50)	Player's first name.	M
player.lastName	String (50)	Player's last name.	M
player.nickname	String (35)	Player's preferred nickname (screen name). If not passed then player will be prompted to enter nickname on first Live casino visit.	O
player.country	String (2)	Player's country code (ISO 3166, 2 letter code).	M
player.language	String (2)	Player's preferred language (ISO 639-1, 2 letter code).	M
player.currency	String (3)	Player's currency (ISO 4217, 3 letter code).	M
player.session	Object	Object containing player session details.	M
player.session.id	String (250)	Player's session ID, assigned by Licensee.	M
player.session.ip	String	Player's session IP address. Both IPv4 and IPv6 are acceptable formats.	M
config	Object	Object containing game launch configuration options.	M
config.game	Object	Object containing game launch configuration and direct table launch options.	O
config.game.category	String	Specifies game category what needs to be launched:
-game_shows
-baccarat_sicbo
-poker
-top_games
-roulette
-blackjack
-slots
(no respective category in Evolution lobby) The category is not used for direct game launch and only can be used for lobby category launch.	O
config.game.interface	String	Specifies the game interface version:
view1 - launch game in 3D view;
view2 - launch game in classic view;
MLR - launch game in mini live roulette view;
Slingshot - launch game in slingshot view (for auto-roulette only);
hd1 - roulette immersive view and used in CSP.
Must be used in conjunction with config.game.table object.	O
config.game.table	Object	Object containing table details for direct game launch.	O
config.game.table.id	String	Specifies table ID for the game table which needs to be launched. either table ID or virtual table ID has to be specified for direct table launch. Direct table launch of a virtual table must submit tables's virtual ID list of table ID's for generic tables for UAT and Live environments can be found in document "Integration manual". Virtual table IDs are different for each casino and should be requested separately each slot game is assigned a table ID that is to be used for slot game direct launch	M
config.channel	Object	Object containing game channel configuration options.	M
config.channel.wrapped	Boolean	Specifies if client is wrapped or standalone. Should only be sent as true for standalone native or mobile apps.	M
config.channel.mobile	Boolean	Specifies if game is launched using mobile device.	O

1.4 User Authentication API 2.0 response format

1.4.1 Successful response
In case of successful initialization call response, User Authentication 2.0 API will return HTTP status 200 and following response body:

{
   "entry": "/entry?params=c2l0ZT1fX2RlZmF1bHRfXwpnYW1lPWhvOPTNlYmQ5NWY1NWEwOTQyNmRiYmFjOTcxNmNiNzEw&JSESSIONID=3ebd95f55a09426dbbac9716cb7101a40c3a9a20", 
    "entryEmbedded": "/entry?params=c2l0ZT1fX2RlZmF1bHRfXwpnYW1lPWhvOPTNlYmQ5NWY1NWEwOTQyNmRiYmFjOTcxNmNiNzEw&JSESSIONID=3ebd95f55a09426dbbac9716cb7101a40c3a9a20&embedded"
}
Response attributes:
Name	Type	Description
entry	String	Contains the URL to be added to host name and used for user redirection
entryEmbedded	String	Contains the URL to be added to host name and used for user redirection
In order to create game launch URL for the player, returned entry or entryEmbedded attribute value should be combined with according host name:

https://<<hostname>><<entry>>
or
https://<<hostname>><<entryEmbedded>>
Please note that EVO keeps the right to change content and format of returned URLs in the values of parameters entry and entryEmbedded.


1.4.2 Failure response
In case of failure, User Authentication 2.0 API will return HTTP status 4XX or HTTP status 5XX and following response body:

{
"errors": [
    {
        "code": "G.0",
        "message": "Could not authenticate, please review sent data and try again. 
                    If problem persists, contact customer support "
    }
  ]
}

Response attributes:
Name	Type	
Description
errors	Array	Array of error objects that contain failure/error codes and optional message
code	String	Error code
message	String	Optional message of failure reason
1.5 User Authentication 2.0 API error handling
Error codes are classified into following categories:

G - generic failures
V - validation of input parameters failed

1.5.1 Generic failures
Code	Text	Description
G.0	Could not authenticate, please review sent data and try again. If problem persists, contact customer support	System error, should be retried, in case of constant occurrences should be reported to EVO.
G.1	Unknown casino $casinoKey	$casinoKey will be provided by EVO
G.2	Provided $apiToken for casino $casinoKey is incorrect	$apiToken will be provided by EVO
G.3	Player session creation is not configured for casino $casinoKey	$apiToken have not been configured on EVO side
G.4	Unable to issue token	System error, should be retried, in case of constant occurrences should be reported to EVO
G.5	Unable to authenticate user	System error, should be retried, in case of constant occurrences should be reported to EVO
G.6	Unable to create user	System error, should be retried, in case of constant occurrences should be reported to EVO
G.7	Unable to save player data	System error, should be retried, in case of constant occurrences should be reported to EVO
G.8	Unable to authenticate user due to: $status	Most likely client system returned invalid $status
G.9	Clients IP address have been rejected	Provided to EVO client IP address for white listing is incorrect.

1.5.2 Validation failures
Code	Text
V.1	player.update' is a boolean and accepts only true/false
V.2	firstName' length must be at least 1 character long
V.3	firstName' length must be no more than 50 characters
V.4	lastName' length must be at least 1 character long
V.5	lastName' length must be no more than 50 characters
V.6	nickname' length must be at least 2 characters long
V.7	nickname' length must be no more than 35 characters
V.8	player.session' is missing
V.9	player.session.ip' is not correct. Should be 0-255.0-255.0-255.0-255
V.10	player.session.id' is empty or missing
V.11	player.country' is missing
V.12	player.currency' is missing
V.13	player.language' is missing
V.16	uuid can't be empty
V.17	player' is empty or missing
V.18	config' is empty or missing
V.19	config.brand' is missing or empty
V.20	config.channel' is missing or empty
V.21	config.brand.id' is empty
V.22	config.brand.id' too long
V.23	config.brand.skin' is empty
V.24	config.brand.skin' too long
V.25	config.game.type' or 'config.game.category' must be defined
V.26	config.game.table.id' is missing or empty
V.27	config.channel.wrapped' is missing or empty
V.28	Provided 'config.game.type' is not supported
V.29	Provided 'config.urls.$urlType' is not valid. Should start with http://, https://, (see page 8) native://, app://
V.30	player.nickname' $nickname already exists
V.31	player.country' $country is not valid
V.32	player.currency' $currency is not valid
V.33	player.currency' $currency can not be updated for player from FT casino
V.34	Table with id $tableId does not exist
V.35	player.firstName' is missing
V.36	player.lastName' is missing
V.37	config.brand.id' must be a string
V.38	config.brand.skin' must be a string
V.39	config.game.category' does not exist
V.40	config.channel.mobile' is not boolean
V.41	player.id' is missing
V.42	player.nickname' is missing - does`t present now

Funds Transfer Integration

2.Overview
For Funds Transfer integration EVO system does not access the player's wallet in the Licensee's system. A new wallet is created in EVO system and the eCashier interface must be used by the Licensee
to transfer money between the player's wallet in the Licensee system and the player's wallet in the EVO system. Game transactions are performed against the new wallet and recorded only in the EVO system.
Reports are available to the Licensee via EVO Back Office.

2.1 eCashier API
Requests to eCashier API must be sent via HTTPS in the format below:

https://<hostname>/api/ecashier?cCode=[value]&[param1]=[value1]&[param2]=[value2]&...&[param(n)]=[value(n)]
The eCashier API response of the can be a delimited string or an XML, depending on the parameters set in request. Always use domain name instead of IP addresses in the URL above

2.2 eCashier API methods
eCashier API provides several methods to be used by the Licensee to manage funds transfer between the player's wallet in the Licensee's system and the player's wallet in the EVO system.

2.2.1 Retrieve Withdrawal Available (RWA)
Retrieve the player's balance on EVO system that is available for withdrawal.

Request example

Method	
URL
GET	https://<hostname>/api/ecashier?cCode=RWA&ecID=9v30eegd1pek63755p8dpleuuxy24h3b&euID=poker1@test.com&output=1
Response example

<userbalance>
<result>Y</result>
<euid>extUser123</euid>
<uid>user123</uid>
<tbalance>25.1354</tbalance>
<abalance>25.1354</abalance>
</userbalance>

<?xml version="1.0" ?>
<!ELEMENT userbalance (result,euid,uid,tbalance, abalance,errormsg)>
<!ELEMENT result (#PCDATA)>
<!ELEMENT euid (#PCDATA)>
<!ELEMENT uid (#PCDATA)>
<!ELEMENT tbalance (#PCDATA)>
<!ELEMENT abalance (#PCDATA)>
<!ELEMENT errormsg (#PCDATA)>

2.2.2 External Credit Request (ECR)
Create a credit transaction against the player's wallet in EVO system. This request shall be used to transfer money from the player's wallet in the Licensee's system to the player's wallet in the EVO system.
If createuser=Y parameter is specified in ECR request, new user will be created in EVO system.


Request example

Method	
URL
GET	https://<hostname>/api/ecashier?cCode=ECR&ecID=9v30eegd1pek63755p8dpleuuxy24h3b&euID=poker1@test.com&amount=10&eTransID=1234567890123456&createuser=Y&output=1

Response example

<transfer>
<result>Y</result>
<balance>25.1354</balance >
<etransid>123abc</etransid>
<transid>456def</transid>
<datetime>Mon Feb 5 11:11:11 GMT 2018</datetime>
<euid>extUser123</euid>
<uid>user123</uid>
</transfer>

<?xml version="1.0"?>
<!ELEMENT transfer (result,errormsg,balance,etransid,transid,datetime,euid,uid)>
<!ELEMENT errormsg (#PCDATA)>
<!ELEMENT balance (#PCDATA)>
<!ELEMENT etransid (#PCDATA)>
<!ELEMENT transid (#PCDATA)>
<!ELEMENT datetime (#PCDATA)>
<!ELEMENT euid (#PCDATA)>
<!ELEMENT uid (#PCDATA)>
<!ELEMENT result (#PCDATA)>

2.2.3 External Debit Request (EDB)
Create a debit transaction against the player's wallet in EVO system. This request shall be used to transfer money from player's wallet in the EVO system to the player's wallet in the Licensee's system.


Request example

Method	
URL
GET	https:/<hostname>/api/ecashier?cCode=EDB&ecID=9v30eegd1pek63755p8dpleuuxy24h3b&euID=poker1@test.com&amount=10&eTransID=1234567890123456&output=1

Response example

<transfer>
<result>Y</result>
<balance>25.1354</balance >
<etransid>123abc</etransid>
<transid>456def</transid>
<datetime>Mon Feb 5 11:11:11 GMT 2018</datetime>
<euid>extUser123</euid>
<uid>user123</uid>
</transfer>

<?xml version="1.0"?>
<!ELEMENT transfer (result,errormsg,balance,etransid,transid,datetime,euid,uid)>
<!ELEMENT errormsg (#PCDATA)>
<!ELEMENT balance (#PCDATA)>
<!ELEMENT etransid (#PCDATA)>
<!ELEMENT transid (#PCDATA)>
<!ELEMENT datetime (#PCDATA)>
<!ELEMENT euid (#PCDATA)>
<!ELEMENT uid (#PCDATA)>
<!ELEMENT result (#PCDATA)>

2.2.4 Retrieve Player's info (GUI)
Retrieve the player's info.


Request example

Method	
URL
GET	https://<hostname>/api/ecashier?cCode=GUI&ecID=9v30eegd1pek63755p8dpleuuxy24h3b&euID=poker1@test.com&output=1

Response example

<userdetails>
<emailaddress>john@company.com</emailaddress>
<firstname>John</firstname>
<lastname>Doe</lastname>
<screenname>EVO</screenname>
<countrycode>UK</countrycode>
<uid>user123</uid>
<euid>extUser123</euid>
</userdetails>

<?xml version="1.0" ?>
<!ELEMENT userdetails>
<!ELEMENT emailaddress #PCDATA)>
<!ELEMENT firstname (#PCDATA)>
<!ELEMENT lastname (#PCDATA)>
<!ELEMENT screenname (#PCDATA)>
<!ELEMENT countrycode (#PCDATA)>
<!ELEMENT uid (#PCDATA)>
<!ELEMENT euid(#PCDATA)>

2.2.5 Retrieve Transaction info (TRI)
Retrieve the transaction's info. This request shall be used to query the status of transaction.

tcheck parameter must be set 'Y' for ECR/EDB transactions which will be further queried by TRI

Please note that field will be empty for transactions which were completed before 2018-04-17

TRI historical data availability is up to 3 month prior to the current date


Request example

Method	
URL
GET	https://<hostname>/api/ecashier? cCode=TRI&ecID=9v30eegd1pek63755p8dpleuuxy24h3b&euID=poker1@test.com&output=1&eTransI D=licenseeTransaction345

Response example

<transaction>
<result>Y</result>
<balance>1483.3354</balance> // balance after transaction completion
<etransid>licenseeTransaction345</etransid>
<transid>EVOTransaction123</transid>
<datetime>Mon Feb 26 11:10:12 GMT 2018</datetime>
<datetime-iso>2018-02-26T11:10:12.123Z</datetime-iso>
<uID>user123</uID>
<euID>extUser123</euID>
<cCode>ECR</cCode>
<amount>133.1354</amount>
</transaction>

<?xml version="1.0" ?>
<!ELEMENT transaction>
<!ELEMENT result#PCDATA)>
<!ELEMENT balance(#PCDATA)>
<!ELEMENT etransid(#PCDATA)>
<!ELEMENT transid(#PCDATA)>
<!ELEMENT datetime(#PCDATA)>
<!ELEMENT datetime-iso(#PCDATA)>
<!ELEMENT uID(#PCDATA)>
<!ELEMENT euID(#PCDATA)>
<!ELEMENT cCode(#PCDATA)>
<!ELEMENT amount(#PCDATA)>

2.3 Common data types
All request/response parameters are case sensitive


2.3.1 Request parameters
Name	Type/Length	Description	Mandatory/Optional (per request type)
cCode	String (3)	Request code, possible values: RWA = retrieve balance
ECR = credit request EDB = debit request GUI = player's info TRI = retrieve transaction info	RWA - Mandatory
ECR - Mandatory
EDB - Mandatory
TRI - Mandatory
amount	String	Transaction amount Greater than 0 (e.g. 9999.9911)	RWA - N/A
ECR - Mandatory
EDB - Mandatory
TRI - N/A
currency	String(3)	Currency code (ISO 4217 3 letter code)	RWA - N/A
ECR - Optional
EDB - N/A
TRI - N/A
ecID	String (32)	Licensee's system ID, assigned by EVO	RWA - Mandatory
ECR - Mandatory
EDB - Mandatory
TRI - Mandatory
eTransID	String (16)	Transaction ID, assigned by Licensee	RWA - N/A
ECR - Mandatory
EDB - Mandatory
TRI - Mandatory
euID	String (16)	External Player's ID, assigned by Licensee Either uID or euID parameter is required,
otherwise user will not be found and error 144 will be returned	RWA - Mandatory
ECR - Mandatory
EDB - Mandatory
TRI - Optional
output	String (1)	Output format (default = 1), possible values: 0 = delimited string 1 = XML	RWA - Mandatory
ECR - Mandatory
EDB - Mandatory
createuser	String(1)	Specifies if new user should be created in EVO system.
Possible value: 'Y'. Following conditions has to be met in order
to successfully create a new user with ECR request: create user flag
is specified [createuser=Y] command type is ECR [cCode=ECR]
currency parameter contains valid currency code [currency=USD]
(in case of missing currency parameter default casino currency will be applied)
external player id is specified [euID=] If any of the above conditions will not be met,
eCashier API will respond with
"Invalid user" error message. If createuser=Y flag is specified but user already
exists in EVO system,
ECR call will be successfully processed and no error message will be returned.	



RWA - N/A
ECR - Optional
EDB - N/A
TRI - N/A

2.3.2 Response parameters
Name	Type/Length	
Description
Mandatory/Optional (per request type)
result	String (1)	Result, possible values: Y = successful N = unsuccessful	RWA - Mandatory
ECR - Mandatory
EDB - Mandatory
TRI - Mandatory
abalance	Integer	Player's available balance (not including bonus) Greater than 0 (e.g. 9999.9911)	RWA - Mandatory
ECR - N/A
EDB - N/A
TRI - N/A
balance	Integer	Player's total balance (including bonus) Greater than 0 (e.g. 9999.9911)
For TRI response - balance after transaction was completed	RWA - N/A
ECR - Mandatory
EDB - Mandatory
TRI - Mandatory
datetime	String	Transaction timestamp, assigned by EVO
e.g. Mon Feb 5 11:11:11 GMT 2018	RWA - N/A
ECR - Mandatory
EDB - Mandatory
TRI - Mandatory
datetime-iso	String	Transaction timestamp in ISO 8601, assigned by EVO
e.g. 2018-02- 26T11:10:12.123Z	RWA - N/A
ECR - N/A EDB - N/A
TRI - Mandatory
errormsg	String	Error response, assigned by EVO	RWA - Optional
ECR - Optional
EDB - Optional
TRI - Optional
etransid	String (16)	External Transaction ID, assigned by Licensee	RWA - N/A
ECR - Mandatory
EDB - Mandatory
TRI - Mandatory
euid	String (16)	External Player's ID, assigned by Licensee Either uID or euID will be in output,
depending on what parameters were sent as input.	RWA - Optional
ECR - Optional
EDB - Optional
TRI - Optional
tbalance	Integer	Player's total balance (including bonus) Greater than 0 (e.g. 9999.9911)	RWA - Mandatory
ECR - N/A
EDB - N/A
TRI - N/A
tcheck	String (1)	Check eTransID uniqueness, possible values: Y = successful N = unsuccessful	RWA - N/A
ECR - Optional
EDB - Optional
TRI - N/A
transid	String	Transaction ID, assigned by EVO	RWA - N/A
ECR - Optional
EDB - Mandatory
TRI - Mandatory
uid	String (16)	Player's ID, assigned by EVO Either uID or euID will be in output,
depending on what parameters were sent as input.	RWA - Optional
ECR - Optional
EDB - Optional
TRI - Optional
amount	String	Transaction amount Greater than 0 (e.g. 9999.9911)	RWA - N/A
ECR - N/A
EDB - N/A
TRI - Mandatory
2.3.3 Error handling
In case of failure, eCashier API will return HTTP status 4XX or HTTP status 5XX and following response body:

RWA

<userbalance>
<result>N</result>
<errormsg>{Error message}</errormsg>
</userbalance>
EDB, ECR

<transfer>
<result>N</result>
<errormsg>{Error message}</errormsg>
</transfer>
GUI, TRI

<error>
<result>N</result>
<errormsg>{Error message}</errormsg>
</error>

Errors can be classified into two categories:

General errors

Transfer request specific errors

Error type	
Error message
General error	Invalid output
Invalid request
Invalid user
Invalid casino
Transfer request specific errors	Amount not specified
Invalid amount
eTransID is not specified
Transaction id already processed: $etransid
Insufficient funds: $playerBalance
Transaction info request specific error	Transaction is not found for id: $etransid

1.1 Security
 

1.1.1 Basics
All communication between EVO servers and Licensee servers must be performed via encrypted channels using HTTPS protocol. Plain connections are not accepted.

1.1.2 Authentication
Requests to the Game History API are protected with HTTP Basic authentication (RFC 2617 - IETF) over HTTPS. Existing UserAuthentication 2.0 account casino.key and Game History apiToken have to be sent in the Authorization header as username and password, respectively.

Example:

    Authorization: Basic dGVzdC1jYXNpbm8ua2V5OnRlc3QtYXBpVG9rZW4=
This header carries Base64-encoded pair of test-casino.key:test-apiToken as username:password

Response codes

If client omits aforementioned authentication header or provided values are not valid, the request is rejected with appropriate HTTP response code: 401 Unauthorized

1.2 Base URI
All URLs referenced in this documentation have the following base URI:

    https://«licensee_hostname»/api/gamehistory/v1
Report type	Method	Protocol	URL
Retrieve game details for a casino within specified date range	GET	https	/casino/games
1.3 Retrieve game details for a casino within specified date range ( /casino/games )
"/casino/games" resource URI has following limitations:

Reporting period is restricted to 24 hours maximum. StartDate and endDate parameters can be used to specify period which is less than 24 hours.

Service can be periodically invoked to retrieve new game rounds information by specifying query parameter startDate=time_of_last_invocation - 5 minutes (without specifying endDate).

API responses in subsequent invocations may contain data entries already present in previous invocations (duplicates) and it is up to the licensee to handle such entries accordingly.

Values of wager and payout are converted to default casino currency according to currency rates known to EVO at the time when game snapshot was generated.

In cases where the player has multiple sessions during the game round (for example, if user disconnected and reconnected while game round was in progress), sessionId and casinoSessionId fields will contain values from one of the sessions of the round.

There might be duplicated game result due to the limitation of the system. Consumer need to make sure to check on duplication on their end.

Request example:

Method	URL
GET	/casino/games?startDate=2017-01-23T10:02:59.117Z
 

Resource properties

Property	Description
date	The specified date for report, (date only, no time)
games	Array of game rounds
games.id	The unique game round identifier. Correlates with game.id reported in One Wallet calls if playerGameId is not populated
games.startedAt	The date and time when game round started
games.settledAt	The date and time when game round settled
games.status	Game round status (Resolved/Cancelled)
games.gameType	The game type value for particular table
games.gameSubType	The game subtype value for particular table
games.table	Table details
games.table.id	The unique (internal) Table identifier
games.table.name	The entity name for particular table
games.dealer	Dealer details
games.dealer.uid	The unique (internal) dealer identifier
games.dealer.name	Dealer’s name
games.currency	Default casino currency
games.wager	The sum of players total bet amount in particular game round
games.payout	The sum of players total withdrawal amount in particular game round including winning bets
games.participants	Provides details of every player who participated in particular game round
games.participants.casinoId	Casino unique identifier, assigned by Evolution
games.participants.playerGameId	Unique per player per game (single game round) identifier. If populated, correlates with game.id reported in One Wallet calls
games.participants.playerId	Unique external (assigned by Licensee) user ID
games.participants.screenName	Player’s alias (nickname)
games.participants.sessionId	Player’s session ID, assigned by Evolution
games.participants.casinoSessionId	Player’s session ID, assigned by Licensee
games.participants.channel	Player channel: desktopmobileother
games.participants.device	Player’s device, optional. Sample values: PC, Mac, Generic iPhone, Galaxy S9 Plus, …
games.participants.os	Player’s operating system, optional. Sample values: Generic Linux, Windows 10 x86-64, iOS 12, …
games.participants.currency	Currency code (ISO 4217 3 letter code)
games.participants.betCoverage.simple	Represents probability to win for a specific player. Values in range [0, 1] applicable to all Roulette types except Double Ball Roulette
games.participants.bets	Array of player bet details
games.participants.bets.code	Game specific bet code (internal, but in Evo commonly known as external bet code identifier)
games.participants.bets.stake	The bet amount what player placed in particular game round
games.participants.bets.payout	The withdrawal amount what player received in particular game round including winning bet
games.participants.bets.placedOn	The date and time when bet was accepted
games.participants.bets.description	Human-readable bet description (no longer supported return empty/null value)
games.participants.bets.transactionId	The unique identifier of external transaction: Games (e.g. Roulette and Baccarat) where all bets has to be placed in the begining of the game round are using same external transactionId for each player stake. Games (e.g. Blackjack and Poker) which allow bets to be placed at different stages of the game round are using different external transactionId for each player stake depending on the stage of the game round.
games.participants.bets.owTransactionId	One Wallet adapter specific withdrawal transaction identifier. Applicable if supported by integration adapter
games.participants.jackpot	Array of jackpot contributions and payouts. Optional, absent if empty. See Jackpots section for details
games.participants.rewardBets	Array of player bet details for reward games
games.participants.playMode	Play mode for the player. If other than RealMoney, bets will be in rewardBets array
games.participants.mathId	Optional math model identifier used for connecting/comparing theoretical and empirical game statistic calculations
games.participants.configOverlays	Array of configuration overlay id’s (internal)
games.participants.brandId	Brand ID, assigned by Licensee
games.participants.skinId	Skin ID, assigned by Evolution Sample for SkinId and BrandId
games.participants.aamsParticipationId	AAMS Participation Id. Applicable for AAMS-regulated games
games.participants.aamsSessionId	AAMS Session Id. Applicable for AAMS-regulated games
games.participants.seats	Player results on one or more seats (including split seats and bet behind - not including decisions because these belong to seats/pure game) applicable for BlackJack
games.participants.decision	Peek Baccarat: Player decision details, applicable for Peek Baccarat. Populated if player increased the initial bet
games.participants.decision.decidedAt	Peek Baccarat: Time when player increased the bet
games.participants.decision.decisionType	Peek Baccarat: Value indicating how bet was increased and for which hand (Player or Banker). Possible values: DoublePlayer, TriplePlayer, DoubleBanker, TripleBanker
games.participants.decisions	Player decisions during the game round, applicable for Poker games
games.participants.hands	Player decisions and results for Scalable Blackjack, FreeBet Blackjack, Scalable Lightning Blackjack
games.participants.freebet	Player decision for free bet. Applicable for FreeBet Blackjack
games.participants.appliedMultiplier	Scalable Lightning Blackjack, Multiplier applicable in the game round
games.participants.appliedMultiplier.value	The value of the applied multiplier previously won
games.participants.appliedMultiplier.prevGameId	The game ID for the round when a multiplier was won
games.participants.appliedMultiplier.acquiredAt	Time when a player won the applied multiplier
games.participants.appliedMultiplier.previousFee	Main bet amount (Main + LightningMain) in a player’s currency of the game when the multiplier was won
games.participants.appliedMultiplier.currentFee	Current game main bet amount (Main + LightningMain) in a player’s currency
games.participants.acquiredMultiplier	Scalable Lightning Blackjack, a multiplier won in the current game round to be applied in the next game the player participates (if not expired)
games.participants.sideBetPlayerPair	Result for Baccarat Player Pair bonus side-bet
games.participants.sideBetBankerPair	Result for Baccarat Banker Pair bonus side-bet
games.participants.sideBetPerfectPair	Result for Baccarat Perfect Pair bonus side-bet
games.participants.sideBetEitherPair	Result for Baccarat Either Pair bonus side-bet
games.participants.sideBetPlayerBonus	Result for Baccarat Player Bonus bonus side-bet
games.participants.sideBetBankerBonus	Result for Baccarat Banker Bonus bonus side-bet
games.participants.sideBetSuperSix	Result for Baccarat Super 6 bonus side-bet
games.participants.sideBetPerfectPair	Result for Blackjack Perfect Pair bonus side-bet
games.participants.sideBet21p3	Result for Blackjack 21+3 bonus side-bet
games.participants.sideBetAnyPair	Result for Blackjack Any Pair bonus side-bet
games.participants.sideBetAABonus	Result for Casino Holdem Bonus side-bet
games.participants.sideBet5p1	Result for Caribbean Stud Poker 5+1 bonus side-bet
games.participants.sideBetPairPlus	Result for Three Card Poker Pair Plus bonus side-bet
games.participants.sideBet6CardBonus	Result for Three Card Poker 6 Card bonus side-bet
games.participants.sideBetPairOrBetter	Result for Triple Card Poker Pair or Better bonus side-bet
games.participants.sideBet3p3	Result for Triple Card Poker 3+3 bonus side-bet
games.participants.sideBetTrips	Result for Ultimate Texas Holdem Trips bonus side-bet
games.participants.sideBetBestFive	Result for Extreme Texas Holdem Best Five bonus side-bet
games.participants.sideBetBonus	Result for Texas Holdem Bonus side-bet
games.participants.sideBetJackpot	Result for Jackpot side-bet. Applicable for Casino Holdem Poker, Caribbean Stud Poker, Texas Holdem Bonus
games.participants.suitedTie	Result for Dragon Tiger suited tie bet
games.participants.qualificationSpin	Result for Deal Or No Deal qualification spin
games.participants.qualifiedAt	Date and time when Deal Or No Deal player passed qualification, optional
games.participants.boxes	Deal Or No Deal box contents
games.participants.topUpSpins	Results for Deal Or No Deal top-up spins
games.participants.offers	Results and decisions for Deal Or No Deal offers
games.participants.useNewBetCodes	Type of bet codes for Mega Ball. true means card count-based codes, false or absent means bet code per card
games.participants.betStakePerCard	Stake per Mega Ball card
games.participants.cardsCount	Number of drawn Mega Ball cards
games.participants.cards	Results for drawn Mega Ball cards
games.participants.totalMultiplier	Winnings amount multiplier in Crazy Time
games.participants.bonus	Bonus received by participant in Crazy Time
games.participants.bonus.type	Bonus type received in Crazy Time
games.participants.bonus.row	Bonus shot made to this row by participant in Crazy Time for bonus type CashHunt
games.participants.bonus.column	Bonus shot made to this column by participant in Crazy Time for bonus type CashHunt
games.participants.bonus.auto	This field indicated whether participant made decision where to shoot in Crazy Time for bonus type CashHunt, CrazyBonus
games.participants.bonus.decidedAt	Here is recorded timestamp when participant made decision in Crazy Time for bonus type CashHunt, CrazyBonus
games.participants.bonus.flapper	Flapper chosen by participant in Crazy Time for bonus type Crazy
games.participants.bonus.flapper.type	Flapper type in Crazy Time for bonus type Crazy
games.participants.bonus.flapper.color	Flapper color in Crazy Time for bonus type Crazy
games.participants.leftOnRoll	Craps: if a player leaves early, roll ID on which the player left
games.participants.picks	Gonzo: array of player picks
games.participants.picks.requested	Gonzo: picks count player bought
games.participants.picks.utilized.position	Gonzo: pick position (square on the wall player picked)
games.participants.picks.utilized.position.row	Gonzo: picked square row
games.participants.picks.utilized.position.column	Gonzo: picked square column
games.participants.picks.utilized.auto	Gonzo: mark if pick was done automatically or manually (automatically if true)
games.participants.picks.utilized.win	Gonzo: mark if pick was successful (player found the square he placed a bet on)
games.participants.multipliers	Gonzo: Array of all multipliers won by player grouped by bet code
games.participants.gameSteps	Cash Or Crash: array of game steps that player performed during a game round
games.participants.gameSteps.type	Cash Or Crash: game step type. Possible values: Decision (decision is offered), BaseGameStep (decision was not offered after a drawn ball)
games.participants.gameSteps.autoContinue	Cash Or Crash: true if player moves automatically one paytable level higher without decision offer (will be provided only if gameSteps type is BaseGameStep)
games.participants.gameSteps.potentialWin	Cash Or Crash: amount of money that is possible to win (will be provided only if player’s decisionType was Continue or TakeHalf)
games.participants.gameSteps.proposedAt	Cash Or Crash: time, when the decision offer was proposed
games.participants.gameSteps.decidedAt	Cash Or Crash: time, when player made his decision or decision offer end time if player did not press anything and decision was done automatically
games.participants.gameSteps.auto	Cash Or Crash: true if the decision was done automatically (player didn’t make his decision on time), false if the decision was done manually (by a player)
games.participants.gameSteps.totalWin	Cash Or Crash: amount of money won in the step and guaranteed for a player at the end of the game round (will be provided only if player’s decisionType was TakeHalf or Stop)
games.participants.gameSteps.decisionType	Cash Or Crash: type of decision, if the decision is offered (will be provided only if gameSteps.type is Decision). Possible values: Continue, TakeHalf, Stop
games.participants.qualificationSpin	Crazy Coin Flip: Player qualification (slot) spin
games.participants.qualificationSpin.spinMode	Crazy Coin Flip: Player qualification (slot) spin mode (Normal, XXXtream or SuperXXXtream)
games.participants.qualificationSpin.betMultiplier	Crazy Coin Flip: Player qualification (slot) bet multiplier. XXXtream or SuperXXXtream spins pay more, meaning the initial bet amount is multiplied a set number of times
games.participants.qualificationSpin.initialStake	Crazy Coin Flip: Player qualification (slot) initial bet amount with no bet multiplier applied
games.participants.qualificationSpin.screenReels	Crazy Coin Flip: RNG generated symbols and their positions on slot reels. Represented as array of columns
games.participants.qualificationSpin.winLines	Crazy Coin Flip: Slot win lines. Represented as array of single win line
games.participants.qualificationSpin.winLines.number	Crazy Coin Flip: Current win line number per math file
games.participants.qualificationSpin.winLines.symbolId	Crazy Coin Flip: Current win line symbol id
games.participants.qualificationSpin.winLines.length	Crazy Coin Flip: Current win line length. 3, 4 or 5 symbols in a row starting from left
games.participants.qualificationSpin.winLines.winCombination	Crazy Coin Flip: Current win line symbols positions. Represented as array of columns of 0 and 1, where 1 means win line symbol exists, 0 - some other symbol
games.participants.qualificationSpin.winLines.multiplier	Crazy Coin Flip: Current win line multiplier
games.participants.qualificationSpin.scatter	Crazy Coin Flip: Slot scatter symbols
games.participants.qualificationSpin.scatter.multipliers	Crazy Coin Flip: Slot scatter multipliers
games.participants.qualificationSpin.scatter.length	Crazy Coin Flip: Slot scatter combination length
games.participants.qualificationSpin.scatter.totalMultiplier	Crazy Coin Flip: Sum of slot scatter multipliers
games.participants.qualificationSpin.scatter.symbolId	Crazy Coin Flip: Slot scatter symbol ID
games.participants.qualificationResult	Crazy Coin Flip: Player activities in Coin Flip round. Empty if not qualified
games.participants.qualificationResult.gameRoundId	Crazy Coin Flip: Coin Flip bonus round ID player qualified in
games.participants.qualificationResult.qualifiedAt	Crazy Coin Flip: Timestamp representing the moment the game affirms the player qualification
games.participants.qualificationResult.topUp	Crazy Coin Flip: Player Top Up section
games.participants.qualificationResult.topUp.spins	Crazy Coin Flip: Player Top Up spins. Represented as array of single top up spins
games.participants.qualificationResult.topUp.spins.betMultiplier	Crazy Coin Flip: Current Top Up spin bet multiplier. Top Up bet can be increased only in multiples of the amount player qualified with and this also multiplies Top Up multipliers on the slot accordingly
games.participants.qualificationResult.topUp.spins.symbols	Crazy Coin Flip: Current Top Up spin result. Represented as array of three symbol ids
games.participants.qualificationResult.topUp.spins.totalMultiplier	Crazy Coin Flip: Current Top Up spin total multiplier. Empty in case of non winning combination
games.participants.qualificationResult.topUp.spins.totalMultiplier.value	Crazy Coin Flip: Current Top Up spin total multiplier numeric value
games.participants.qualificationResult.topUp.spins.totalMultiplier.side	Crazy Coin Flip: Coin side the multiplier applies on. Red or Blue
games.participants.qualificationResult.topUp.multipliers	Crazy Coin Flip: Sum of Top Up multipliers
games.participants.qualificationResult.topUp.multipliers.red	Crazy Coin Flip: Sum of Top Up multipliers for red coin side
games.participants.qualificationResult.topUp.multipliers.blue	Crazy Coin Flip: Sum of Top Up multipliers for blue coin side
games.participants.qualificationResult.skipGameRoundDecidedAt	Crazy Coin Flip: Timestamp representing the moment the player has made decision to skip Coin Flip round and proceed to next Top Up. Empty if no decision was made, can happen because this is not offered to all players, only to players who qualify when there is a set time left till next Coin Flip bonus round.
games.participants.qualificationResult.coinFinalMultipliers	Crazy Coin Flip: Calculated final multipliers for the particular player
games.participants.qualificationResult.coinFinalMultipliers.red	Crazy Coin Flip: Calculated final multipliers for red coin side for the particular player
games.participants.qualificationResult.coinFinalMultipliers.blue	Crazy Coin Flip: Calculated final multipliers for blue coin side for the particular player
games.participants.qualificationResult.coinWinMultiplier	Crazy Coin Flip: The final winning multiplier for the particular player. Depending on coin flip result
games.participants.balances	Gold Bar Roulette: Non real money balance
games.participants.balances.entryBalances	Gold Bar Roulette: describes player balance state before each game round in non real money units
games.participants.balances.entryBalances.type	Gold Bar Roulette: what non real money units player has on his balance (for Gold bar roulette always will be = “GoldBars”)
games.participants.balances.entryBalances.balance	Gold Bar Roulette: units count (gold bar count)
games.participants.balances.entryBalances.cashValue	Gold Bar Roulette: Each one unit value in real money
games.participants.balances.exitBalances	Gold Bar Roulette: Describes state after each game round
games.participants.balances.exitBalances.type	Gold Bar Roulette: what non real money units player has on his balance (for Gold bar roulette always will be = “GoldBars”)
games.participants.balances.exitBalances.balance	Gold Bar Roulette: units count (gold bar count)
games.participants.balances.exitBalances.cashValue	Gold Bar Roulette: Each one unit value in real money
games.participants.wonEquity	Gold Bar Roulette: won non real money unit
games.participants.wonEquity.type	Gold Bar Roulette: what non real money units player has on his balance (for Gold bar roulette always will be = “GoldBars”)
games.participants.wonEquity.amount	Gold Bar Roulette: units count (gold bar count)
games.participants.wonEquity.cashValue	Gold Bar Roulette: Each one unit value in real money
games.participants.bets.equityBet	Gold Bar Roulette: non real money bet
games.participants.bets.equityBet.type	Gold Bar Roulette: what non real money units player has on his balance (for Gold bar roulette always will be = “GoldBars”)
games.participants.bets.equityBet.stake	Gold Bar Roulette: monetary stake value of equity bet
games.participants.bets.equityBet.payout	Gold Bar Roulette: monetary payout of equity bet
games.participants.subType	Game subtype for this participant
games.result	Provides outputs from game(cards, balls, etc) and describes game outcome interpretation according to game rules, e.g., specifying winning side, providing totals, etc
JSON schema for /casino/games

{
    "$schema": "http://json-schema.org/draft-04/schema#",
    "properties": {
        "data": {
            "items": {
                "properties": {
                    "date": {
                        "description": "The date for game round, (date only, no time)",
                        "type": "string",
                        "example": "2017-01-03"
                    },
                    "games": {
                        "items": {
                            "properties": {
                                "currency": {
                                    "description": "Default casino currency",
                                    "type": "string",
                                    "example": "EUR"
                                },
                                "dealer": {
                                    "properties": {
                                        "name": {
                                            "description": "Dealer's name",
                                            "type": "string"
                                        },
                                        "uid": {
                                            "description": "The unique (internal) dealer identifier",
                                            "type": "string"
                                        }
                                    },
                                    "required": [
                                        "uid",
                                        "name"
                                    ],
                                    "type": "object"
                                },
                                "id": {
                                    "description": "The unique game round identifier",
                                    "type": "string"
                                },
                                "participants": {
                                    "items": {
                                        "properties": {
                                            "bets": {
                                                "items": {
                                                    "properties": {
                                                        "code": {
                                                            "description": "Game specific bet code 
                                                                            (internal)",
                                                            "type": "string"
                                                        },
                                                        "description": {
                                                            "description": "",
                                                            "type": "string"
                                                        },
                                                        "payout": {
                                                            "description": "The sum of players total 
                                                                            withdrawal amount in 
                                                                            particular game round",
                                                            "type": "decimal"
                                                        },
                                                        "placedOn": {
                                                            "description": "The date and time when bet 
                                                                            was placed",
                                                            "type": "string",
                                                            "example": "2017-02-08T13:07:40.222Z"
                                                        },
                                                        "stake": {
                                                            "description": "The bet amount what player 
                                                                            placed in particular game 
                                                                            round",
                                                            "type": "decimal"
                                                        },
                                                        "transactionId": {
                                                            "description": "The unique identifier of 
                                                                            external transaction",
                                                            "type": "string"
                                                        }
                                                    },
                                                    "required": [
                                                        "payout",
                                                        "code",
                                                        "description",
                                                        "stake",
                                                        "placedOn",
                                                        "transactionId"
                                                    ],
                                                    "type": "object"
                                                },
                                                "type": "array"
                                            },
                                            "casinoId": {
                                                "description": "Casino unique identifier, assigned by 
                                                                EVO",
                                                "type": "string",
                                                "example": "thebest00000000001"
                                            },
                                            "configOverlays": {
                                                "items": {
                                                    "description": "Array of configuration overlay id's 
                                                                   (internal)",
                                                    "type": "string"
                                                },
                                                "type": "array"
                                            },
                                            "currency": {
                                                "description": "Currency code (ISO 4217 3 letter 
                                                                code)",
                                                "type": "string",
                                                "example": "EUR"
                                            },
                                            "betCoverage": {
                                                "description": "Represents probability to win for a 
                                                                specific player. Values in range [ 0, 
                                                                1]. Applicable for all Roulette types 
                                                                except Double Ball Roulette",
                                                "type": "object"
                                            },
                                            "playerId": {
                                                "description": "Unique external (assigned by Licensee) 
                                                                user ID",
                                                "type": "string"
                                            },
                                            "screenName": {
                                                "description": "Player's alias (nickname)",
                                                "type": "string"
                                            },
                                            "sessionId": {
                                                "description": "Player's session ID, assigned by 
                                                                EVO",
                                                "type": "string"
                                            },
                                            "casinoSessionId": {
                                                "description": "Player's session ID, assigned by 
                                                                Licensee",
                                                "type": "string"
                                            },
                                            "sideBetBankerBonus": {
                                                "description": "Applicable only for Baccarat. Outcome 
                                                                of the side bet Banker Bonus",
                                                "type": "string",
                                                "enum": [
                                                    "Win",
                                                    "Lost"
                                                ]
                                            },
                                            "sideBetBankerPair": {
                                                "description": "Applicable only for Baccarat. Outcome 
                                                                of the side bet Banker Pair",
                                                "type": "string",
                                                "enum": [
                                                    "Win",
                                                    "Lost"
                                                ]
                                            },
                                            "sideBetEitherPair": {
                                                "description": "Applicable only for Baccarat. Outcome 
                                                               of the side bet Either Pair",
                                                "type": "string",
                                                "enum": [
                                                    "Win",
                                                    "Lost"
                                                ]
                                            },
                                            "sideBetPerfectPair": {
                                                "description": "Applicable only for Baccarat. Outcome 
                                                                of the side bet PerfectPair",
                                                "type": "string",
                                                "enum": [
                                                    "Win",
                                                    "Lost"
                                                ]
                                            },
                                            "sideBetPlayerBonus": {
                                                "description": "Applicable only for Baccarat. Outcome 
                                                                of the side bet Player Bonus",
                                                "type": "string",
                                                "enum": [
                                                    "Win",
                                                    "Lost"
                                                ]
                                            },
                                            "sideBetPlayerPair": {
                                                "description": "Applicable only for Baccarat. Outcome 
                                                                of the side bet Player Pair",
                                                "type": "string",
                                                "enum": [
                                                    "Win",
                                                    "Lost"
                                                ]
                                            },
                                            "sideBetSuperSix": {
                                                "description": "Applicable only for Baccarat. Outcome 
                                                                of the side bet Super 6",
                                                "type": "string",
                                                "enum": [
                                                    "Win",
                                                    "Lost"
                                                ]
                                            },
                                            "suitedTie": {
                                                "description": "Applicable only for DragonTiger. 
                                                                Outcome of the Suited Tie bet",
                                                "type": "string",
                                                "enum": [
                                                    "Win",
                                                    "Lose"
                                                ]
                                            },
                                            "seats": {
                                                "type": "object",
                                                "description": "Applicable only for BlackJack. Player 
                                                                results on one or more seats (including 
                                                                split seats and bet behind - not 
                                                                including decisions because these 
                                                                belong to seats/pure game)",
                                                "properties": {
                                                    "Seat_number": {
                                                        "properties": {
                                                            "betBehind": {
                                                                "description": " BJ Bet Behind bet",
                                                                "type": "boolean"
                                                            },
                                                            "doubleDown": {
                                                                "description": " BJ Double down bet",
                                                                "type": "boolean"
                                                            },
                                                            "insurance": {
                                                                "description": "BJ Insurance bet",
                                                                "type": "boolean"
                                                            },
                                                            "sideBetPerfectPair": {
                                                                "properties": {
                                                                    "betCode": {
                                                                        "description": "",
                                                                        "type": "string"
                                                                    },
                                                                    "result": {
                                                                        "description": "Outcome of the 
                                                                                        side bet.",
                                                                        "type": "string",
                                                                        "enum": [
                                                                            "Win",
                                                                            "Lost"
                                                                        ]
                                                                    }
                                                                },
                                                                "type": "object"
                                                            },
                                                            "splitHand": {
                                                                "description": "BJ Split hand",
                                                                "type": "boolean"
                                                            }
                                                        },
                                                        "type": "object"
                                                    }
                                                }
                                            },
                                            "sideBetAABonus": {
                                                "description": "Applicable only for Casino Holdem",
                                                "properties": {
                                                    "betCode": {
                                                        "description": "",
                                                        "type": "string"
                                                    },
                                                    "result": {
                                                        "description": "Outcome of the side bet",
                                                        "type": "string",
                                                        "enum": [
                                                            "Win",
                                                            "Lost"
                                                        ]
                                                    }
                                                },
                                                "type": "object"
                                            },
                                            "sideBet5p1": {
                                                "description": "Applicable only for Caribbean Stud 
                                                               Poker",
                                                "properties": {
                                                    "betCode": {
                                                        "description": "",
                                                        "type": "string"
                                                    },
                                                    "result": {
                                                        "description": "Outcome of the side bet",
                                                        "type": "string",
                                                        "enum": [
                                                            "Win",
                                                            "Lost"
                                                        ]
                                                    }
                                                },
                                                "type": "object"
                                            },
                                            "sideBetPairPlus": {
                                                "description": "Applicable only for Three Card Poker",
                                                "properties": {
                                                    "betCode": {
                                                        "description":  "",
                                                        "type": "string"
                                                    },
                                                    "result": {
                                                        "description": "Outcome of the side bet",
                                                        "type": "string",
                                                        "enum": [
                                                            "Win",
                                                            "Lost"
                                                        ]
                                                    }
                                                },
                                                "type": "object"
                                            },
                                            "sideBet6CardBonus": {
                                                "description": "Applicable only for Three Card Poker",
                                                "properties": {
                                                    "betCode": {
                                                        "description": "",
                                                        "type": "string"
                                                    },
                                                    "result": {
                                                        "description": "Outcome of the side bet",
                                                        "type": "string",
                                                        "enum": [
                                                            "Win",
                                                            "Lost"
                                                        ]
                                                    }
                                                },
                                                "type": "object"
                                            },
                                            "sideBetPairOrBetter": {
                                                "description": "Applicable only for Triple Card Poker",
                                                "properties": {
                                                    "betCode": {
                                                        "description": "",
                                                        "type": "string"
                                                    },
                                                    "result": {
                                                        "description": "Outcome of the side bet",
                                                        "type": "string",
                                                        "enum": [
                                                            "Win",
                                                            "Lost"
                                                        ]
                                                    }
                                                },
                                                "type": "object"
                                            },
                                            "sideBetTrips": {
                                                "description": "Applicable only for Ultimate Texas 
                                                                Holdem",
                                                "properties": {
                                                    "betCode": {
                                                        "description": "",
                                                        "type": "string"
                                                    },
                                                    "result": {
                                                        "description": "Outcome of the side bet",
                                                        "type": "string",
                                                        "enum": [
                                                            "Win",
                                                            "Lost"
                                                        ]
                                                    }
                                                },
                                                "type": "object"
                                            },
                                            "sideBetBestFive": {
                                                "description": "Applicable only for Extreme Texas 
                                                                Holdem",
                                                "properties": {
                                                    "betCode": {
                                                        "description":  "",
                                                        "type": "string"
                                                    },
                                                    "result": {
                                                        "description": "Outcome of the side bet",
                                                        "type": "string",
                                                        "enum": [
                                                            "Win",
                                                            "Lost"
                                                        ]
                                                    }
                                                },
                                                "type": "object"
                                            },
                                            "decisions": {
                                                "description": "Applicable only for Poker game",
                                                "items": {
                                                    "properties": {
                                                        "type": {
                                                            "description": "Decision type",
                                                            "type": "string",
                                                            "example": "Call"
                                                        }
                                                    },
                                                    "required": [
                                                        "type"
                                                    ],
                                                    "type": "object"
                                                },
                                                "type": "array"
                                            }
                                        },
                                        "required": [
                                            "bets",
                                            "casinoId",
                                            "playerId",
                                            "screenName",
                                            "currency",
                                            "sessionId",
                                            "casinoSessionId",
                                            "configOverlays"
                                        ],
                                        "type": "object"
                                    },
                                    "type": "array"
                                },
                                "payout": {
                                    "description": "The sum of players total withdrawal amount in 
                                                    particular game round",
                                    "type": "decimal"
                                },
                                "result": {
                                    "type": "object",
                                    "description": "Provides outputs from game(cards, balls, etc) and 
                                                    describes game outcome interpretation according to 
                                                    game rules, e.g., specifying winning side, 
                                                    providing totals, etc. Please see example outputs 
                                                    for each game type"
                                },
                                "settledAt": {
                                    "description": "The date and time when game round settled",
                                    "type": "string",
                                    "example": "2017-01-03T10:03:40.246Z"
                                },
                                "startedAt": {
                                    "description": "The date and time when game round started",
                                    "type": "string",
                                    "example": "2017-01-03T10:02:59.117Z"
                                },
                                "status": {
                                    "description": "Game round status",
                                    "type": "string",
                                    "enum": [
                                        "Resolved",
                                        "Cancelled"
                                    ]
                                },
                                "table": {
                                    "properties": {
                                        "id": {
                                            "description": "The unique (internal) Table identifier",
                                            "type": "string"
                                        },
                                        "name": {
                                            "description": "The entity name for particular table",
                                            "type": "string",
                                            "example": "Roulette VIP"
                                        }
                                    },
                                    "required": [
                                        "id",
                                        "name"
                                    ],
                                    "type": "object"
                                },
                                "gameType": {
                                    "description": "The game type value for particular table",
                                    "type": "string",
                                    "enum": [
                                        "roulette",
                                        "blackjack",
                                        "baccarat",
                                        "holdem",
                                        "uth",
                                        "eth",
                                        "csp",
                                        "tcp",
                                        "trp",
                                        "moneywheel",
                                        "americanroulette",
                                        "thb",
                                        "rng-roulette", "topcard",
                                        "dragontiger",
                                        "rng-blackjack"
                                    ]
                                },
                                "wager": {
                                    "description": "The sum of players total bet amount in particular 
                                                    game round",
                                    "type": "decimal"
                                }
                            },
                            "required": [
                                "status",
                                "payout",
                                "settledAt",
                                "dealer",
                                "currency",
                                "participants",
                                "result",
                                "table",
                                "startedAt",
                                "wager",
                                "gameType",
                                "id"
                            ],
                            "type": "object"
                        },
                        "type": "array"
                    }
                },
                "required": [
                    "date",
                    "games"
                ],
                "type": "object"
            },
            "type": "array"
        },
        "timestamp": {
            "description": "Time and date when response was generated.",
            "type": "string"
        },
        "uuid": {
            "description": "Universally unique identifier of the request.",
            "type": "string"
        }
    },
    "required": [
        "data",
        "timestamp",
        "uuid"
    ],
    "type": "object"
}
 

Query parameters:

Name	Type	Description	Mandatory/Optional
startDate	string (UTC date+time)	Specifies the starting date of the report time range (in the format “YYYY-MM-DDTHH:mm:ss.SSSZ”), inclusive. Example: 2017-02- 22T13:49:59.410Z. Default: beginning of current day	M
endDate	string (UTC date+time)	Specifies the end date of the report time range (in the format “YYYY- MM-DDTHH:mm:ss.SSSZ”), inclusive. If endDate is specified – then startDate is mandatory. Default: startDate + 24h, for current day report will contain all games known until the current moment

Security
Basics
All communication between EVO servers and Licensee servers must be performed via encrypted channels using HTTPS protocol. Plain connections are not accepted.

Authentication/Authorization
In case HTTPS/WSS communication licensee request must provide credentials using HTTP basic access authentication, where the username is a unique casino identifier,
and the password is a token. The identifier and the token are unique for the service and should be requested from the integration team.

By header
Licensee passes additional request authorization header

    Authorization: Basic dGhlYmVzdGNhc2lubzAwMTp0b2tlbjEyMw==
where base64(casino_key:api_token) == dGhlYmVzdGNhc2lubzAwMTp0b2tlbjEyMw==

Game List API
Represents tables list of whole lobby for specific casino. Only the tables assigned to the casino included.

GET     https://{licensee_hostname}/api/lobby/v1/{casino_key}/tablelist
Example response
    [
        {
            "data": [
                {
                    "Table Name": "American Roulette",
                    "Table ID": "AmericanTable001",
                    "Direct Launch Table ID": "m5h3htobxfbajvlu",
                    "Game Type": "AmericanRoulette",
                    "Bet Limit": {
                        "CNY": {
                            "symbol": "¥",
                            "min": 1,
                            "max": 2000
                        }
                    }
                },
                {
                    "Table Name": "Speed VIP Blackjack C",
                    "Table ID": "SpeedBlackjack03",
                    "Direct Launch Table ID": "n5vs5zddx4t77imn",
                    "Game Type": "Blackjack",
                    "Bet Limit": {
                        "CNY": {
                            "symbol": "¥",
                            "min": 250,
                            "max": 5000
                        }
                    }
                },
                {
                    "Table Name": "Speed Baccarat V",
                    "Table ID": "qgqrrnuqvltnvejx",
                    "Direct Launch Table ID": "qgqrsabhvltnvhmb",
                    "Game Type": "Baccarat",
                    "Bet Limit": {
                        "CNY": {
                            "symbol": "¥",
                            "min": 5,
                            "max": 25000
                        }
                    }
                },
                {

                    "...": "..."

                }
            ]
        }
    ]

Common fields
Every table contains such fields:

Field Name	Type	Description
Table Name	string	the table name
Table ID	string	physical table id
Direct Launch Table ID	string	virtual table id, only visible for virtual tables
Game Type	Game Types	the game type of the table
Bet Limit		
symbol	string	the symbol of the currency
min	number	the minimum bet size
max	number	the maximum bet size

Overview
Kick player API provides an interface which can be used to kick out the player from Evolution Live Casino as a result of which player is forced to leave the game and player's session is terminated on Evolution side.

Invocation details
Supported methods: POST
Request body format: JSON
Kick player API request must be posted in server-to-server mode.
Kick player API service endpoint URL must always use 'domain name' instead of IP address
Kick player API is served over HTTPS - to ensure security and data privacy, unencrypted HTTP is not supported
Response codes and errors
Kick player API uses standard RFC 2616 HTTP response codes to indicate the success or failure of an API request:

Codes in the 2xx range indicate success
Codes in the 4xx range indicate a problem with the request
Codes in the 5xx range indicate an error with Evolution's servers
Kick player API service endpoint
In order to kick out the player from Evolution Live Casino, Licensee has to send POST request to the service endpoint URL (see below URL format).

Service endpoint URL

https://<hostname>/api/external/kickPlayer/v1/{casinoID}/{apiToken} 
ld	Type	Description	Mandatory / Optional
apiToken	String	Provided by Evolution. Kick Player token	M
casinoID	String	Provided by Evolution. Casino key / identification	M
Request parameters

ld	Type	Description	Mandatory / Optional
uuid	String	Unique request ID which identifies the kick out request, assigned by Licensee	M
playerLogin	String	Player's ID Unique identifier of a player, assigned by licensee	M
Request example

POST	https://{hostname}/api/external/kickPlayer/v1/abc1234/test1234
Request body

{ 

    "uuid": "unique_identifier_of_request",   
    "playerLogin": "external_user_id" 

} 
Response example

In case of successful Licensee request, Kick Player API will return HTTP status 200 and following response body:

OK 

Security
Basics
All communication between Evolution servers and Licensee servers must be performed via encrypted channels using HTTPS protocol. Plain connections are not accepted.

Authentication
HTTP requests to the rendering service are protected with HTTP Basic authentication (RFC 2617 - IETF) over HTTPS. Existing UserAuthentication 2.0 account casino.key and Data API apiToken have to be sent in the Authorization header field to get access to resources:

Authorization: Basic NzA3YmJjMmVkODUyMjU0YWU3OWM4YzVlNTYyOGFjMWM4NmYyN2RzZg==
This header carries Base64-encoded pair of test-casino.key:test-apiToken as username:password

Shared authentication with game-history-api
This service shares credentials with [Game History API]. In other words, username/password valid for Game History API requests will also work for this service.

Response codes
If client omits aforementioned authentication header or provided values are not valid, the request is rejected with appropriate HTTP response code: 401 Unauthorized

Classification API
Service endpoint
All URLs referenced in this documentation have the following base URI: https://«licensee_hostname»/api/classification/v1

Type	Method	URL
Games list	GET	/games
Games list, plain format	GET	/games/plain
Bets list	GET	/bets
Bets list, plain format	GET	/bets/plain
Response codes and errors
This service uses standard RFC 2616 HTTP response codes to indicate the success or failure of an API request:

Codes in the 2xx range indicate success.
Codes in the 4xx range indicate a problem with the request.
Codes in the 5xx range indicate an error with Evolution’s servers.
Games list
https://<<licensee_hostname>>/api/classification/v1/games

Returns list of active games offered by Evolution and their classification. Games are returned regardless of game availability per particular operator or jurisdiction. In other words, full Evolution game portfolio is exposed.

Response is a JSON array with one item per game. Each field for a game contains a JSON object with code and name fields with machine-readable and human-readable values for that property respectively.

Property	Mandatory?	Description
gameProvider	M	Provider of the game
gameSubprovider	M	Sub-provider of the game
gameVertical	M	Highest level classification
gameCategory	M	Groups games by game logic or mechanics, e.g. Baccarat, Dice, Slot, etc.
gameType	M	Identifies type of a game
gameSubtype	O	Introduces variation to a game type. Same game subtype can be used in combination with different game types. Optional, null if absent
game	M	Lowest level classification, uniquely identifies a game played by a player, is a combination of gameType and gameSubtype
Response sample

[
  {
    "gameProvider": {
      "code": "evolution",
      "name": "Evolution"
    },
    "gameSubprovider": {
      "code": "evolution",
      "name": "Evolution"
    },
    "gameVertical": {
      "code": "live",
      "name": "Live"
    },
    "gameCategory": {
      "code": "baccarat",
      "name": "Baccarat"
    },
    "gameType": {
      "code": "baccarat",
      "name": "Baccarat"
    },
    "gameSubtype": null,
    "game": {
      "code": "bac",
      "name": "Baccarat"
    }
  },
  {
    "gameProvider": {
      "code": "evolution",
      "name": "Evolution"
    },
    "gameSubprovider": {
      "code": "evolution",
      "name": "Evolution"
    },
    "gameVertical": {
      "code": "live",
      "name": "Live"
    },
    "gameCategory": {
      "code": "baccarat",
      "name": "Baccarat"
    },
    "gameType": {
      "code": "baccarat",
      "name": "Baccarat"
    },
    "gameSubtype": {
      "code": "lightning",
      "name": "Lightning"
    },
    "game": {
      "code": "bac_lgh",
      "name": "Lightning Baccarat"
    }
  },
  {
    "gameProvider": {
      "code": "evolution",
      "name": "Evolution"
    },
    "gameSubprovider": {
      "code": "evolution",
      "name": "Evolution"
    },
    "gameVertical": {
      "code": "rng",
      "name": "RNG Table Games"
    },
    "gameCategory": {
      "code": "baccarat",
      "name": "Baccarat"
    },
    "gameType": {
      "code": "rng-baccarat",
      "name": "First Person Baccarat"
    },
    "gameSubtype": null,
    "game": {
      "code": "rng-bac",
      "name": "First Person Baccarat"
    }
  },
  {
    "gameProvider": {
      "code": "netent",
      "name": "NetEnt"
    },
    "gameSubprovider": {
      "code": "netent",
      "name": "NetEnt"
    },
    "gameVertical": {
      "code": "slots",
      "name": "Slots"
    },
    "gameCategory": {
      "code": "slots",
      "name": "Slot"
    },
    "gameType": {
      "code": "starburstxxxtrem",
      "name": "Starburst XXXtreme"
    },
    "gameSubtype": null,
    "game": {
      "code": "starburstxxxtrem",
      "name": "Starburst XXXtreme"
    }
  }
]
Games list, plain format
https://<<licensee_hostname>>/api/classification/v1/games/plain

Returns same information as in Games list, but in a different format.

Response sample:

[
  {
    "gameType": "baccarat",
    "gameTypeName": "Baccarat",
    "gameSubtype": null,
    "gameSubtypeName": null,
    "gameProvider": "evolution",
    "gameProviderName": "Evolution",
    "gameSubprovider": "evolution",
    "gameSubProviderName": "Evolution",
    "gameVertical": "live",
    "gameVerticalName": "Live",
    "gameCategory": "baccarat",
    "gameCategoryName": "Baccarat",
    "game": "bac",
    "gameName": "Baccarat"
  },
  {
    "gameType": "baccarat",
    "gameTypeName": "Baccarat",
    "gameSubtype": "lightning",
    "gameSubtypeName": "Lightning",
    "gameProvider": "evolution",
    "gameProviderName": "Evolution",
    "gameSubprovider": "evolution",
    "gameSubProviderName": "Evolution",
    "gameVertical": "live",
    "gameVerticalName": "Live",
    "gameCategory": "baccarat",
    "gameCategoryName": "Baccarat",
    "game": "bac_lgh",
    "gameName": "Lightning Baccarat"
  },
  {
    "gameType": "rng-baccarat",
    "gameTypeName": "First Person Baccarat",
    "gameSubtype": null,
    "gameSubtypeName": null,
    "gameProvider": "evolution",
    "gameProviderName": "Evolution",
    "gameSubprovider": "evolution",
    "gameSubProviderName": "Evolution",
    "gameVertical": "rng",
    "gameVerticalName": "RNG Table Games",
    "gameCategory": "baccarat",
    "gameCategoryName": "Baccarat",
    "game": "rng-bac",
    "gameName": "First Person Baccarat"
  },
  {
    "gameType": "starburstxxxtrem",
    "gameTypeName": "Starburst XXXtreme",
    "gameSubtype": null,
    "gameSubtypeName": null,
    "gameProvider": "netent",
    "gameProviderName": "NetEnt",
    "gameSubprovider": "netent",
    "gameSubProviderName": "NetEnt",
    "gameVertical": "slots",
    "gameVerticalName": "Slots",
    "gameCategory": "slots",
    "gameCategoryName": "Slot",
    "game": "starburstxxxtrem",
    "gameName": "Starburst XXXtreme"
  }
]
Bets list
https://<<licensee_hostname>>/api/classification/v1/bets

Returns list of active games and their possible bets.

[
  {
    "gameType": {
      "code": "baccarat",
      "name": "Baccarat"
    },
    "gameSubtype": {
      "code": "redenvelope",
      "name": "Red Envelope"
    },
    "bets": [
      {
        "bet": {
          "code": "BAC_BankerPair",
          "name": "Banker Pair"
        },
        "betCategory": {
          "code": "side",
          "name": "Side Bet"
        },
        "betType": {
          "code": "banker_pair",
          "name": "Banker Pair"
        },
        "initialBettingFlag": true
      },
      {
        "bet": {
          "code": "BAC_Banker",
          "name": "Banker"
        },
        "betCategory": {
          "code": "main",
          "name": "Main Bet"
        },
        "betType": {
          "code": "banker",
          "name": "Banker"
        },
        "initialBettingFlag": true
      },
      {
        "bet": {
          "code": "BAC_BankerBonus",
          "name": "Banker Bonus"
        },
        "betCategory": {
          "code": "side",
          "name": "Side Bet"
        },
        "betType": {
          "code": "banker_bonus",
          "name": "Banker Bonus"
        },
        "initialBettingFlag": true
      },
      {
        "bet": {
          "code": "BAC_PlayerBonus",
          "name": "Player Bonus"
        },
        "betCategory": {
          "code": "side",
          "name": "Side Bet"
        },
        "betType": {
          "code": "player_bonus",
          "name": "Player Bonus"
        },
        "initialBettingFlag": true
      },
      {
        "bet": {
          "code": "BAC_EitherPair",
          "name": "Either Pair"
        },
        "betCategory": {
          "code": "side",
          "name": "Side Bet"
        },
        "betType": {
          "code": "either_pair",
          "name": "Either Pair"
        },
        "initialBettingFlag": true
      },
      {
        "bet": {
          "code": "BAC_PerfectPair",
          "name": "Perfect Pair"
        },
        "betCategory": {
          "code": "side",
          "name": "Side Bet"
        },
        "betType": {
          "code": "perfect_pair",
          "name": "Perfect Pair"
        },
        "initialBettingFlag": true
      },
      {
        "bet": {
          "code": "BAC_PlayerPair",
          "name": "Player Pair"
        },
        "betCategory": {
          "code": "side",
          "name": "Side Bet"
        },
        "betType": {
          "code": "player_pair",
          "name": "Player Pair"
        },
        "initialBettingFlag": true
      },
      {
        "bet": {
          "code": "BAC_Player",
          "name": "Player"
        },
        "betCategory": {
          "code": "main",
          "name": "Main Bet"
        },
        "betType": {
          "code": "player",
          "name": "Player"
        },
        "initialBettingFlag": true
      },
      {
        "bet": {
          "code": "BAC_Tie",
          "name": "Tie"
        },
        "betCategory": {
          "code": "main",
          "name": "Main Bet"
        },
        "betType": {
          "code": "tie",
          "name": "Tie"
        },
        "initialBettingFlag": true
      }
    ]
  }
]
Bets list, plain format
https://<<licensee_hostname>>/api/classification/v1/bets/plain

Returns same information as in Bets list, but in a different format.

Response sample:

[
  {
    "gameType": "zillardking",
    "gameTypeName": "Zillard King",
    "gameSubtype": null,
    "gameSubtypeName": null,
    "bets": [
      {
        "bet": "SpinWithJackpot",
        "betName": "Spin with Jackpot",
        "betCategory": "main",
        "betCategoryName": "Main Bet",
        "betType": "jackpot_spin",
        "betTypeName": "Spin with Jackpot",
        "initialBettingFlag": true
      },
      {
        "bet": "Spin",
        "betName": "Spin",
        "betCategory": "main",
        "betCategoryName": "Main Bet",
        "betType": "spin",
        "betTypeName": "Spin",
        "initialBettingFlag": true
      },
      {
        "bet": "PieGamble",
        "betName": "Pie Gamble",
        "betCategory": "side",
        "betCategoryName": "Side Bet",
        "betType": "pie_gamble",
        "betTypeName": "Pie Gamble",
        "initialBettingFlag": true
      }
    ]
  }
]
Filtering
By adding query parameters to the request (using above-mentioned endpoints) it’s possible to filter out and receive a list of games/bets with specific game type or game subtype.

Query parameter	Mandatory?	Acceptable value
gametype	Optional	gameType code
gamesubtype	Optional	gameSubtype code
Different variations of filtering by the query parameters:

https://<<licensee_hostname>>/api/classification/v1/games?gametype=bonanza

[
  {
    "gameType": {
      "code": "bonanza",
      "name": "Bonanza"
    },
    "gameSubtype": null,
    "gameProvider": {
      "code": "btg",
      "name": "Big Time Gaming"
    },
    "gameSubprovider": {
      "code": "btg",
      "name": "Big Time Gaming"
    },
    "gameVertical": {
      "code": "slots",
      "name": "Slots"
    },
    "gameCategory": {
      "code": "slots",
      "name": "Slot"
    },
    "game": {
      "code": "bonanza",
      "name": "Bonanza"
    }
  }
]
https://<<licensee_hostname>>/api/classification/v1/games?gametype=baccarat&gamesubtype=redenvelope

[
  {
    "gameType": {
      "code": "baccarat",
      "name": "Baccarat"
    },
    "gameSubtype": {
      "code": "redenvelope",
      "name": "Red Envelope"
    },
    "gameProvider": {
      "code": "evolution",
      "name": "Evolution"
    },
    "gameSubprovider": {
      "code": "evolution",
      "name": "Evolution"
    },
    "gameVertical": {
      "code": "live",
      "name": "Live"
    },
    "gameCategory": {
      "code": "baccarat",
      "name": "Baccarat"
    },
    "game": {
      "code": "bac_redenv",
      "name": "Red Envelope Baccarat"
    }
  }
]