<template>
  <div class="_35lz77bA">
    <div class="_1SI39Ofv" v-if="show">
      <div class="_9-ZpLxb0">
        <img
          src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjA2IiBoZWlnaHQ9IjgwIiBmaWxsPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnIGNsaXAtcGF0aD0idXJsKCNjbGlwMF8yMjk3XzE3MzQzKSIgZmlsbD0iI2ZmZiI+PHBhdGggZD0iTTY2Ljg1MiAyNC41NGMyLjI3MiAwIDQuMjQxIDEuNDI1IDQuNzQyIDMuNDMybDIuNjcgMTAuNjkyIDQuMzIzLTExLjE3N2MuNjgzLTEuNzY2IDIuNTIzLTIuOTQ4IDQuNTg5LTIuOTQ4aDcuNTM0bC0xMy4wNTIgMzQuNWMtMS40MTUgMy43NC01LjI5NiA2LjI1LTkuNjYgNi4yNWgtOS41NHYtMi43NDdjMC0yLjM0OSAyLjAzNC00LjI4NCA0LjYyMy00LjQgMS43MjEtLjA3NiAyLjc3Mi0uMjA3IDMuMTUxLS4zOTIuNjQ2LS4zMTYgMS4yNzEtMS41MyAxLjg3NC0zLjY0TDU5LjM5IDI0LjU0aDcuNDYzem0zMi4xNzUgMGEyLjc3IDIuNzcgMCAwMTEuOTc0Ljc2NWMuNTA3LjQ5OC43NTcgMS4xNjkuNjg2IDEuODQzbC0xLjYxMiAxOC45NGMtLjEyNyAxLjUuMTI5IDIuMTExLjc2NSAyLjU1NC40MzMuMjQuOTM2LjM1NyAxLjQ0My4zMzNhMi44NzQgMi44NzQgMCAwMDEuNDk5LS4zMzNjMS4wMjctLjU1NSAxLjE4My0xLjY2NSAxLjI2My0yLjYxbDEuNTk2LTE4Ljg4M2MuMTQ0LTEuNDYgMS40ODItMi41ODcgMy4xMDEtMi42MWg3LjQ3OWwtMi41MDQgMjkuNjAxLTEwLjM0Ni0uMDA3LjI1Mi0yLjk5OWMtLjczNi43My0xLjE0MSAxLjI1OC0xLjkwOSAxLjgzNy0xLjcyNyAxLjMwMS0zLjE1OCAxLjgyOS01LjQ4NyAxLjgyOS01LjM5NSAwLTYuOTA1LTMuMTY0LTcuMzYyLTQuOTk3LS4yNjktMS4wNTYtLjMxNC0yLjExLS4xMi00LjM4MWwxLjc2NC0yMC44ODNoNy41MTh6bS02MS45ODMgMi45NGMzLjY4My0yLjYwOCA5LjAwMy0zLjYyNCAxMi4wNzQtMy40NjIgNy41OTYuNCAxMS41MzkgNC42NzQgMTEuMDIyIDkuODM0LS42NzIgNi43MDUtOC4zNzUgNy43MzMtMTEuMDIyIDguMDU4LTMuNzcyLjQ2My02LjU4MiAxLjQ5Ni04LjQzMiAzLjEtMS40MjktNS40ODQgMS40Ni04Ljc3IDguNjY4LTkuODU2Ljk4LS4xNDggMy4yNTctLjU3MyAzLjM5My0yLjUzNC4xMzYtMS45Ni0yLjY0MS0zLjUzNC02LjQyOC0yLjU0LTQuNjg4IDEuMjMxLTcuMjc0IDUuMTY0LTcuOTc2IDguMzY5LS43MDMgMy4yMDQtLjYwNCA4LjQ2MSA1LjA3IDguNjA5IDUuNzcuMTUgMTIuNTg2LTMuMzczIDE0Ljg5OC00LjY3NGwuMTg1LS4xMDVjLjI4OS0uMTY1LjQ4Ni0uMjgyLjU3NS0uMzM2bC4wNS0uMDNjLTMuMjA0IDUuODMyLTcuNTc1IDguMDE4LTcuNTc1IDguMDE4IDEuNzUzLjgzNiA1Ljc1Mi40ODUgNi4wOS40NTNsLjAyMi0uMDAyYy0xLjc5NCAyLjU1Ny0xMS41MTUgNi4yOS0xOS45OTkgMS42OS04LjMxNC00LjUwNi01Ljg0NC0xMy4yNy01Ljc0Ny0xMy42MTNsLjAwMi0uMDFjLTEuMzIgMS4zNDUtMi42MjIgMy45MzQtMi44MTIgNC4yOTFsLS4wMi4wMzdjLS4zMTktNS43MjIgMy40MzgtMTIuMDkzIDcuOTYyLTE1LjI5N3ptLTkuOTQ5LTEyLjU1NGEyLjc2NyAyLjc2NyAwIDAxMS45NzQuNzY1Yy41MDguNDk4Ljc1NyAxLjE2OS42ODYgMS44NDRMMjYuNjYgNTQuMTMzaC03LjYwMmEyLjc2NiAyLjc2NiAwIDAxLTEuOTc5LS43NjJjLS41MS0uNDk4LS43Ni0xLjE2OS0uNjg5LTEuODQ1bDMuMTA0LTM2LjZoNy42MDF6TTQ5LjAwNCAzMS4zOGMuNjQgMCAxLjE2LjQ3IDEuMTYgMS4wNTFzLS41MiAxLjA1Mi0xLjE2IDEuMDUyYy0uNjQxIDAtMS4xNi0uNDcxLTEuMTYtMS4wNTIgMC0uNTguNTE5LTEuMDUxIDEuMTYtMS4wNTF6TTE2OS44NTUgNDAuNzU4djIuMDU0aDMuMDEydi44MjVoLS43ODhjLjExIDMuNzIuMzc4IDcuMzIyLjc4OCAxMC44NTNoLTIuMDY2Yy0uNDEtMy41NzQtLjYxNS03LjE3Ny0uNzQxLTEwLjg1M2gtLjIwNXY5LjAwMWguNjE1di44MjVoLS42MTV2MS4wMTNoLTMuNDM4di0xLjAxM2gtLjU2OHYtLjgyNWguNTY4di05aC0uMjA1YTE1Mi43NSAxNTIuNzUgMCAwMS0uNzQxIDEwLjg1MmgtMi4wNjZjLjM5NC0zLjUzLjY0Ny03LjEzNC43NzMtMTAuODUzaC0uNzg5di0uODI1aDMuMDI4di0yLjA1NGgzLjQzOHptLTYuNzE4LS4wMTVjLS4xNzQgMS41NDgtLjQyNiAzLjA4Mi0uODA0IDQuNTczaC41MDR2OS4xNmgtMy40NTNWNDguMDhoLTEuNDJjLjg2OC0yLjU0NyAxLjQzNS00Ljk5MyAxLjY4OC03LjMzN2gzLjQ4NXptMjQuMDM0IDYuMTA3Yy41ODMgMCAxLjA0MS40MzQgMS4wNDEuOTU1djUuNzE2YzAgLjUyLS40NTguOTU1LTEuMDQxLjk1NWgtMy42MTJ2LS44MjVoLjQ1OGMuMzMxIDAgLjU5OS0uMjQ2LjU5OS0uNTV2LS41MzVoLTUuMjk5djEuOTFoLTMuNTk1di02LjY3MWMwLS41MjEuNDU3LS45NTUgMS4wNC0uOTU1aDEwLjQwOXptLTQ3LjYxMS02LjA3OGMtLjIzNi45NC0uOTE0IDEuMzc1LTIuMjg2IDEuMzc1aC03Ljk2NGMtLjMzMiAwLS42LjI0Ni0uNi41NXYzLjI0MWMwIC4zMDQuMjY4LjU1LjYuNTVoMS4yMTR2LTMuMjQyaDMuNTk1djMuMjQyaDUuMDE1di44MjVoLTUuMDE1djYuMTkzYzAgLjUzNi0uNDczLjk1NS0xLjA1Ni45NTVoLTMuOTExdi0uODI1aC43NzNjLjMzMSAwIC41OTktLjI0NS41OTktLjU1di01Ljc3M2gtNC4wNTNjLS41OTkgMC0xLjA1Ny0uNDItMS4wNTctLjk1NXYtNC4wODFjMC0uNTIxLjQ1OC0uOTU1IDEuMDU3LS45NTVoNy43NDVjLjgzMS0uMDA1IDEuMjc1LS4wNjggMS41NzUtLjU1aDMuNzY5em0xNi43NDggMTIuNzYzdi44MjVIMTQxLjM5di0uODI1aDE0LjkxOHptLTI2Ljk2Ny01LjMyNWMtLjI4NCAyLjA3LS43NDEgNC4wMzctMS40MTkgNS45MDRoLTMuMDZhMjcuNTA4IDI3LjUwOCAwIDAwMS40NjctNS45MDRoMy4wMTJ6bTguOTU4IDBjLjI2OCAyLjAxMS43NTcgMy45OCAxLjQ2NiA1LjkwNGgtMy4wNTljLS42NzgtMS44NjctMS4xMzYtMy44MzUtMS40Mi01LjkwNGgzLjAxM3ptOC44OTQtNy40ODFhMTUuNDYgMTUuNDYgMCAwMS0uMzMxIDEuMzNoNi40MThjLjYxNSAwIDEuMDI1LjUzNi44MzYgMS4xYTE1LjEyNSAxNS4xMjUgMCAwMS0uODk5IDEuOTU0aC43ODljLjU4MyAwIDEuMDQxLjQyIDEuMDQxLjk1NXY1Ljg5YzAgLjUzNS0uNDU4Ljk1NS0xLjA0MS45NTVoLTEwLjMzYy0uNTY3IDAtMS4wNDEtLjQyLTEuMDQxLS45NTV2LTUuODljMC0uNTM1LjQ3NC0uOTU1IDEuMDQxLS45NTVoNi4wMDljLjM2Mi0uNjM2LjU5OS0xLjE3Mi45My0xLjg1Mi4wNzktLjE3NC0uMDYzLS4zNzYtLjI2OC0uMzc2aC0zLjc2OWExMC41MDcgMTAuNTA3IDAgMDEtLjc3MyAxLjYyaC0zLjUxNmMuNzg4LTEuMjg3IDEuMjQ1LTIuNDg5IDEuNTkyLTMuNzc2aDMuMzEyem00LjQxNiA4Ljc4M2gtMS4xMnYyLjU3NmguNTJjLjMzMiAwIC42LS4yNDYuNi0uNTV2LTIuMDI2em0tNC40MTYgMGgtMS4xMnYyLjAyNmMwIC4zMDQuMjY4LjU1LjYuNTVoLjUydi0yLjU3NnptMzcuNDIzLjU2NWgtNS4yOTl2MS42NjRoNS4yOTl2LTEuNjY0em0tLjU5OS0yLjQwMmgtNC4xYy0uMzMyIDAtLjYuMjQ2LS42LjU1djEuMDI3aDUuMjk5di0xLjAyOGMwLS4zMDMtLjI2OC0uNTUtLjU5OS0uNTV6bS0zNi44MjQtMS43MzdoLS41MmMtLjMzMiAwLS42LjI0Ni0uNi41NXYyLjJoMS4xMnYtMi43NXptMy44MTYgMGgtLjUydjIuNzVoMS4xMnYtMi4yYzAtLjMwNC0uMjY4LS41NS0uNi0uNTV6bTMyLjc1NS01LjE2NnYuOTdoNS42NjJ2LjgyNEgxODAuOGwtMS4zODggMi4yYy0uMDYzLjEwMS0uMDk1LjIwMy0uMDQ3LjMwNGEuMjg4LjI4OCAwIDAwLjI2OC4xNzNoNC44MjVhLjMwNi4zMDYgMCAwMC4yNjgtLjE3M2MuMDQ4LS4wODcuMDMyLS4xODgtLjAzMS0uMjlsLS43NDEtMS4yODhoMy42MTFsMS4wMDkgMS42OTRhLjU0Ny41NDcgMCAwMS4wNDguNTc4LjYyMi42MjIgMCAwMS0uNTM2LjI5aC0xMi4yNTRhLjYyNC42MjQgMCAwMS0uNTUyLS4zMzNjLS4wNzktLjE4OC0uMDE2LS40MDUuMTI2LS41OTNsMS42NC0yLjU2MmgtMi41Mzl2LS44MjRoNS42NjJ2LS45N2gzLjU5NXptLTI0LjY3OS0xNi4yNzZjLjM4NyAwIC43NDcuMTc3Ljk1Ny40NzJsMy40OTUgNC45MDggMy4zMzktNC44OTJhMS4xNyAxLjE3IDAgMDEuOTY4LS40ODhoMy45MjRsLTYuNDI5IDkuNDE1djMuMDgxYzAgLjQ0Ny0uMzE4Ljg0My0uNzg4Ljk4bC0yLjg5NS44NXYtNC44OGwtNi40OTktOS40NDZoMy45Mjh6bS02Ljg5OC4wM2wtLjk1NSAyLjk2NWgtNy44NjN2Mi43MzFoOC4yODFsLS44MTcgMi42N2gtNy40NjR2Mi43NWg4LjgxOGwtLjcxNCAyLjE3OGMtLjE0My40MzctLjU4Ny43MzctMS4wOTEuNzM3aC0xMC43ODV2LTEzLjE3YzAtLjQ3Ni40MjUtLjg2Ljk0OS0uODZoMTEuNjQxem0zNS4yNzgtLjE0Yy42MjggMCAxLjEzOC40NjIgMS4xMzggMS4wMzF2OC43MDhjMCAuNjE4LS4wNDggMS4xNS0uMTQ1IDEuNTk0LS4wOTYuNDQ1LS4yMDcuNzktLjMzMyAxLjAzNWEyLjg4MyAyLjg4MyAwIDAxLS40NjguNjYyIDIuNTk3IDIuNTk3IDAgMDEtLjU4Ny40NzRjLS4yMDYuMTE4LS41NzIuMjU4LTEuMS40MTctLjUyNy4xNi0xLjE1My4yNC0xLjg3Ni4yNGgtNS4yNTVjLS41NjQgMC0xLjA1OC0uMDctMS40ODMtLjIxYTUuODA5IDUuODA5IDAgMDEtMS4wMjUtLjQyNyAyLjYwMSAyLjYwMSAwIDAxLS42NDItLjQ5NCAzLjI5MiAzLjI5MiAwIDAxLS40NjMtLjY1NyA0LjUxNCA0LjUxNCAwIDAxLS4zNzMtMS4wMTRjLS4xMS0uNDIxLS4xNjQtLjk0OC0uMTY0LTEuNTh2LTkuNzRsMi41ODcuMDA2Yy42MjguMDAyIDEuMTM1LjQ2MyAxLjEzNSAxLjAzMVYzMi44YzAgLjU1Ny4wMTIuOTQ0LjAzNSAxLjE2Mi4wMjMuMjE3LjA5My40MjYuMjA5LjYyNi4xMTYuMi4zMTMuMzY3LjU5Mi41LjI3OS4xMzIuNjk3LjE5OCAxLjI1NC4xOThoMS45ODFjLjY1IDAgMS4wODEtLjA1IDEuMjk0LS4xNDguMjEyLS4wOTguNDAxLS4yMzIuNTY3LS40MDIuMTY2LS4xNy4yOS0uMzYuMzczLS41Ny4wODMtLjIxMS4xMjUtLjY0LjEyNS0xLjI4NHYtOC40ODhsMi42Mi0uMDA3aC4wMDR6bS02Mi42MDMuMTRsMi41OTguMDA3Yy42MjcuMDAyIDEuMTM1LjQ2MyAxLjEzNSAxLjAzMXY5LjY2MWw3LjYzNC0uMDItLjg5NiAyLjYwNmMtLjE0OC40MzItLjU4OS43MjUtMS4wODguNzI1bC05LjM4My0uMDF2LTE0eiIvPjwvZz48ZGVmcz48Y2xpcFBhdGggaWQ9ImNsaXAwXzIyOTdfMTczNDMiPjxwYXRoIGZpbGw9IiNmZmYiIHRyYW5zZm9ybT0idHJhbnNsYXRlKC41KSIgZD0iTTAgMGgyMDV2ODBIMHoiLz48L2NsaXBQYXRoPjwvZGVmcz48L3N2Zz4="
          alt="icon"
        />
        <div class="_3_qzGcRD"><span class="_1N8mCmac">-</span><span>B</span><span>O</span><span>B</span><span>.</span><span>C</span><span>O</span><span>M</span><span class="_1N8mCmac">-</span></div>
      </div>
    </div>
    <div class="_24vddGqv">
      <div class="wjHkeryU">
        <div class="_29gnuiyG animated fadeInUp" style="margin: 82px auto 71px">
          <div class="_35_vygsc">
            <h1 style="margin-top: -23px">电竞投注</h1>
            <h2>ESPORTS EVENTS</h2>
          </div>
          <!-- <div class="_2zJiZW9W">
            <div class="_349CzCYy xJQe3jRu _12ZkQT2g _3gi7jqcw" style="padding: 0px"><img class="_2JoosS9F" src="/static/image/ia.png" alt="" /><img class="_2JoosS9F hover" src="/static/image/ia-hover.png" alt="" /><span>小艾电竞</span></div>
            <div class="_349CzCYy xJQe3jRu _3gi7jqcw" style="padding: 0px"><img class="_2JoosS9F" src="/static/image/ld.png" alt="" /><img class="_2JoosS9F hover" src="/static/image/ld-hover.png" alt="" /><span>雷火电竞</span></div>
            <div class="_349CzCYy xJQe3jRu _3gi7jqcw" style="padding: 0px"><img class="_2JoosS9F" src="/static/image/12.png" alt="" /><img class="_2JoosS9F hover" src="/static/image/12-hover.png" alt="" /><span>泛亚电竞</span></div>
            <div class="_349CzCYy xJQe3jRu _3gi7jqcw" style="padding: 0px"><img class="_2JoosS9F" src="/static/image/ob.png" alt="" /><img class="_2JoosS9F hover" src="/static/image/ob-hover.png" alt="" /><span>OB电竞</span></div>
          </div> -->
          <div class="_2zJiZW9W">
            <div @click="changplatform_name(item.platform_name)" :class="platform_name == item.platform_name ? '_349CzCYy xJQe3jRu _3gi7jqcw _12ZkQT2g' : '_349CzCYy xJQe3jRu _3gi7jqcw'" v-for="(item, index) in gameList" :key="index" v-if="item.app_state == 1" style="padding: 0px">
              <img class="_2JoosS9F"  v-if="imgList[item.platform_name]" :src="imgList[item.platform_name]['img']" alt="" /><img class="_2JoosS9F hover"  v-if="imgList[item.platform_name]" :src="imgList[item.platform_name]['hover']" alt="" /><span>{{item.name}}</span>
            </div>
          </div>
        </div>
        <div class="h851vWpX" v-for="(item, index) in gameList" :key="index" v-if=" item.platform_name == platform_name">
          <div class="_1UE-ldYw"><img  v-if="imgList[item.platform_name]" :src="imgList[item.platform_name]['title']" class="oZtthmYX" /></div>
          <div class="_3bdNR9wu">
            <div class="Kyf8M7_8">
              <div class="_1M4fs2nI"></div>
              <div>
                <div>滚球标杆 自由串关</div>
                <div class="_1unX-k3M">独家大量滚球盘口，让您感受世界级滚球魅力</div>
              </div>
            </div>
            <div class="Kyf8M7_8">
              <div class="_1M4fs2nI"></div>
              <div>
                <div>秒确认 秒结算 妙体验</div>
                <div class="_1unX-k3M">注单秒确认，大型热门赛事秒结算电竞化UI风格，顶级交互设计，给您绝妙畅爽体验</div>
              </div>
            </div>
            <img class="B2lGJAHD" src="/static/image/pic7.png" style="height: 44px" />
            <div class="_2LINmtV0">
              <!-- plat_name=ia&game_type=2 -->
              <div v-if="item.app_state == 1" class="_349CzCYy xJQe3jRu _hPM8cbq" @click="goGamePage(item.platform_name, item.game_code == null ? 0 : item.game_code, '')" style="border-radius: 25vh"><span>立即游戏</span></div>
              <div v-else class="_349CzCYy xJQe3jRu _hPM8cbq" style="border-radius: 25vh"><span>维护中</span></div>
            
            </div>
          </div>
          <div class="_3efekQzm">
            <img class="_1daGKxbJ _2x8Pq0NA" src="/static/image/bg_bob_02-bda0.png" /><img class="_1daGKxbJ ls-is-cached" src="/static/image/bg_bob_01-596e.png" />
            <div class="_1gXTPMRQ"><img class="_2vyEl2F2 ls-is-cached" src="/static/image/esports_ej_img_bob-f2ac.png" /></div>
            <img class="_3g2fFXQz _3mdBM6t-" src="/static/image/pic12.png" /><img class="_1T-KBsyv _3mdBM6t-" src="/static/image/pic13.png" />
          </div>
        </div>
        <div class="h851vWpX" style="display: none">
          <div class="_1UE-ldYw"><img src="/static/image/img_ia_title.png" class="oZtthmYX" /></div>
          <div class="_3bdNR9wu">
            <div class="Kyf8M7_8">
              <div class="_1M4fs2nI"></div>
              <div>
                <div>滚球标杆 自由串关</div>
                <div class="_1unX-k3M">独家大量滚球盘口，让您感受世界级滚球魅力</div>
              </div>
            </div>
            <div class="Kyf8M7_8">
              <div class="_1M4fs2nI"></div>
              <div>
                <div>秒确认 秒结算 妙体验</div>
                <div class="_1unX-k3M">注单秒确认，大型热门赛事秒结算电竞化UI风格，顶级交互设计，给您绝妙畅爽体验</div>
              </div>
            </div>
            <img class="B2lGJAHD" src="/static/image/pic7.png" style="height: 44px" />
            <div class="_2LINmtV0">
              <!-- plat_name=ia&game_type=2 -->
              <div class="_349CzCYy xJQe3jRu _hPM8cbq" @click="goGamePage('ia', '2', '')" style="border-radius: 25vh"><span>立即游戏</span></div>
            </div>
          </div>
          <div class="_3efekQzm">
            <img class="_1daGKxbJ _2x8Pq0NA" src="/static/image/bg_bob_02-bda0.png" /><img class="_1daGKxbJ ls-is-cached" src="/static/image/bg_bob_01-596e.png" />
            <div class="_1gXTPMRQ"><img class="_2vyEl2F2 ls-is-cached" src="/static/image/esports_ej_img_bob-f2ac.png" /></div>
            <img class="_3g2fFXQz _3mdBM6t-" src="/static/image/pic12.png" /><img class="_1T-KBsyv _3mdBM6t-" src="/static/image/pic13.png" />
          </div>
        </div>
        <div class="h851vWpX" style="display: none">
          <div class="_1UE-ldYw"><img src="/static/image/img_ld_title-.png" class="oZtthmYX" /></div>
          <div class="_3bdNR9wu">
            <div class="Kyf8M7_8">
              <div class="_1M4fs2nI"></div>
              <div>
                <div>赛事全面 结算快捷</div>
                <div class="_1unX-k3M">每日提供上百场丰富的电竞赛事，结算快捷、玩法多元，盘内赛事直播让您分秒精彩</div>
              </div>
            </div>
            <div class="Kyf8M7_8">
              <div class="_1M4fs2nI"></div>
              <div>
                <div>专业数据 尽在掌握</div>
                <div class="_1unX-k3M">盘内赛事分析、数据统计、实时更新的战况记录，使您运筹帷幄之中决胜千里之外</div>
              </div>
            </div>
            <img class="B2lGJAHD" src="/static/image/img_eports_icons-4dc3.png" style="height: 44px" />
            <div class="_2LINmtV0">
              <!-- http://mb2.tg-demo.cc:86/member/game?plat_name=ld&game_type=2 -->
              <div class="_349CzCYy xJQe3jRu _hPM8cbq" @click="goGamePage('ld', '2', '')" style="border-radius: 25vh"><span>立即游戏</span></div>
            </div>
          </div>
          <div class="_3efekQzm">
            <img class="_1daGKxbJ _2x8Pq0NA" src="/static/image/bg_im_hover-f111.png" /><img class="_1daGKxbJ ls-is-cached lazyloaded" src="/static/image/bg_im-869a.png" data-src="/static/image/bg_im-869a.png" />
            <div class="_1gXTPMRQ" style="transform: perspective(3000px) rotateX(0deg) rotateY(0deg) scale3d(1, 1, 1)"><img class="_2vyEl2F2 lazyloaded" src="/static/image/img_lol_player-adac.png" data-src="/static/image/img_lol_player-adac.png" /></div>
            <img class="_3g2fFXQz _3mdBM6t-" src="/static/image/pic8.png" /><img class="_1T-KBsyv _3mdBM6t-" src="/static/image/pic9.png" />
          </div>
        </div>
        <div class="h851vWpX" style="display: none">
          <div class="_1UE-ldYw"><img src="/static/image/img_avia_title.png" class="oZtthmYX" /></div>
          <div class="_3bdNR9wu">
            <div class="Kyf8M7_8">
              <div class="_1M4fs2nI"></div>
              <div>
                <div>顶尖平台 开拓创新</div>
                <div class="_1unX-k3M">20+款超人气游戏、S系列、Ti系列，全球顶尖赛事全覆盖，提供专业赔率数据，结算赛果实时快捷</div>
              </div>
            </div>
            <div class="Kyf8M7_8">
              <div class="_1M4fs2nI"></div>
              <div>
                <div>以客为尊 用心感受</div>
                <div class="_1unX-k3M">盘内提供英雄时时乐独特玩法，激情不间断，比赛之余小憩更精彩</div>
              </div>
            </div>
            <img class="B2lGJAHD" src="/static/image/img_eports_icons-4dc3.png" style="height: 44px" />
            <div class="_2LINmtV0">
              <div class="_349CzCYy xJQe3jRu _hPM8cbq" @click="goGamePage('avia', '2', '')" style="border-radius: 25vh"><span>立即游戏</span></div>
            </div>
          </div>
          <div class="_3efekQzm">
            <img class="_1daGKxbJ _2x8Pq0NA" src="/static/image/bg_avia_hover-58e3.png" /><img class="_1daGKxbJ ls-is-cached" src="/static/image/bg_avia-a4b8.png" />
            <div class="_1gXTPMRQ"><img class="_2vyEl2F2" src="/static/image/img_king_player-027c.png" /></div>
            <img class="_3g2fFXQz _3mdBM6t-" src="/static/image/pic10.png" /><img class="_1T-KBsyv _3mdBM6t-" src="/static/image/pic11.png" />
          </div>
        </div>
        <div class="h851vWpX" style="display: none">
          <div class="_1UE-ldYw"><img src="/static/image/img_obdj_title.png" class="oZtthmYX" /></div>
          <div class="_3bdNR9wu">
            <div class="Kyf8M7_8">
              <div class="_1M4fs2nI"></div>
              <div>
                <div>顶尖平台 开拓创新</div>
                <div class="_1unX-k3M">20+款超人气游戏、S系列、Ti系列，全球顶尖赛事全覆盖，提供专业赔率数据，结算赛果实时快捷</div>
              </div>
            </div>
            <div class="Kyf8M7_8">
              <div class="_1M4fs2nI"></div>
              <div>
                <div>以客为尊 用心感受</div>
                <div class="_1unX-k3M">盘内提供英雄时时乐独特玩法，激情不间断，比赛之余小憩更精彩</div>
              </div>
            </div>
            <img class="B2lGJAHD" src="/static/image/img_eports_icons-4dc3.png" style="height: 44px" />
            <div class="_2LINmtV0">
              <div class="_349CzCYy xJQe3jRu _hPM8cbq" @click="goGamePage('obgdj', '2', '')" style="border-radius: 25vh"><span>立即游戏</span></div>
            </div>
          </div>
          <div class="_3efekQzm">
            <img class="_1daGKxbJ _2x8Pq0NA" src="/static/image/bg_avia_hover-58e3.png" /><img class="_1daGKxbJ ls-is-cached" src="/static/image/bg_avia-a4b8.png" />
            <div class="_1gXTPMRQ"><img class="_2vyEl2F2 ls-is-cached" src="/static/image/esports_ej_img_bob-f2ac.png" /></div>

            <img class="_3g2fFXQz _3mdBM6t-" src="/static/image/pic10.png" /><img class="_1T-KBsyv _3mdBM6t-" src="/static/image/pic11.png" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { MessageBox } from 'element-ui';
