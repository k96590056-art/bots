<template>
  <div class="_3qxkBsFe">
    <div class="_1SI39Ofv" v-if="show">
      <div class="_9-ZpLxb0">
        <img
          src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjA2IiBoZWlnaHQ9IjgwIiBmaWxsPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnIGNsaXAtcGF0aD0idXJsKCNjbGlwMF8yMjk3XzE3MzQzKSIgZmlsbD0iI2ZmZiI+PHBhdGggZD0iTTY2Ljg1MiAyNC41NGMyLjI3MiAwIDQuMjQxIDEuNDI1IDQuNzQyIDMuNDMybDIuNjcgMTAuNjkyIDQuMzIzLTExLjE3N2MuNjgzLTEuNzY2IDIuNTIzLTIuOTQ4IDQuNTg5LTIuOTQ4aDcuNTM0bC0xMy4wNTIgMzQuNWMtMS40MTUgMy43NC01LjI5NiA2LjI1LTkuNjYgNi4yNWgtOS41NHYtMi43NDdjMC0yLjM0OSAyLjAzNC00LjI4NCA0LjYyMy00LjQgMS43MjEtLjA3NiAyLjc3Mi0uMjA3IDMuMTUxLS4zOTIuNjQ2LS4zMTYgMS4yNzEtMS41MyAxLjg3NC0zLjY0TDU5LjM5IDI0LjU0aDcuNDYzem0zMi4xNzUgMGEyLjc3IDIuNzcgMCAwMTEuOTc0Ljc2NWMuNTA3LjQ5OC43NTcgMS4xNjkuNjg2IDEuODQzbC0xLjYxMiAxOC45NGMtLjEyNyAxLjUuMTI5IDIuMTExLjc2NSAyLjU1NC40MzMuMjQuOTM2LjM1NyAxLjQ0My4zMzNhMi44NzQgMi44NzQgMCAwMDEuNDk5LS4zMzNjMS4wMjctLjU1NSAxLjE4My0xLjY2NSAxLjI2My0yLjYxbDEuNTk2LTE4Ljg4M2MuMTQ0LTEuNDYgMS40ODItMi41ODcgMy4xMDEtMi42MWg3LjQ3OWwtMi41MDQgMjkuNjAxLTEwLjM0Ni0uMDA3LjI1Mi0yLjk5OWMtLjczNi43My0xLjE0MSAxLjI1OC0xLjkwOSAxLjgzNy0xLjcyNyAxLjMwMS0zLjE1OCAxLjgyOS01LjQ4NyAxLjgyOS01LjM5NSAwLTYuOTA1LTMuMTY0LTcuMzYyLTQuOTk3LS4yNjktMS4wNTYtLjMxNC0yLjExLS4xMi00LjM4MWwxLjc2NC0yMC44ODNoNy41MTh6bS02MS45ODMgMi45NGMzLjY4My0yLjYwOCA5LjAwMy0zLjYyNCAxMi4wNzQtMy40NjIgNy41OTYuNCAxMS41MzkgNC42NzQgMTEuMDIyIDkuODM0LS42NzIgNi43MDUtOC4zNzUgNy43MzMtMTEuMDIyIDguMDU4LTMuNzcyLjQ2My02LjU4MiAxLjQ5Ni04LjQzMiAzLjEtMS40MjktNS40ODQgMS40Ni04Ljc3IDguNjY4LTkuODU2Ljk4LS4xNDggMy4yNTctLjU3MyAzLjM5My0yLjUzNC4xMzYtMS45Ni0yLjY0MS0zLjUzNC02LjQyOC0yLjU0LTQuNjg4IDEuMjMxLTcuMjc0IDUuMTY0LTcuOTc2IDguMzY5LS43MDMgMy4yMDQtLjYwNCA4LjQ2MSA1LjA3IDguNjA5IDUuNzcuMTUgMTIuNTg2LTMuMzczIDE0Ljg5OC00LjY3NGwuMTg1LS4xMDVjLjI4OS0uMTY1LjQ4Ni0uMjgyLjU3NS0uMzM2bC4wNS0uMDNjLTMuMjA0IDUuODMyLTcuNTc1IDguMDE4LTcuNTc1IDguMDE4IDEuNzUzLjgzNiA1Ljc1Mi40ODUgNi4wOS40NTNsLjAyMi0uMDAyYy0xLjc5NCAyLjU1Ny0xMS41MTUgNi4yOS0xOS45OTkgMS42OS04LjMxNC00LjUwNi01Ljg0NC0xMy4yNy01Ljc0Ny0xMy42MTNsLjAwMi0uMDFjLTEuMzIgMS4zNDUtMi42MjIgMy45MzQtMi44MTIgNC4yOTFsLS4wMi4wMzdjLS4zMTktNS43MjIgMy40MzgtMTIuMDkzIDcuOTYyLTE1LjI5N3ptLTkuOTQ5LTEyLjU1NGEyLjc2NyAyLjc2NyAwIDAxMS45NzQuNzY1Yy41MDguNDk4Ljc1NyAxLjE2OS42ODYgMS44NDRMMjYuNjYgNTQuMTMzaC03LjYwMmEyLjc2NiAyLjc2NiAwIDAxLTEuOTc5LS43NjJjLS41MS0uNDk4LS43Ni0xLjE2OS0uNjg5LTEuODQ1bDMuMTA0LTM2LjZoNy42MDF6TTQ5LjAwNCAzMS4zOGMuNjQgMCAxLjE2LjQ3IDEuMTYgMS4wNTFzLS41MiAxLjA1Mi0xLjE2IDEuMDUyYy0uNjQxIDAtMS4xNi0uNDcxLTEuMTYtMS4wNTIgMC0uNTguNTE5LTEuMDUxIDEuMTYtMS4wNTF6TTE2OS44NTUgNDAuNzU4djIuMDU0aDMuMDEydi44MjVoLS43ODhjLjExIDMuNzIuMzc4IDcuMzIyLjc4OCAxMC44NTNoLTIuMDY2Yy0uNDEtMy41NzQtLjYxNS03LjE3Ny0uNzQxLTEwLjg1M2gtLjIwNXY5LjAwMWguNjE1di44MjVoLS42MTV2MS4wMTNoLTMuNDM4di0xLjAxM2gtLjU2OHYtLjgyNWguNTY4di05aC0uMjA1YTE1Mi43NSAxNTIuNzUgMCAwMS0uNzQxIDEwLjg1MmgtMi4wNjZjLjM5NC0zLjUzLjY0Ny03LjEzNC43NzMtMTAuODUzaC0uNzg5di0uODI1aDMuMDI4di0yLjA1NGgzLjQzOHptLTYuNzE4LS4wMTVjLS4xNzQgMS41NDgtLjQyNiAzLjA4Mi0uODA0IDQuNTczaC41MDR2OS4xNmgtMy40NTNWNDguMDhoLTEuNDJjLjg2OC0yLjU0NyAxLjQzNS00Ljk5MyAxLjY4OC03LjMzN2gzLjQ4NXptMjQuMDM0IDYuMTA3Yy41ODMgMCAxLjA0MS40MzQgMS4wNDEuOTU1djUuNzE2YzAgLjUyLS40NTguOTU1LTEuMDQxLjk1NWgtMy42MTJ2LS44MjVoLjQ1OGMuMzMxIDAgLjU5OS0uMjQ2LjU5OS0uNTV2LS41MzVoLTUuMjk5djEuOTFoLTMuNTk1di02LjY3MWMwLS41MjEuNDU3LS45NTUgMS4wNC0uOTU1aDEwLjQwOXptLTQ3LjYxMS02LjA3OGMtLjIzNi45NC0uOTE0IDEuMzc1LTIuMjg2IDEuMzc1aC03Ljk2NGMtLjMzMiAwLS42LjI0Ni0uNi41NXYzLjI0MWMwIC4zMDQuMjY4LjU1LjYuNTVoMS4yMTR2LTMuMjQyaDMuNTk1djMuMjQyaDUuMDE1di44MjVoLTUuMDE1djYuMTkzYzAgLjUzNi0uNDczLjk1NS0xLjA1Ni45NTVoLTMuOTExdi0uODI1aC43NzNjLjMzMSAwIC41OTktLjI0NS41OTktLjU1di01Ljc3M2gtNC4wNTNjLS41OTkgMC0xLjA1Ny0uNDItMS4wNTctLjk1NXYtNC4wODFjMC0uNTIxLjQ1OC0uOTU1IDEuMDU3LS45NTVoNy43NDVjLjgzMS0uMDA1IDEuMjc1LS4wNjggMS41NzUtLjU1aDMuNzY5em0xNi43NDggMTIuNzYzdi44MjVIMTQxLjM5di0uODI1aDE0LjkxOHptLTI2Ljk2Ny01LjMyNWMtLjI4NCAyLjA3LS43NDEgNC4wMzctMS40MTkgNS45MDRoLTMuMDZhMjcuNTA4IDI3LjUwOCAwIDAwMS40NjctNS45MDRoMy4wMTJ6bTguOTU4IDBjLjI2OCAyLjAxMS43NTcgMy45OCAxLjQ2NiA1LjkwNGgtMy4wNTljLS42NzgtMS44NjctMS4xMzYtMy44MzUtMS40Mi01LjkwNGgzLjAxM3ptOC44OTQtNy40ODFhMTUuNDYgMTUuNDYgMCAwMS0uMzMxIDEuMzNoNi40MThjLjYxNSAwIDEuMDI1LjUzNi44MzYgMS4xYTE1LjEyNSAxNS4xMjUgMCAwMS0uODk5IDEuOTU0aC43ODljLjU4MyAwIDEuMDQxLjQyIDEuMDQxLjk1NXY1Ljg5YzAgLjUzNS0uNDU4Ljk1NS0xLjA0MS45NTVoLTEwLjMzYy0uNTY3IDAtMS4wNDEtLjQyLTEuMDQxLS45NTV2LTUuODljMC0uNTM1LjQ3NC0uOTU1IDEuMDQxLS45NTVoNi4wMDljLjM2Mi0uNjM2LjU5OS0xLjE3Mi45My0xLjg1Mi4wNzktLjE3NC0uMDYzLS4zNzYtLjI2OC0uMzc2aC0zLjc2OWExMC41MDcgMTAuNTA3IDAgMDEtLjc3MyAxLjYyaC0zLjUxNmMuNzg4LTEuMjg3IDEuMjQ1LTIuNDg5IDEuNTkyLTMuNzc2aDMuMzEyem00LjQxNiA4Ljc4M2gtMS4xMnYyLjU3NmguNTJjLjMzMiAwIC42LS4yNDYuNi0uNTV2LTIuMDI2em0tNC40MTYgMGgtMS4xMnYyLjAyNmMwIC4zMDQuMjY4LjU1LjYuNTVoLjUydi0yLjU3NnptMzcuNDIzLjU2NWgtNS4yOTl2MS42NjRoNS4yOTl2LTEuNjY0em0tLjU5OS0yLjQwMmgtNC4xYy0uMzMyIDAtLjYuMjQ2LS42LjU1djEuMDI3aDUuMjk5di0xLjAyOGMwLS4zMDMtLjI2OC0uNTUtLjU5OS0uNTV6bS0zNi44MjQtMS43MzdoLS41MmMtLjMzMiAwLS42LjI0Ni0uNi41NXYyLjJoMS4xMnYtMi43NXptMy44MTYgMGgtLjUydjIuNzVoMS4xMnYtMi4yYzAtLjMwNC0uMjY4LS41NS0uNi0uNTV6bTMyLjc1NS01LjE2NnYuOTdoNS42NjJ2LjgyNEgxODAuOGwtMS4zODggMi4yYy0uMDYzLjEwMS0uMDk1LjIwMy0uMDQ3LjMwNGEuMjg4LjI4OCAwIDAwLjI2OC4xNzNoNC44MjVhLjMwNi4zMDYgMCAwMC4yNjgtLjE3M2MuMDQ4LS4wODcuMDMyLS4xODgtLjAzMS0uMjlsLS43NDEtMS4yODhoMy42MTFsMS4wMDkgMS42OTRhLjU0Ny41NDcgMCAwMS4wNDguNTc4LjYyMi42MjIgMCAwMS0uNTM2LjI5aC0xMi4yNTRhLjYyNC42MjQgMCAwMS0uNTUyLS4zMzNjLS4wNzktLjE4OC0uMDE2LS40MDUuMTI2LS41OTNsMS42NC0yLjU2MmgtMi41Mzl2LS44MjRoNS42NjJ2LS45N2gzLjU5NXptLTI0LjY3OS0xNi4yNzZjLjM4NyAwIC43NDcuMTc3Ljk1Ny40NzJsMy40OTUgNC45MDggMy4zMzktNC44OTJhMS4xNyAxLjE3IDAgMDEuOTY4LS40ODhoMy45MjRsLTYuNDI5IDkuNDE1djMuMDgxYzAgLjQ0Ny0uMzE4Ljg0My0uNzg4Ljk4bC0yLjg5NS44NXYtNC44OGwtNi40OTktOS40NDZoMy45Mjh6bS02Ljg5OC4wM2wtLjk1NSAyLjk2NWgtNy44NjN2Mi43MzFoOC4yODFsLS44MTcgMi42N2gtNy40NjR2Mi43NWg4LjgxOGwtLjcxNCAyLjE3OGMtLjE0My40MzctLjU4Ny43MzctMS4wOTEuNzM3aC0xMC43ODV2LTEzLjE3YzAtLjQ3Ni40MjUtLjg2Ljk0OS0uODZoMTEuNjQxem0zNS4yNzgtLjE0Yy42MjggMCAxLjEzOC40NjIgMS4xMzggMS4wMzF2OC43MDhjMCAuNjE4LS4wNDggMS4xNS0uMTQ1IDEuNTk0LS4wOTYuNDQ1LS4yMDcuNzktLjMzMyAxLjAzNWEyLjg4MyAyLjg4MyAwIDAxLS40NjguNjYyIDIuNTk3IDIuNTk3IDAgMDEtLjU4Ny40NzRjLS4yMDYuMTE4LS41NzIuMjU4LTEuMS40MTctLjUyNy4xNi0xLjE1My4yNC0xLjg3Ni4yNGgtNS4yNTVjLS41NjQgMC0xLjA1OC0uMDctMS40ODMtLjIxYTUuODA5IDUuODA5IDAgMDEtMS4wMjUtLjQyNyAyLjYwMSAyLjYwMSAwIDAxLS42NDItLjQ5NCAzLjI5MiAzLjI5MiAwIDAxLS40NjMtLjY1NyA0LjUxNCA0LjUxNCAwIDAxLS4zNzMtMS4wMTRjLS4xMS0uNDIxLS4xNjQtLjk0OC0uMTY0LTEuNTh2LTkuNzRsMi41ODcuMDA2Yy42MjguMDAyIDEuMTM1LjQ2MyAxLjEzNSAxLjAzMVYzMi44YzAgLjU1Ny4wMTIuOTQ0LjAzNSAxLjE2Mi4wMjMuMjE3LjA5My40MjYuMjA5LjYyNi4xMTYuMi4zMTMuMzY3LjU5Mi41LjI3OS4xMzIuNjk3LjE5OCAxLjI1NC4xOThoMS45ODFjLjY1IDAgMS4wODEtLjA1IDEuMjk0LS4xNDguMjEyLS4wOTguNDAxLS4yMzIuNTY3LS40MDIuMTY2LS4xNy4yOS0uMzYuMzczLS41Ny4wODMtLjIxMS4xMjUtLjY0LjEyNS0xLjI4NHYtOC40ODhsMi42Mi0uMDA3aC4wMDR6bS02Mi42MDMuMTRsMi41OTguMDA3Yy42MjcuMDAyIDEuMTM1LjQ2MyAxLjEzNSAxLjAzMXY5LjY2MWw3LjYzNC0uMDItLjg5NiAyLjYwNmMtLjE0OC40MzItLjU4OS43MjUtMS4wODguNzI1bC05LjM4My0uMDF2LTE0eiIvPjwvZz48ZGVmcz48Y2xpcFBhdGggaWQ9ImNsaXAwXzIyOTdfMTczNDMiPjxwYXRoIGZpbGw9IiNmZmYiIHRyYW5zZm9ybT0idHJhbnNsYXRlKC41KSIgZD0iTTAgMGgyMDV2ODBIMHoiLz48L2NsaXBQYXRoPjwvZGVmcz48L3N2Zz4="
          alt="icon"
        />
        <div class="_3_qzGcRD"><span class="_1N8mCmac">-</span><span>B</span><span>O</span><span>B</span><span>.</span><span>C</span><span>O</span><span>M</span><span class="_1N8mCmac">-</span></div>
      </div>
    </div>
    <div class="_2wDaFihi">
      <div class="_2Jk4HIIp"></div>
      <h1 class="_1K9Hh6Oi"></h1>
      <!-- <div class="_349CzCYy xJQe3jRu _1bjy_lS3"><span>加入我们</span></div> -->
      <div style="height: 80px"></div>
    </div>
    <div class="_1MsAz5sh">
      <!-- 推广链接和二维码区域 -->
      <div class="promotion-section" v-if="$store.state.token">
        <h6>推广中心</h6>
        <div class="promotion-container">
          <!-- 推广链接 -->
          <div class="promotion-card">
            <h3>推广链接</h3>
            <div class="link-box">
              <input type="text" :value="inviteInfo.invite_url || ''" readonly class="link-input" />
              <button @click="copyLink" class="copy-btn">复制</button>
            </div>
          </div>

          <!-- 推广二维码 -->
          <div class="promotion-card">
            <h3>推广二维码</h3>
            <div class="qrcode-box">
              <div class="qrcode-wrapper" v-if="inviteInfo.qrcode">
                <img :src="inviteInfo.qrcode" alt="推广二维码" class="qrcode-img" />
              </div>
              <div v-else class="loading-tip">加载中...</div>
              <p class="qrcode-desc">扫描二维码即可注册</p>
            </div>
          </div>
        </div>
      </div>

      <h6>产品特色</h6>
      <div class="_3JT99ZzH">
        <div>
          <div class="_3lFRdQii _3ks1sana">
            <span class="Y5IwJYHm">会员统计</span>
            <div
              class="_3fLoMpEC"
              style="
                background: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAYoAAADyBAMAAAChVp87AAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAAwUExURUxpcZeisP///z5OdD9Pcz5QdT1PdD5PdT5QdD5Obj5QdD5PdT5PdD5PdJijsT9QddVdH1EAAAAOdFJOUwD+ASRD2oCkvxDvYJBwn/jZpwAABA9JREFUeNrt3c9rHHUYx/GPzOzsTHbX0n+gh4L3L+yu1tWQgaSFnDJQg7YGNtA0WorsQiNpesmAFAM9bA4pQnswoFsEK1mohYqH7rmXXMSDHmL9AySQzm5+dBl3okEyHsqzGNhHPm/Ilxw2DC8YZrOE5wle2et//IZhjwoqqKCCCiqooIIKKqigggoqqKCCCiqooIIKKqigggoqqKCCCiqooIIKKqigggoqTr7SxMSEAYqH3yfHmkZF3K8F3ES/q8nxVKHC6xSLxVVgEf0+To7HChXWi+R8y3zkzX1hnng/5f3z3q/qFPah4vzuSuPrcvRp47ty9OzZQ3WK3M79OQOMxnP9Y2MBeGdjYVWdwulFG98CznQbKEyHgN29hOOKoe858pFvVX1sFR8AUz/MAJVr7+tT5G4AldDrYMt4M5jy8TkqvjpFkrsOAxt4OzmKsKBJkYSk7Lb230AydcANtCvcr4CpunaF1Xz0ZnNVuwLn4ngJ6hUoTfJTEhVUUEEFFVRQQQUVVFBBBRVUUEEFFVRQQQUVVFBBBRVUUEEFFVRQQQUVVFBBBRVUUEEFFVRQQcV/04XrJjVBqVBxLqoepCYoFSou+1bD93qpCUplCrsHfNlOT1BqU+R3gEyYnqDUpnBCYKx+NEG5//cE5THF72eHPSTVWk7naIIyOUKN83qFLvKROTZBqU/hbS4htwRU6n9NUD7ElK9PUe7hMDeADxswsHFM8fz0kHcGyDUNUhOUCt/1tpZSE5QaFVZ0NEH5tK1Xke/Oz8+3UhOU6hRu3C9MTVAqUqQnKPkpiQoqqKCCCiqooIIKKqigggoqqKCCCiqooIIKKqigggoqqKCCCiqooIIKKqigggoqRF2Yg35FOdq4qF9xy7e/Ua+wD4Car12R3UtGfLQrMkHypV0xUgey69oVpxLFNhVD88+s1rXNiKVzAyATaptLSufsAWNt7QrrJbBstCuweeXdDv7ptdND3xn8Oyfen4X+1ibBGGOMMcYYG+pFU7K8SeEVPjGQ5P183QyyaErW3ReQlN2vdiDpl2ajM8iiKYhalilqLasquYLVXbWW/QEWTUGS80CksDrCK+R3gHvtARZNQdLYjyJFYQewjeQODIBMfYBFUxBkzeRECje0v4eUPdaCtJroR7KBTJG5UY3fgyBv+tHoB5BW6ELSVSNTnLp9za4aCCrH8UUISxZNCbIOIFT0gEoouUJzvHTZQFa5J3v5rFAxsg2465Jb8BJwN4CoXFPGri0u3txdEP4tLrsteQbOJo9O8aIpUU9WVm5HdyTP8j3ADYQKR6awIkgT3lH2S+GzfCQA3ggGWDR1kgpsXhkV3bWF3fFSozXAoqkTVThx/BkkPY7jDzF0rY1DVmkcjLH/c38CToekZm5/HesAAAAASUVORK5CYII=')
                  no-repeat;
              "
            ></div>
            <div class="osbRfsRg"></div>
          </div>
          <div class="_3JEzbcJZ">会员统计实时更新，一目了然</div>
        </div>
        <div>
          <div class="_3lFRdQii _2YbIdTYD">
            <span class="Y5IwJYHm">报表明细</span>
            <div
              class="_3fLoMpEC"
              style="
                background: url('data:image/png;base64,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')
                  no-repeat;
              "
            ></div>
            <div class="osbRfsRg"></div>
          </div>
          <div class="_3JEzbcJZ">数据分析报表，清晰明白</div>
        </div>
        <div>
          <div class="_3lFRdQii BsLH4N-Y">
            <span class="Y5IwJYHm">账单详情</span>
            <div
              class="_3fLoMpEC"
              style="
                background: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAKgAAABYCAMAAABWB0yfAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAA8UExURUxpcT5QdT5PdD9Pbz5PdJeisD9Pcz5QdD1Pcz5QdT9PdD5QdT5PdT5Pcz5QdD1PdD5QdT5QdZijsT9QdTWe24MAAAASdFJOUwC/IBBg/kDfgKAwz3BQ75DvjxpVlsQAAAFxSURBVHja7djLisMwDAVQWfZYsvNqq///18EVyaSPRaGdJIV7NhF4kYsFCVwCgN1kOhS9E5cDS7SfystU/Wl3mBzbRDsSnadQbg8K3WCRdrexK7SLbglaCrmc/oIOSi52wtQkU9rakJhCojzF2jMVJVZuiU9xCSphldNNlmljOlrpSjDJSSx0oU1tyaZz0GSJmirXnMx5SGoSaWu52Knn6zTZSWub/Eo9qIhfvZmImJPOzrS5UMbep7OIksuWPGhv7Isvk2pKQ64c2yZ2WL7w4G/VkVs+V+fVPw8URWlbuYWcpEVrIXuLRL26sVPX+5dgJe/zU4x1nqhNQZyN4kI7KbZSyF0+gN4mhVZKoEX4oqCfg6CHDypp0R06qK1g9QAAAADoR9GPoh9FP4p+FP0o+lH0ow/96L84aD/6CLUjgqIfxeoBAAAA0I+iH0U/in4U/Sj60S/qRy9b+PlAP/rKa952eb0fRVOCoAiKfhSrf+YXdb9Jia2K/cgAAAAASUVORK5CYII=')
                  no-repeat;
              "
            ></div>
            <div>
              <div class="_1cOWT0xI"></div>
              <div class="_27lMo04X"></div>
              <div class="_3j_9ziO7">
                <div></div>
              </div>
            </div>
          </div>
          <div class="_3JEzbcJZ">各类营收明细专业为你呈现</div>
        </div>
        <div>
          <div class="_3lFRdQii _1ca3eLP3">
            <span class="Y5IwJYHm">佣金报表</span>
            <div
              class="_3fLoMpEC"
              style="
                background: url('data:image/png;base64,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')
                  no-repeat;
              "
            ></div>
            <div class="osbRfsRg"></div>
          </div>
          <div class="_3JEzbcJZ">数据分析报表，清晰明白</div>
        </div>
      </div>
      <h6>联系我们</h6>
      <div style="line-height:1.5;padding-bottom:60px" v-html="dataBox4 ? dataBox4.content : ''"></div>
      <div class="nWrs4LUF" v-if="false">
        <div class="DNbIv4F4" @click="openKefu">
          <img src="/static/image/icon_logo-edb7.png" alt="" />
          <div class="_2cnwpQ2v">合营咨询：</div>
          <div class="_3BWOqozu">(点击直接联系，联系时请提供用户名)</div>
        </div>
        <div class="_28ZbiGhr" @click="open('https://www.flygram3.com/')">
          <img
            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIwAAACMCAMAAACZHrEMAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAMAUExURUxpcf9/f8x/Zv/////+/tuEa8x7ZfGThP///////////8h8YMx8Xsl4Wst2Xs15Xcp3Wct3W8x2W8p5XMt4W8p3Wst3Wsx4Wsl1Xct3Wcx3Wct8Yct3Wsp2Wsp2Wst3Wsx5Xd6ag/ju6s17YMx4W816XMp3Wct3Wvjc1PDDt8x5XMt3Wst3WvHLwMt4W/K4p+Gun9KJcMx5XOi7q/W4pOa+sPTKvd+jjv///v38/OzJvfTTx/79/Omrlsp8X/79/OiyoPz49ticiPnu6vDZ0PTUzf78/PDBsv37+vbj3P37+vvn4PDYz/HPxPrd09SFa+nHvPfVyct2WdGFa9eKcP359/zv6/Oznvrn4fjc0u3Ow+S7rffs5+W2p//+/st2Wd+rmc6AZPbo4/LKvPzy8Prz8d+smvHPw+nDtee8rtWOdPTQxNeNdO7Rx+i/sOW7q/nl3eOzofTSx+eoku7Hu+CZgfvw7Pz18+u+ru2zoP319N6bhf////f29vvTxvrLu/zf1vrJufzb0PnBr//7+f7v6vzd0vm8qP729P3m3/zi2f/39PvYzP3s5vze1fvVyf3k2/rNvvrEsv/49v7w7Pi5pPz7+//9/f/8+/708PvQwfvUyPrDsf7+/frFtP////Ly8v/+/fvaz/rHtv////m7pvzZzf3j2vX19fPz8/38/P3l3v749f718vvWyv3o4vnArvzg1/m9qf/5+PvPwPvRw/3k3fvSxf7t6Pm+q/rMvfnCsP3n4P3q5Pm/rP3p4/7x7Pvc0v7y7/rGtff39/j4+Pi4ov7x7vr6+vrIuPTAsPbn4/Pi3vLZ1NWViuOklfPVzfzaz9majvz29fXFtvjTyN6fkuzTz/jr6PHQyNmkm9WZj+W3ru+8r/ju6+OqnffXzumxovbe2Pv08u/c2f75+Pjj3fS8qtifluGvpenFvfjPwt6rof7u6OC4svO0oe21p+msnOzKw/jIuee8suWzqe2vnfvx7/vp5PDt7fzt6dGQheK/ueXMx/Dm5Pfy8bnW+gYAAAD4dFJOUwACCsEMBw0DAT2RERktFB9HMSVCoGGAOxeJSympclxWxdRHHGU2kJf+/my6Uf53/CTSsuv/GP3f+97y7/ThIvHppTOKVRDq8texyf09k/OXL/fYvrOx8/Xj22ITW4f4z+e6cdHFdkaybXZW2sJ6XlH1m8LHqLTc9LvX4p/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////+RE/wcAAAFu1JREFUeNrtnHdYFFfbxj9IIBpFBKQoIi5FWCJFEVAQRVFRsX6xJupnYoum9/JedolKFKMxligSzJVoEEViFxuYoiwLvPTelx46gsTy3efM7s4MM7trMLne94/cnmvOM6c88+M5Z/qs//OP/tE/+kf/rerVq5ee3nPdpaenh4r/BIeBgYG+vr6hSvoQigjT0xM986c0ffrUqWOmTBk/dtno0eER4aNHLxs7dvyUKWOmTp0+/c95EoWZ8PyTasL8+c8QljFgITBREVGAoTRjCM0z8+f/CWeiMKvseuuWnZ3dkiWBE1aOGR+hUePHrJwQuGQJmj6Jw1WiMHZez+rQ5MleM5ZMmD5l7LJl4RFaFI4oTZk+YckMr8mTdfn0shOF6f2stjmr95zB5Dl2q56fP3XK6Ign0OgpU+c/v8puzmQDMp01e362t24YIYr+y3OWBIqNjrbxClwy52VDivNXwQDlOYOX7QLHTBEbHe3jNWVMoN3LBmRn7ymMEMVjxqoJ08cKx0f3aI2dPmHVDA+K89QwdIQMvexWYYB6qLFjVtl5sWPVYxgaFn2vGfOnLot4Ci2bOn+Glz4JztPA0LDMePX5noaFncnPvzqDBqenMBgizJY+Hq/OHxvx1Bo7/1UPMpExVD2CAYuBvteSCeMxb59eo8dPWOKlbwCaHsBgiGhYJkyNivhLFDV1AoLDDpUuGMF08ZgxfUqkiCIiI5C0lwk1ZfoMD3bi6Ibhx2VO4FTFgfCD4UgHqbh25MFIJG4Z2yYynKnj9zm0bGrgnD4sjU4YlkXfa07gyvHbDh08dBDpkEahEtLYhtd//MrAOdjHQaMbhsfSZ86kz8Zv4+vQtkNI3QpF2kDIROrGfjZpTh9CoxuGzxL42VeKbQokxpE2G0LG2sy6SJ9zX30WyNDohmFZ+nkErvyY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"
            alt=""
          />
          <div class="_1HqH_rpz">
            <div>Flygram：</div>
            <div></div>
          </div>
          <div class="_3zjPfaMx">(点击图标前往下载工具)</div>
        </div>
        <div class="_28ZbiGhr" @click="open('https://skype.gmw.cn/')">
          <img src="/static/image/icon_skype-205f.png" alt="" />
          <div class="_1HqH_rpz">
            <div>Skype：</div>
            <div>live:.cid.abd79c917c885961</div>
          </div>
          <div class="_3zjPfaMx">(点击图标前往下载工具)</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'agent',
  data() {
    // 1常见问题  2隐私政策  3免责说明  4联系我们  5代理加盟  7关于我们 8博彩责任
    return {
      jumpUrl: null,
      dataBox1: {},
      dataBox2: {},
      dataBox3: {},
      dataBox4: {},
      dataBox5: {},
      dataBox7: {},
      dataBox8: {},
      show: false,
      inviteInfo: {
        invite_url: '',
        qrcode: '',
        poster: '',
      },
    };
  },
  components: {},
  created() {
    let that = this;

    let arr = [4];
    arr.forEach(el => {
      that.getAllCont(el);
    });

    // 获取推广信息
    if (this.$store.state.token) {
      this.getInviteInfo();
    }
  },
  mounted() {},
  methods: {
    getInviteInfo() {
      let that = this;
      that.$apiFun
        .post('/api/inviteInfo', {})
        .then(res => {
          if (res.code == 200) {
            that.inviteInfo = res.data || {};
          } else {
            that.showTost(res.message || '获取推广信息失败');
          }
        })
        .catch(res => {
          that.showTost('获取推广信息失败，请重试');
        });
    },
    copyLink() {
      let that = this;
      if (!that.inviteInfo.invite_url) {
        that.showTost('推广链接不存在');
        return;
      }
      let cInput = document.createElement('input');
      cInput.style.opacity = '0';
      cInput.value = that.inviteInfo.invite_url;
      document.body.appendChild(cInput);
      cInput.select();
      document.execCommand('copy');
      document.body.removeChild(cInput);
      that.showTost('复制成功！');
    },
    getAllCont(type) {
      let that = this;
      that.show = true;

      that.$apiFun
        .post('/api/article', { type })
        .then(res => {
          let name = 'dataBox' + type;
          that[name] = res.data || {};
          that.show = false;
        })
        .catch(res => {
          that.show = false;
        });
    },
    open(url) {
      this.jumpUrl = url;
    },
    openKefu() {
      let that = this;
      that.showTost('正在链接人工客服');
      that.$apiFun.post('/api/getservicerurl', {}).then(res => {
        console.log(res);
        if (res.code != 200) {
          that.showTost(res.message);
        }
        if (res.code == 200) {
          that.jumpUrl = res.data.url;
        }
      });
    },
    showTost(title) {
      $('body').append(`
            <div class='ant-message' style='top: 400px;'><span><div class='ant-message-notice'><div class='ant-message-notice-content'>
            <div class='ant-message-custom-content ant-message-info'><span role='img' aria-label='info-circle' class='anticon anticon-info-circle'>
            <svg viewBox='64 64 896 896' focusable='false' data-icon='info-circle' width='1em' height='1em' fill='currentColor' aria-hidden='true'>
            <path d='M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448 448-200.6 448-448S759.4 64 512 64zm32 664c0 4.4-3.6 8-8 8h-48c-4.4 0-8-3.6-8-8V456c0-4.4 3.6-8 8-8h48c4.4 0 8 3.6 8 8v272zm-32-344a48.01 48.01 0 010-96 48.01 48.01 0 010 96z'></path></svg></span><span>
            ${title}
            </span></div></div></div></span>
            </div>`);
      setTimeout('$(".ant-message").detach()', 2000);
    },
  },
  watch: {
    // 新窗口打开页面，解决浏览器拦截问题
    jumpUrl() {
      if (this.jumpUrl) {
        window.open(this.jumpUrl, '_blank');
      }
      this.jumpUrl = null;
    },
  },
};
</script>

<style lang="scss" scoped>
.promotion-section {
  margin-bottom: 40px;

  h6 {
    font-size: 24px;
    font-weight: 600;
    text-align: center;
    margin-bottom: 30px;
    color: #333;
  }
}

.promotion-container {
  display: flex;
  flex-direction: column;
  gap: 24px;
  max-width: 800px;
  margin: 0 auto;
  padding: 0 20px;
}

.promotion-card {
  background: #fff;
  border-radius: 12px;
  padding: 30px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  width: 100%;

  h3 {
    font-size: 20px;
    font-weight: 600;
    color: #333;
    margin-bottom: 20px;
    text-align: center;
  }

  .link-box {
    display: flex;
    gap: 12px;
    align-items: center;

    .link-input {
      flex: 1;
      padding: 12px 16px;
      border: 1px solid #e0e0e0;
      border-radius: 8px;
      font-size: 14px;
      color: #333;
      background: #f8f8f8;
      outline: none;
      font-family: monospace;
    }

    .copy-btn {
      padding: 12px 24px;
      background: #1890ff;
      color: #fff;
      border: none;
      border-radius: 8px;
      font-size: 14px;
      cursor: pointer;
      white-space: nowrap;
      transition: background 0.3s;

      &:hover {
        background: #40a9ff;
      }

      &:active {
        background: #096dd9;
      }
    }
  }

  .qrcode-box {
    display: flex;
    flex-direction: column;
    align-items: center;

    .qrcode-wrapper {
      width: 250px;
      height: 250px;
      background: #fff;
      border: 1px solid #e0e0e0;
      border-radius: 8px;
      padding: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 16px;

      .qrcode-img {
        width: 100%;
        height: 100%;
        object-fit: contain;
      }
    }

    .loading-tip {
      width: 250px;
      height: 250px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 16px;
      color: #999;
      margin-bottom: 16px;
      border: 1px solid #e0e0e0;
      border-radius: 8px;
    }

    .qrcode-desc {
      font-size: 14px;
      color: #666;
      text-align: center;
    }
  }
}

.fangda {
  animation: _308UEapr 0.5s ease-out;
}
.hover {
  display: none;
}
._3gi7jqcw:hover ._2JoosS9F {
  display: none;
}
._3gi7jqcw:hover .hover {
  display: block;
}
._3gi7jqcw._12ZkQT2g ._2JoosS9F {
  display: none;
}
._3gi7jqcw._12ZkQT2g .hover {
  display: block;
}
._1rdiSS19 ._1TurqGH- {
  width: 140px !important;
}
._1rdiSS19 .swiper-wrapper {
  display: flex;
  justify-content: center;
}
</style>