export default {
  name: 'electronic',
  data() {
    return {
      jumpUrl: null,
      gameList: [],
      show: false,
      platform_name: '',
      imgList: {
        ia: { img: '/static/image/sbty.png', hover: '/static/image/sbty_hover.png', title: '/static/image/img_ia_title.png' },
        ld: { img: '/static/image/ld.png', hover: '/static/image/ld-hover.png', title: '/static/image/img_ld_title-.png' },
        avia: { img: '/static/image/12.png', hover: '/static/image/12-hover.png', title: '/static/image/img_avia_title.png' },
        obgdj: { img: '/static/image/ob.png', hover: '/static/image/ob-hover.png', title: '/static/image/img_obdj_title.png' },
      },
    };
  },
  created() {
    let that = this;
    that.getGameList();
  },
  methods: {
    changplatform_name(val) {
      this.platform_name = val;
    },
    getGameList() {
      let that = this;
      that.show = true;
      that.$apiFun.get('/api/game/list', { category: 'gaming' }).then(res => {
        if (res.code == 200) {
          that.gameList = res.data;
          that.show = false;
          let arr = that.gameList;
          for (let i in arr) {
            if (arr[i]['app_state'] == 1) {
              that.platform_name = arr[i]['platform_name'];
              return;
            }
          }
        }
      });
    },
    goGamePage(name, type, code) {
      let that = this;
      let token = sessionStorage.getItem('token') ? sessionStorage.getItem('token') : '';
      if (!token) {
        that.$parent.openShow();
        return;
      }
      that.showTost('正在前往打开游戏页面');
      type = type ||  0 ;
      that.$apiFun.post('/api/getGameUrl', { plat_name: name, game_type: type, game_code: code, is_mobile_url: 0 }).then(res => {
        console.log(res);
        if (res.code == 501) {
            that.$confirm(res.message, '提示', {
  confirmButtonText: '前往转账',
  cancelButtonText: '先逛逛',
  type: 'warning'
})
  .then(() => {
    this.$router.push({ path: "/mine/transfer" });
  })
  .catch(() => {
      that.jumpUrl = res.data.url;
  });
        }else{
            if (res.code == 200) {
          that.jumpUrl = res.data.url;
        }else
            that.showTost(res.message);
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
  mounted() {
    //场馆切换
    $('._2zJiZW9W ._349CzCYy').click(function () {
      var index = $(this).index();
      $(this).addClass('_12ZkQT2g').siblings().removeClass('_12ZkQT2g');
      $('.h851vWpX').eq(index).show().siblings('.h851vWpX').hide();
    });
    // $('._3efekQzm').hover(
    //   function () {
    //     $(this).find('._3g2fFXQz,._1T-KBsyv').removeClass('_3mdBM6t-');
    //     $(this).find('._1daGKxbJ:not(.ls-is-cached)').removeClass('_2x8Pq0NA');
    //     $(this).find('._2vyEl2F2').css({ transform: 'scale3d(1.05, 1.05, 1.05)', transition: 'all 0.3s' });
    //   },
    //   function () {
    //     $(this).find('._3g2fFXQz,._1T-KBsyv').addClass('_3mdBM6t-');
    //     $(this).find('._1daGKxbJ:not(.ls-is-cached)').addClass('_2x8Pq0NA');
    //     $(this).find('._2vyEl2F2').css('transform', 'scale3d(1, 1, 1)');
    //   },
    // );
    //设置左边界以便内容居中
    autoMargin();
    $(window).resize(function () {
      autoMargin();
    });
    function autoMargin() {
      var Width = $(window).width();
      var Margin = (Width - 1920) / 2 + 'px';
      $('.h851vWpX').css('margin-left', Margin);
    }
  },
  updated() {
    let that = this;
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
</style>
