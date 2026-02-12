<template>
  <div id="head">
    <div class="_2jLZUYlV">
      <div class="_1SI39Ofv" v-if="show">
        <div class="_9-ZpLxb0">
          <img
            src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjA2IiBoZWlnaHQ9IjgwIiBmaWxsPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnIGNsaXAtcGF0aD0idXJsKCNjbGlwMF8yMjk3XzE3MzQzKSIgZmlsbD0iI2ZmZiI+PHBhdGggZD0iTTY2Ljg1MiAyNC41NGMyLjI3MiAwIDQuMjQxIDEuNDI1IDQuNzQyIDMuNDMybDIuNjcgMTAuNjkyIDQuMzIzLTExLjE3N2MuNjgzLTEuNzY2IDIuNTIzLTIuOTQ4IDQuNTg5LTIuOTQ4aDcuNTM0bC0xMy4wNTIgMzQuNWMtMS40MTUgMy43NC01LjI5NiA2LjI1LTkuNjYgNi4yNWgtOS41NHYtMi43NDdjMC0yLjM0OSAyLjAzNC00LjI4NCA0LjYyMy00LjQgMS43MjEtLjA3NiAyLjc3Mi0uMjA3IDMuMTUxLS4zOTIuNjQ2LS4zMTYgMS4yNzEtMS41MyAxLjg3NC0zLjY0TDU5LjM5IDI0LjU0aDcuNDYzem0zMi4xNzUgMGEyLjc3IDIuNzcgMCAwMTEuOTc0Ljc2NWMuNTA3LjQ5OC43NTcgMS4xNjkuNjg2IDEuODQzbC0xLjYxMiAxOC45NGMtLjEyNyAxLjUuMTI5IDIuMTExLjc2NSAyLjU1NC40MzMuMjQuOTM2LjM1NyAxLjQ0My4zMzNhMi44NzQgMi44NzQgMCAwMDEuNDk5LS4zMzNjMS4wMjctLjU1NSAxLjE4My0xLjY2NSAxLjI2My0yLjYxbDEuNTk2LTE4Ljg4M2MuMTQ0LTEuNDYgMS40ODItMi41ODcgMy4xMDEtMi42MWg3LjQ3OWwtMi41MDQgMjkuNjAxLTEwLjM0Ni0uMDA3LjI1Mi0yLjk5OWMtLjczNi43My0xLjE0MSAxLjI1OC0xLjkwOSAxLjgzNy0xLjcyNyAxLjMwMS0zLjE1OCAxLjgyOS01LjQ4NyAxLjgyOS01LjM5NSAwLTYuOTA1LTMuMTY0LTcuMzYyLTQuOTk3LS4yNjktMS4wNTYtLjMxNC0yLjExLS4xMi00LjM4MWwxLjc2NC0yMC44ODNoNy41MTh6bS02MS45ODMgMi45NGMzLjY4My0yLjYwOCA5LjAwMy0zLjYyNCAxMi4wNzQtMy40NjIgNy41OTYuNCAxMS41MzkgNC42NzQgMTEuMDIyIDkuODM0LS42NzIgNi43MDUtOC4zNzUgNy43MzMtMTEuMDIyIDguMDU4LTMuNzcyLjQ2My02LjU4MiAxLjQ5Ni04LjQzMiAzLjEtMS40MjktNS40ODQgMS40Ni04Ljc3IDguNjY4LTkuODU2Ljk4LS4xNDggMy4yNTctLjU3MyAzLjM5My0yLjUzNC4xMzYtMS45Ni0yLjY0MS0zLjUzNC02LjQyOC0yLjU0LTQuNjg4IDEuMjMxLTcuMjc0IDUuMTY0LTcuOTc2IDguMzY5LS43MDMgMy4yMDQtLjYwNCA4LjQ2MSA1LjA3IDguNjA5IDUuNzcuMTUgMTIuNTg2LTMuMzczIDE0Ljg5OC00LjY3NGwuMTg1LS4xMDVjLjI4OS0uMTY1LjQ4Ni0uMjgyLjU3NS0uMzM2bC4wNS0uMDNjLTMuMjA0IDUuODMyLTcuNTc1IDguMDE4LTcuNTc1IDguMDE4IDEuNzUzLjgzNiA1Ljc1Mi40ODUgNi4wOS40NTNsLjAyMi0uMDAyYy0xLjc5NCAyLjU1Ny0xMS41MTUgNi4yOS0xOS45OTkgMS42OS04LjMxNC00LjUwNi01Ljg0NC0xMy4yNy01Ljc0Ny0xMy42MTNsLjAwMi0uMDFjLTEuMzIgMS4zNDUtMi42MjIgMy45MzQtMi44MTIgNC4yOTFsLS4wMi4wMzdjLS4zMTktNS43MjIgMy40MzgtMTIuMDkzIDcuOTYyLTE1LjI5N3ptLTkuOTQ5LTEyLjU1NGEyLjc2NyAyLjc2NyAwIDAxMS45NzQuNzY1Yy41MDguNDk4Ljc1NyAxLjE2OS42ODYgMS44NDRMMjYuNjYgNTQuMTMzaC03LjYwMmEyLjc2NiAyLjc2NiAwIDAxLTEuOTc5LS43NjJjLS41MS0uNDk4LS43Ni0xLjE2OS0uNjg5LTEuODQ1bDMuMTA0LTM2LjZoNy42MDF6TTQ5LjAwNCAzMS4zOGMuNjQgMCAxLjE2LjQ3IDEuMTYgMS4wNTFzLS41MiAxLjA1Mi0xLjE2IDEuMDUyYy0uNjQxIDAtMS4xNi0uNDcxLTEuMTYtMS4wNTIgMC0uNTguNTE5LTEuMDUxIDEuMTYtMS4wNTF6TTE2OS44NTUgNDAuNzU4djIuMDU0aDMuMDEydi44MjVoLS43ODhjLjExIDMuNzIuMzc4IDcuMzIyLjc4OCAxMC44NTNoLTIuMDY2Yy0uNDEtMy41NzQtLjYxNS03LjE3Ny0uNzQxLTEwLjg1M2gtLjIwNXY5LjAwMWguNjE1di44MjVoLS42MTV2MS4wMTNoLTMuNDM4di0xLjAxM2gtLjU2OHYtLjgyNWguNTY4di05aC0uMjA1YTE1Mi43NSAxNTIuNzUgMCAwMS0uNzQxIDEwLjg1MmgtMi4wNjZjLjM5NC0zLjUzLjY0Ny03LjEzNC43NzMtMTAuODUzaC0uNzg5di0uODI1aDMuMDI4di0yLjA1NGgzLjQzOHptLTYuNzE4LS4wMTVjLS4xNzQgMS41NDgtLjQyNiAzLjA4Mi0uODA0IDQuNTczaC41MDR2OS4xNmgtMy40NTNWNDguMDhoLTEuNDJjLjg2OC0yLjU0NyAxLjQzNS00Ljk5MyAxLjY4OC03LjMzN2gzLjQ4NXptMjQuMDM0IDYuMTA3Yy41ODMgMCAxLjA0MS40MzQgMS4wNDEuOTU1djUuNzE2YzAgLjUyLS40NTguOTU1LTEuMDQxLjk1NWgtMy42MTJ2LS44MjVoLjQ1OGMuMzMxIDAgLjU5OS0uMjQ2LjU5OS0uNTV2LS41MzVoLTUuMjk5djEuOTFoLTMuNTk1di02LjY3MWMwLS41MjEuNDU3LS45NTUgMS4wNC0uOTU1aDEwLjQwOXptLTQ3LjYxMS02LjA3OGMtLjIzNi45NC0uOTE0IDEuMzc1LTIuMjg2IDEuMzc1aC03Ljk2NGMtLjMzMiAwLS42LjI0Ni0uNi41NXYzLjI0MWMwIC4zMDQuMjY4LjU1LjYuNTVoMS4yMTR2LTMuMjQyaDMuNTk1djMuMjQyaDUuMDE1di44MjVoLTUuMDE1djYuMTkzYzAgLjUzNi0uNDczLjk1NS0xLjA1Ni45NTVoLTMuOTExdi0uODI1aC43NzNjLjMzMSAwIC41OTktLjI0NS41OTktLjU1di01Ljc3M2gtNC4wNTNjLS41OTkgMC0xLjA1Ny0uNDItMS4wNTctLjk1NXYtNC4wODFjMC0uNTIxLjQ1OC0uOTU1IDEuMDU3LS45NTVoNy43NDVjLjgzMS0uMDA1IDEuMjc1LS4wNjggMS41NzUtLjU1aDMuNzY5em0xNi43NDggMTIuNzYzdi44MjVIMTQxLjM5di0uODI1aDE0LjkxOHptLTI2Ljk2Ny01LjMyNWMtLjI4NCAyLjA3LS43NDEgNC4wMzctMS40MTkgNS45MDRoLTMuMDZhMjcuNTA4IDI3LjUwOCAwIDAwMS40NjctNS45MDRoMy4wMTJ6bTguOTU4IDBjLjI2OCAyLjAxMS43NTcgMy45OCAxLjQ2NiA1LjkwNGgtMy4wNTljLS42NzgtMS44NjctMS4xMzYtMy44MzUtMS40Mi01LjkwNGgzLjAxM3ptOC44OTQtNy40ODFhMTUuNDYgMTUuNDYgMCAwMS0uMzMxIDEuMzNoNi40MThjLjYxNSAwIDEuMDI1LjUzNi44MzYgMS4xYTE1LjEyNSAxNS4xMjUgMCAwMS0uODk5IDEuOTU0aC43ODljLjU4MyAwIDEuMDQxLjQyIDEuMDQxLjk1NXY1Ljg5YzAgLjUzNS0uNDU4Ljk1NS0xLjA0MS45NTVoLTEwLjMzYy0uNTY3IDAtMS4wNDEtLjQyLTEuMDQxLS45NTV2LTUuODljMC0uNTM1LjQ3NC0uOTU1IDEuMDQxLS45NTVoNi4wMDljLjM2Mi0uNjM2LjU5OS0xLjE3Mi45My0xLjg1Mi4wNzktLjE3NC0uMDYzLS4zNzYtLjI2OC0uMzc2aC0zLjc2OWExMC41MDcgMTAuNTA3IDAgMDEtLjc3MyAxLjYyaC0zLjUxNmMuNzg4LTEuMjg3IDEuMjQ1LTIuNDg5IDEuNTkyLTMuNzc2aDMuMzEyem00LjQxNiA4Ljc4M2gtMS4xMnYyLjU3NmguNTJjLjMzMiAwIC42LS4yNDYuNi0uNTV2LTIuMDI2em0tNC40MTYgMGgtMS4xMnYyLjAyNmMwIC4zMDQuMjY4LjU1LjYuNTVoLjUydi0yLjU3NnptMzcuNDIzLjU2NWgtNS4yOTl2MS42NjRoNS4yOTl2LTEuNjY0em0tLjU5OS0yLjQwMmgtNC4xYy0uMzMyIDAtLjYuMjQ2LS42LjU1djEuMDI3aDUuMjk5di0xLjAyOGMwLS4zMDMtLjI2OC0uNTUtLjU5OS0uNTV6bS0zNi44MjQtMS43MzdoLS41MmMtLjMzMiAwLS42LjI0Ni0uNi41NXYyLjJoMS4xMnYtMi43NXptMy44MTYgMGgtLjUydjIuNzVoMS4xMnYtMi4yYzAtLjMwNC0uMjY4LS41NS0uNi0uNTV6bTMyLjc1NS01LjE2NnYuOTdoNS42NjJ2LjgyNEgxODAuOGwtMS4zODggMi4yYy0uMDYzLjEwMS0uMDk1LjIwMy0uMDQ3LjMwNGEuMjg4LjI4OCAwIDAwLjI2OC4xNzNoNC44MjVhLjMwNi4zMDYgMCAwMC4yNjgtLjE3M2MuMDQ4LS4wODcuMDMyLS4xODgtLjAzMS0uMjlsLS43NDEtMS4yODhoMy42MTFsMS4wMDkgMS42OTRhLjU0Ny41NDcgMCAwMS4wNDguNTc4LjYyMi42MjIgMCAwMS0uNTM2LjI5aC0xMi4yNTRhLjYyNC42MjQgMCAwMS0uNTUyLS4zMzNjLS4wNzktLjE4OC0uMDE2LS40MDUuMTI2LS41OTNsMS42NC0yLjU2MmgtMi41Mzl2LS44MjRoNS42NjJ2LS45N2gzLjU5NXptLTI0LjY3OS0xNi4yNzZjLjM4NyAwIC43NDcuMTc3Ljk1Ny40NzJsMy40OTUgNC45MDggMy4zMzktNC44OTJhMS4xNyAxLjE3IDAgMDEuOTY4LS40ODhoMy45MjRsLTYuNDI5IDkuNDE1djMuMDgxYzAgLjQ0Ny0uMzE4Ljg0My0uNzg4Ljk4bC0yLjg5NS44NXYtNC44OGwtNi40OTktOS40NDZoMy45Mjh6bS02Ljg5OC4wM2wtLjk1NSAyLjk2NWgtNy44NjN2Mi43MzFoOC4yODFsLS44MTcgMi42N2gtNy40NjR2Mi43NWg4LjgxOGwtLjcxNCAyLjE3OGMtLjE0My40MzctLjU4Ny43MzctMS4wOTEuNzM3aC0xMC43ODV2LTEzLjE3YzAtLjQ3Ni40MjUtLjg2Ljk0OS0uODZoMTEuNjQxem0zNS4yNzgtLjE0Yy42MjggMCAxLjEzOC40NjIgMS4xMzggMS4wMzF2OC43MDhjMCAuNjE4LS4wNDggMS4xNS0uMTQ1IDEuNTk0LS4wOTYuNDQ1LS4yMDcuNzktLjMzMyAxLjAzNWEyLjg4MyAyLjg4MyAwIDAxLS40NjguNjYyIDIuNTk3IDIuNTk3IDAgMDEtLjU4Ny40NzRjLS4yMDYuMTE4LS41NzIuMjU4LTEuMS40MTctLjUyNy4xNi0xLjE1My4yNC0xLjg3Ni4yNGgtNS4yNTVjLS41NjQgMC0xLjA1OC0uMDctMS40ODMtLjIxYTUuODA5IDUuODA5IDAgMDEtMS4wMjUtLjQyNyAyLjYwMSAyLjYwMSAwIDAxLS42NDItLjQ5NCAzLjI5MiAzLjI5MiAwIDAxLS40NjMtLjY1NyA0LjUxNCA0LjUxNCAwIDAxLS4zNzMtMS4wMTRjLS4xMS0uNDIxLS4xNjQtLjk0OC0uMTY0LTEuNTh2LTkuNzRsMi41ODcuMDA2Yy42MjguMDAyIDEuMTM1LjQ2MyAxLjEzNSAxLjAzMVYzMi44YzAgLjU1Ny4wMTIuOTQ0LjAzNSAxLjE2Mi4wMjMuMjE3LjA5My40MjYuMjA5LjYyNi4xMTYuMi4zMTMuMzY3LjU5Mi41LjI3OS4xMzIuNjk3LjE5OCAxLjI1NC4xOThoMS45ODFjLjY1IDAgMS4wODEtLjA1IDEuMjk0LS4xNDguMjEyLS4wOTguNDAxLS4yMzIuNTY3LS40MDIuMTY2LS4xNy4yOS0uMzYuMzczLS41Ny4wODMtLjIxMS4xMjUtLjY0LjEyNS0xLjI4NHYtOC40ODhsMi42Mi0uMDA3aC4wMDR6bS02Mi42MDMuMTRsMi41OTguMDA3Yy42MjcuMDAyIDEuMTM1LjQ2MyAxLjEzNSAxLjAzMXY5LjY2MWw3LjYzNC0uMDItLjg5NiAyLjYwNmMtLjE0OC40MzItLjU4OS43MjUtMS4wODguNzI1bC05LjM4My0uMDF2LTE0eiIvPjwvZz48ZGVmcz48Y2xpcFBhdGggaWQ9ImNsaXAwXzIyOTdfMTczNDMiPjxwYXRoIGZpbGw9IiNmZmYiIHRyYW5zZm9ybT0idHJhbnNsYXRlKC41KSIgZD0iTTAgMGgyMDV2ODBIMHoiLz48L2NsaXBQYXRoPjwvZGVmcz48L3N2Zz4="
            alt="icon"
          />
          <div class="_3_qzGcRD"><span class="_1N8mCmac">-</span><span>B</span><span>O</span><span>B</span><span>.</span><span>C</span><span>O</span><span>M</span><span class="_1N8mCmac">-</span></div>
        </div>
      </div>
      <div class="_21_IWk7T" v-show="pcCategoriesLoaded">
        <div class="nRE1dUST">
          <div class="_6XowEZMC" @click="goNav('/')">
            <a href="javascript:;">
              <img :src="$store.state.appInfo.site_logo " v-if="$store.state.appInfo.site_logo" class="_2LPmZ99H" alt="" />
              <img src="/static/image/logo.png" v-else class="_2LPmZ99H" alt="" />
            </a>
          </div>
          <div class="X_9C3y3f nav-scroll-container">
            <div class="_9eNaWz24">
              <a aria-current="page" @click="goNav('/')" :class="url == '/' ? '_5v-zJhSB _--jQI_nz' : '_5v-zJhSB '" href="javascript:;"
                >首页
                <div class="P4bUdpZY"><span></span><span></span></div>
              </a>
            </div>
            <!-- 动态导航菜单 - 从API获取分类数据 -->
            <template v-if="pcCategoriesLoaded && pcCategories.length > 0">
              <div class="_9eNaWz24 nav" v-for="(category, catIndex) in mainCategoryList" :key="'cat-' + category.id" @mouseenter="showDropdown($event, category)" @mouseleave="hideDropdown($event)">
                <a @click="onCategoryClick(category.code, category.banner)" :class="isCategoryActive(category.code) ? '_5v-zJhSB _--jQI_nz' : '_5v-zJhSB'" href="javascript:;">
                  {{ category.name }}
                  <div class="_17Hw2tUT" v-if="category.game_nav && category.game_nav.length > 0"></div>
                  <div class="P4bUdpZY _3hNI-m60"><span></span><span></span></div>
                </a>
                <div class="PjlHS4wt category-dropdown-popup" style="display: none;">
                  <div class="category-popup-wrapper">
                    <div class="category-popup-container">
                      <div 
                        class="category-popup-content" 
                        v-for="(gameNav, navIndex) in (category.game_nav || [])" 
                        :key="'game-nav-' + category.id + '-' + navIndex"
                        @click="onCategoryPopupClick(gameNav)" 
                        style="cursor: pointer;"
                      >
                      <!-- 第一行：官方/推荐标签、高达X%、无限返水/上不封顶 -->
                      <div class="category-popup-header">
                        <span class="official-tag" v-if="gameNav.is_official || gameNav.tag === 'official'">官方</span>
                        <span class="official-tag" v-else-if="gameNav.is_recommended || gameNav.tag === 'recommended'">推荐</span>
                        <span class="rebate-text" v-if="gameNav.rebate || gameNav.rate">高达 {{ gameNav.rebate || gameNav.rate }}%</span>
                        <span class="unlimited-rebate" v-if="gameNav.unlimited_rebate !== false">无限返水</span>
                        <span class="unlimited-rebate" v-if="gameNav.no_limit">上不封顶</span>
                          </div>
                      <!-- 第二行：图标和名称 -->
                      <div class="category-popup-info">
                        <div class="category-icon-wrapper">
                          <img class="category-game-icon" :src="gameNav.game_icon || gameNav.app_icon" alt="" v-if="gameNav.game_icon || gameNav.app_icon" />
                          <div class="category-icon-placeholder" v-else></div>
                          </div>
                        <div class="category-name-wrapper">
                          <div class="category-name-main">{{ gameNav.name }}</div>
                          <div class="category-name-en">{{ gameNav.name_en || gameNav.name.toUpperCase() }}</div>
                          <div class="category-game-count" v-if="gameNav.game_count">{{ gameNav.game_count }}种</div>
                          </div>
                        </div>
                      <!-- 第三行：背景图片 -->
                      <div class="category-popup-image">
                        <img class="category-app-img" :src="gameNav.app_img || gameNav.banner" alt="" v-if="gameNav.app_img || gameNav.banner" />
                        <div class="category-image-placeholder" v-else></div>
                      </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </template>
            <!-- 静态导航菜单 - 当API数据未加载时显示 -->
            <div class="_9eNaWz24 nav" v-if="pcCategoriesLoaded && pcCategories.length === 0">
              <a @click="goNav('/sports')" :class="url == '/sports' ? '_5v-zJhSB _--jQI_nz' : '_5v-zJhSB '" href="javascript:;"
                >体育
                <div class="_17Hw2tUT"></div>
                <div class="P4bUdpZY _3hNI-m60"><span></span><span></span></div>
              </a>
              <div class="PjlHS4wt" style="display: none; background: #808080; background-color: #808080;">
                <div class="_1b6LLqfO">
                  <div class="_1Rce9DUC" style="animation-delay: 0.2s">
                    <div class="_2i_36JbR">
                      <div class="_1IpseGVC">体育投注</div>
                      <div class="_2ln0B4fc">SPORTS EVENTS</div>
                      <div class="_2FUZe5W0">返水最高可达</div>
                      <div class="_1idiRBeK">
                        <img
                          src="data:image/png;base64,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"
                          alt=""
                        /><img
                          src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAACMCAMAAABcQOnYAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAC9UExURUxpcfnWxf/XxP/bw//////izf/Yzv/////////z0f/////nz/jWxPjUxfbZx//U1PbTxPfTw/fWxvfTxPjUxP/a2um7pf/Xy/fVxvfTw/bTwv/VxvXTwvzXxO3EsfbTw/XSw/bSwvbTw/fUw/PSxOvBrPbTwvbTw+e5o/bUw/XTw/bTw/XSwvXTw/bSw/XSwtyggeS4oN+ulOW1nfbSwvXUw/XTwvbTwv///+vBrc2GZsyGZsyFZv////DZzyMOsukAAAA6dFJOUwAsDRUBCBgCBAUHCicyGww6Xh9MRwd7EyQ/shFtDpqRzuNUQ9uPqntqWYhmwIzInjdbRU9ycIWYzIEyr3zSAAABq0lEQVR42u2T6W7jIBCAS7ANLD6wY9dOXLfd3M3Zu1s77fs/VmcwaJu8QH+UT0iD5tOAhuPC4XA4HA6Hw+FwOH4D4s8p35TnMfbv45SAMc/TFqRoZp+nVAUHb6y87zRt1yIQHge+YFqDre8x1XXH7qhpj0+0AY+a+03waKtwBYwPGR0UqJlIaPV0hMJeQSmMFclqyVEXTUwebLpFIFyqMBgI1H6dRSubtqu8T0ncFKglrdSqQ8BYPR9GWe2D5jIIp5etwXYwn6iqNJqANmm7//XdyOgkIHmvYegIXKejkP7XugqGjWe6M5iDPdctYpsDzrTt2e5/pjH9fe+50aYxq2wHc9MYaBqO0uXbeD+b/UVmt9vFzbM9FibLSk1e1ofxdn+L7Lfjw+sGD7WwV5Kny91hsRgji8Pb+uUOr0SYCw3VMH1ernc3yO51eZXmUUUTrYUsM6KGk3Rz1bNJJ7kK49rn5jHRjERqmg978qmKwrhMBOufot+UcRYSEmkIIVUW1EnBUWsvm5IGsSWgdSPBeuaTcFH4MhkYEin9QjBt7S9inHPRAzOm/9DP8gUZLGS5P5h7vgAAAABJRU5ErkJggg=="
                          alt=""
                        /><img
                          src="data:image/png;base64,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"
                          alt=""
                        /><img
                          src="data:image/png;base64,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"
                          alt=""
                        /><img
                          src="data:image/png;base64,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"
                          alt=""
                        />
                      </div>
                      <div class="_349CzCYy xJQe3jRu _3fg1Xc0m">
                        <span>查看详情</span>
                      </div>
                    </div>
                  </div>
                  <ul class="_2q_0n3sH">
                    <li class="_3xMhR1us IMSPORT" v-for="(item, index) in sportList" :key="index" v-if="index < 3 && item.app_state == 1" @click="goGamePage(item.platform_name, item.game_code, '')">
                      <div class="_3G21WVQS _1vBjoqAI _1Rce9DUC" style="animation-delay: 0.3s">
                        <div class="_3Ii96E8G">
                          <img class="_2ywsn6BQ" :src="sportImg[item.platform_name]" alt="" />
                        </div>
                        <div class="_2qIXCuoN">
                          <img alt="" class="ls-is-cached lazyloaded" :src="sportBg[item.platform_name] || sportBgDefault" style="height: 156px" />
                        </div>
                        <div class="_349CzCYy xJQe3jRu _1IpIguRl">
                          <span>进入场馆</span>
                        </div>
                      </div>
                      <div class="_3qsc2gtG"></div>
                    </li>
                  </ul>
                  <ul class="_2q_0n3sH" v-if="false">
                    <!-- 沙巴体育   -->
                    <li class="_3xMhR1us IMSPORT" @click="goGamePage('sbtest', '2', '')">
                      <div class="_3G21WVQS _1vBjoqAI _1Rce9DUC" style="animation-delay: 0.3s">
                        <div class="_3Ii96E8G">
                          <img class="_2ywsn6BQ" src="/static/image/img_saba_title.png" alt="" />
                          <img
                            class="_2pgXJygc"
                            src="data:image/png;base64,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"
                            alt=""
                          />
                        </div>
                        <div class="_2qIXCuoN">
                          <img alt="" class="ls-is-cached lazyloaded" src="/static/image/sport_xl_img_bob-5566.png" data-src="/static/image/sport_xl_img_bob-5566.png" style="height: 156px" />
                        </div>
                        <div class="_349CzCYy xJQe3jRu _1IpIguRl">
                          <span>进入场馆</span>
                        </div>
                      </div>
                      <div class="_3qsc2gtG"></div>
                    </li>
                    <!-- SS三昇体育   -->
                    <li class="_3xMhR1us OBSPORT" @click="goGamePage('oap', '2', '')">
                      <div class="_3G21WVQS _1vBjoqAI _1Rce9DUC" style="animation-delay: 0.4s">
                        <div class="_3Ii96E8G">
                          <img class="_2ywsn6BQ" src="/static/image/img_ss_title.png" alt="" /><img
                            class="_2pgXJygc"
                            src="data:image/png;base64,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"
                            alt=""
                          />
                        </div>

                        <div class="_2qIXCuoN">
                          <img alt="" class="ls-is-cached lazyloaded" src="/static/image/sport_xl_img_im-c07e.png" data-src="/static/image/sport_xl_img_im-c07e.png" style="height: 156px" />
                        </div>
                        <div class="_349CzCYy xJQe3jRu _1IpIguRl">
                          <span>进入场馆</span>
                        </div>
                      </div>
                      <div class="_3qsc2gtG"></div>
                    </li>
                    <!-- cmd体育 -->
                    <li class="_3xMhR1us FBTY" @click="goGamePage('cmd', '2', '')">
                      <div class="_3G21WVQS _1vBjoqAI _1Rce9DUC" style="animation-delay: 0.5s">
                        <div class="_3Ii96E8G">
                          <img class="_2ywsn6BQ" src="/static/image/img_cmd_title.png" alt="" /><img
                            class="_2pgXJygc"
                            src="data:image/png;base64,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"
                            alt=""
                          />
                        </div>
                        <div class="_2qIXCuoN">
                          <img alt="" class="ls-is-cached lazyloaded" src="/static/image/sport_xl_img_fb-cae6.png" data-src="/static/image/sport_xl_img_fb-cae6.png" style="height: 156px" />
                        </div>
                        <div class="_349CzCYy xJQe3jRu _1IpIguRl">
                          <span>进入场馆</span>
                        </div>
                      </div>
                      <div class="_3qsc2gtG"></div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="_9eNaWz24 nav" v-if="pcCategoriesLoaded && pcCategories.length === 0">
              <a @click="goNav('/electronic')" :class="url == '/electronic' ? '_5v-zJhSB _--jQI_nz' : '_5v-zJhSB '" href="javascript:;"
                >电竞
                <div class="_17Hw2tUT"></div>
                <div class="P4bUdpZY _3hNI-m60"><span></span><span></span></div>
              </a>
              <div class="PjlHS4wt" style="display: none; background: #808080; background-color: #808080;">
                <div class="_1b6LLqfO">
                  <ul class="_2q_0n3sH">
                    <li class="_3xMhR1us OBESPORT" v-for="(item, index) in gamingList" :key="index" v-if="index < 3 && item.app_state == 1" @click="goGamePage(item.platform_name, item.game_code, '')">
                      <div class="d9QhCBa4 _1vBjoqAI _1Rce9DUC" style="animation-delay: 0.2s">
                        <div class="_3JFVWFYi">
                          <img src="/static/image/home_rebate_box3-d4a2.png" alt="" />
                        </div>
                        <div class="_3Ii96E8G">
                          <img class="_2ywsn6BQ" :src="gamingImg[item.platform_name]" alt="" />
                        </div>
                        <!-- <div class="gameNametop">小艾电竞</div> -->
                        <div class="_2qIXCuoN">
                          <img alt="" class="ls-is-cached lazyloaded" :src="gamingBg[item.platform_name] || gamingBgDefault" />
                        </div>
                        <div class="_349CzCYy xJQe3jRu _1IpIguRl">
                          <span>进入场馆</span>
                        </div>
                      </div>
                      <div class="_3qsc2gtG"></div>
                    </li>
                  </ul>
                  <ul class="_2q_0n3sH" v-if="false">
                    <!-- 小艾电竞 -->
                    <li class="_3xMhR1us OBESPORT" @click="goGamePage('ia', '2', '')">
                      <div class="d9QhCBa4 _1vBjoqAI _1Rce9DUC" style="animation-delay: 0.2s">
                        <div class="_3JFVWFYi">
                          <img src="/static/image/home_rebate_box3-d4a2.png" alt="" />
                        </div>
                        <div class="_3Ii96E8G">
                          <img class="_2ywsn6BQ" src="/static/image/img_ia_title.png" alt="" />
                        </div>
                        <!-- <div class="gameNametop">小艾电竞</div> -->
                        <div class="_2qIXCuoN">
                          <img alt="" class="ls-is-cached lazyloaded" src="/static/image/gaming_xl_img_bob-14bd.png" data-src="/static/image/gaming_xl_img_bob-14bd.png" />
                        </div>
                        <div class="_349CzCYy xJQe3jRu _1IpIguRl">
                          <span>进入场馆</span>
                        </div>
                      </div>
                      <div class="_3qsc2gtG"></div>
                    </li>
                    <li class="_3xMhR1us IMESPORTS" @click="goGamePage('ld', '2', '')">
                      <div class="d9QhCBa4 _1vBjoqAI _1Rce9DUC" style="animation-delay: 0.3s">
                        <div class="_3Ii96E8G">
                          <img class="_2ywsn6BQ" src="/static/image/img_ld_title-.png" alt="" />
                        </div>
                        <!-- <div class="gameNametop">雷火电竞</div> -->
                        <div class="_2qIXCuoN">
                          <img alt="" class="ls-is-cached lazyloaded" src="/static/image/esport_xl_img_im-a454.png" data-src="/static/image/esport_xl_img_im-a454.png" />
                        </div>
                        <div class="_349CzCYy xJQe3jRu _1IpIguRl">
                          <span>进入场馆</span>
                        </div>
                      </div>
                      <div class="_3qsc2gtG"></div>
                    </li>
                    <li class="_3xMhR1us FYESPORTS" @click="goGamePage('avia', '2', '')">
                      <div class="d9QhCBa4 _1vBjoqAI _1Rce9DUC" style="animation-delay: 0.4s">
                        <div class="_3Ii96E8G">
                          <img class="_2ywsn6BQ" src="/static/image/img_avia_title.png" alt="" />
                        </div>
                        <!-- <div class="gameNametop">泛亚电竞</div> -->
                        <div class="_2qIXCuoN">
                          <img alt="" class="ls-is-cached lazyloaded" src="/static/image/gaming_xl_img_avia-1b4b.png" data-src="/static/image/gaming_xl_img_avia-1b4b.png" />
                        </div>
                        <div class="_349CzCYy xJQe3jRu _1IpIguRl">
                          <span>进入场馆</span>
                        </div>
                      </div>
                      <div class="_3qsc2gtG"></div>
                    </li>
                    <!-- <li class="_3xMhR1us FYESPORTS">
                      <div class="d9QhCBa4 _1vBjoqAI _1Rce9DUC" style="animation-delay: 0.4s">
                        <div class="_3Ii96E8G">
                          <img class="_2ywsn6BQ" src="/static/image/img_obdj_title.png" alt="" />
                        </div>
                        <div class="_2qIXCuoN" @click="goGamePage('obgdj', 'obgdj', '')">
                          <img alt="" class="ls-is-cached lazyloaded" src="/static/image/gaming_xl_img_bob-14bd.png" data-src="/static/image/gaming_xl_img_bob-14bd.png" />
                        </div>
                        <div class="_349CzCYy xJQe3jRu _1IpIguRl">
                          <span>进入场馆</span>
                        </div>
                      </div>
                      <div class="_3qsc2gtG"></div>
                    </li> -->
                  </ul>
                </div>
              </div>
            </div>
            <div class="_9eNaWz24 nav" v-if="pcCategoriesLoaded && pcCategories.length === 0">
              <a @click="goNav('/people')" :class="url == '/people' ? '_5v-zJhSB _--jQI_nz' : '_5v-zJhSB '" href="javascript:;"
                >真人
                <div class="_17Hw2tUT"></div>
                <div class="P4bUdpZY _3hNI-m60"><span></span><span></span></div>
              </a>
              <div class="PjlHS4wt" style="display: none; background: #808080; background-color: #808080;">
                <div class="_1b6LLqfO">
                  <ul class="_2q_0n3sH">
                    <li class="_3xMhR1us OBESPORT" v-for="(item, index) in realbetList" :key="index" v-if="index < 4 && item.app_state == 1" @click="goGamePage(item.platform_name, item.game_code, '')">
                      <div class="d9QhCBa4 _1vBjoqAI _1Rce9DUC" style="animation-delay: 0.2s">
                        <div class="_3JFVWFYi">
                          <img src="/static/image/home_rebate_box3-d4a2.png" alt="" />
                        </div>
                        <div class="_3Ii96E8G">
                          <img class="_2ywsn6BQ" :src="realbetImg[item.platform_name]" alt="" />
                        </div>
                        <div class="_2qIXCuoN">
                          <img alt="" class="ls-is-cached lazyloaded" :src="realbetImgs[index]" />
                        </div>
                        <div class="_349CzCYy xJQe3jRu _1IpIguRl">
                          <span>进入场馆</span>
                        </div>
                      </div>
                      <div class="_3qsc2gtG"></div>
                    </li>
                  </ul>
                  <ul class="_2q_0n3sH _3f71qTdk" v-if="false">
                    <!-- BBIN真人 -->
                    <li class="_3xMhR1us YBZR" @click="goGamePage('bbin', 'bbviode', '')">
                      <div class="_1vBjoqAI _1Rce9DUC" style="animation-delay: 0.2s">
                        <div class="_3JFVWFYi">
                          <img src="/static/image/home_rebate_box2-d22b.png" alt="" />
                        </div>
                        <div class="_3Ii96E8G">
                          <img class="_2ywsn6BQ" src="/static/image/img_bbinzr_title.png" alt="" />
                        </div>

                        <div class="_2qIXCuoN">
                          <img alt="" class="ls-is-cached lazyloaded" src="/static/image/live_xl_img_bob-c013.png" data-src="/static/image/live_xl_img_bob-c013.png" style="height: 130px" />
                        </div>
                        <div class="_349CzCYy xJQe3jRu _1IpIguRl">
                          <span>进入场馆</span>
                        </div>
                      </div>
                      <div class="_3qsc2gtG"></div>
                    </li>
                    <!-- 大游 bg -->
                    <li class="_3xMhR1us YBZR" @click="goGamePage('bg', 'videogame', '')">
                      <div class="_1vBjoqAI _1Rce9DUC" style="animation-delay: 0.2s">
                        <div class="_3JFVWFYi">
                          <img src="/static/image/home_rebate_box2-d22b.png" alt="" />
                        </div>
                        <div class="_3Ii96E8G">
                          <img class="_2ywsn6BQ" src="/static/image/img_bgzr_title.png" alt="" />
                        </div>

                        <div class="_2qIXCuoN">
                          <img alt="" class="ls-is-cached lazyloaded" src="/static/image/live_xl_img_ag-f4fe.png" data-src="/static/image/live_xl_img_ag-f4fe.png" style="height: 130px" />
                        </div>
                        <div class="_349CzCYy xJQe3jRu _1IpIguRl">
                          <span>进入场馆</span>
                        </div>
                      </div>
                      <div class="_3qsc2gtG"></div>
                    </li>
                    <!-- AG真人 -->
                    <li class="_3xMhR1us WMZR" @click="goGamePage('ag', '1', '')">
                      <div class="_1vBjoqAI _1Rce9DUC" style="animation-delay: 0.4s">
                        <div class="_3Ii96E8G">
                          <img class="_2ywsn6BQ" src="/static/image/img_ag_title.png" alt="" />
                        </div>

                        <div class="_2qIXCuoN">
                          <img alt="" class="ls-is-cached lazyloaded" src="/static/image/live_xl_img_wm-0725.png" data-src="/static/image/live_xl_img_wm-0725.png" style="height: 130px" />
                        </div>
                        <div class="_349CzCYy xJQe3jRu _1IpIguRl">
                          <span>进入场馆</span>
                        </div>
                      </div>
                      <div class="_3qsc2gtG"></div>
                    </li>
                    <!-- 完美真人 -->
                    <li class="_3xMhR1us BGZR" @click="goGamePage('wm', 'videogame', '')">
                      <div class="_1vBjoqAI _1Rce9DUC" style="animation-delay: 0.5s">
                        <div class="_3Ii96E8G">
                          <img class="_2ywsn6BQ" src="/static/image/img_wm_title.png" alt="" />
                        </div>
                        <!-- <div class="gameNametop">完美真人</div> -->
                        <div class="_2qIXCuoN">
                          <img alt="" class="ls-is-cached lazyloaded" src="/static/image/live_xl_img_bg-d46a.png" data-src="/static/image/live_xl_img_bg-d46a.png" style="height: 130px" />
                        </div>
                        <div class="_349CzCYy xJQe3jRu _1IpIguRl">
                          <span>进入场馆</span>
                        </div>
                      </div>
                      <div class="_3qsc2gtG"></div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="_9eNaWz24 nav" v-if="pcCategoriesLoaded && pcCategories.length === 0">
              <a @click="goNav('/lottery')" :class="url == '/lottery' ? '_5v-zJhSB _--jQI_nz' : '_5v-zJhSB '" href="javascript:;"
                >彩票
                <div class="_17Hw2tUT"></div>
                <div class="P4bUdpZY _3hNI-m60"><span></span><span></span></div>
              </a>
              <div class="PjlHS4wt" style="display: none; background: #808080; background-color: #808080;">
                <div class="_1b6LLqfO">
                  <ul class="_2q_0n3sH">
                    <li class="_3xMhR1us OBESPORT" v-for="(item, index) in lotteryList" :key="index" v-if="index < 4 && item.app_state == 1" @click="goGamePage(item.platform_name, item.game_code, '')">
                      <div class="d9QhCBa4 _1vBjoqAI _1Rce9DUC" style="animation-delay: 0.2s">
                        <div class="_3JFVWFYi">
                          <img src="/static/image/home_rebate_box3-d4a2.png" alt="" />
                        </div>
                        <div class="_3Ii96E8G">
                          <img class="_2ywsn6BQ" :src="lotteryImg[item.platform_name]" alt="" />
                        </div>
                        <div class="_2qIXCuoN">
                          <img alt="" class="ls-is-cached lazyloaded" :src="lotteryImgs[index]" />
                        </div>
                        <div class="_349CzCYy xJQe3jRu _1IpIguRl">
                          <span>进入场馆</span>
                        </div>
                      </div>
                      <div class="_3qsc2gtG"></div>
                    </li>
                  </ul>
                  <ul class="_2q_0n3sH" v-if="false">
                    <!-- VR彩票 -->
                    <li class="_3xMhR1us VR" @click="goGamePage('vrbet', '3', '')">
                      <div class="_2p3kUWUL _1vBjoqAI _1Rce9DUC" style="animation-delay: 0.4s">
                        <div class="_3Ii96E8G">
                          <img
                            class="_2ywsn6BQ"
                            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAQQAAABkCAMAAABXVb7WAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAMAUExURUxpcf/ax//mz/fUxv7T0P7d0fnYyP/9/P/////8+//ayP75yv/fzv/UxvzPzei6pOiymvjYyfnUxPfVxfbVxfjVx/fTw/jXxPfTxPrYyPbUxPfUw/bTwvbSwvbTw/bTw/nUyPjTw//dxvfSw/fVxPXTw/XTw+/QwfjUxuKvl/76+PnWxvbTw/bTxPfTw/////bTxPbSwvXSwvjVw/XTw//Sx/bSwfbbyuzBrfXTw/XSxPfTw/jTxfXTw/XTw/bTw/bSwvbRwfbUxP/UyfXSw/nSwvXTw/fUxfnVw/fUw/bSw/bUxOSxmvbYyP/8/PXSwvXSw/bTxPjUwua1n+Kpj9OSdPXTw+vMvvXSwvXUw/759/bSwvXSwui6pey/q/XSwuW0nf/+/vXRwejDs+Cpj9yki+SwmOi5o+GtleW1n+WznOe2oNSVeNibgN6mjdaWeOvCr+a+rOS1oNeXe/bUxfTYy+m7p+aymteYffXb0Nuhh//+/fTXyvXSwvvs5dibf+CpkeGslN2ki/vs5Om+q+O4pe3Esf/+/tSTduKtlfjk29uhh//8+9qfhOOuluu+qfTd0v/9/NmbgPzx7OCqkteYe9eZfu3Fs9KPcvHLuOCyndOQc/749eWym+m7ptWVeN6ki+/EseCqkdORc/vr4/zw6tWVeNiZfdqeg92ki+i5o+3EsdmdguWynP308Oi3of3y7uKsk+O7qeWwmea2oP77+eWwmffn3//69/ff1fzv6v/+/s+Kau/Rw+3Ku//7+f318Pnk2fnm3vDItu3Fsv///9megum7ptSUd92li+GtldyjidKRc9qfhdGPcc+KatOSddWWedeZfdibf9CNbs2HaOSxmuGslOW0nt+okOa2oN6njuOvmOSym+Cqkei5o+u+qtughuq9qeKul+Owmc2GZuWznduih+u/q/fo4d6mjei6pdicgf78+s+Lbee4o+m8p/ns5taYfOe3od6rk86IaPTf1fHUx+KvmOvGtPHYze3Kufnu6fz28/vy7vXk3PxREiMAAADFdFJOUwANCh4GCBoDAQIUBQ8SDIoSIC8+NiRBJmQsOU1cj3eZKEQWIjyegv5G1u4xkmhhUFapbUiFF7EcxYgze0qljHKtl28YUS5TdCtYfl7hTvK62FsqwRzgtf7Aa93Hoei+0umyzf4p8FR46/GwovlVozL2/vxEst/RMdPT39HN4sT44L222e3+1vjw86jO5MBKtO3EYY3TuuTk98D+yZxD9pXVqcqMzLmkdYSUgpbtbdVcZIP8PJS+ZfF9vm+p9u3rN0iGXIFt1zmedAAAH+5JREFUeNrte3lcU8faPxASyEJqQghJgIRAEiIQfuwY9n1VERQFFOWKG+IGWtyuV9u6oLZq1dZd6/6qdWlrF+1i2/uGyyLKYiugeGuxUrkurbaCW/t7Zs6WcO3bW3O9n/sHX/JhZp5n5pyZ7zPPzJw5c2z60Y9+9KMf/fjvhyP/zIntr6/Y7ujoiNMQbn+dwBlC5vj5//uDiIBi/43Ajfu4L95f+OpQE8Z2BweuoyPk4jqcMRHwtXPgch25XIdXTX8QJ/C1nhFQBZGJhhd1JUYrp5ULoYLcj0y/gaEL//TRGa55aWjcbzXm1o/3ex7MYrNRzR0d+OyPf/TB2PQCm+/gAILCH/8gvrB/ZhZwRQWFtyic4MOlLLT8j2jlR2x7e3s6aQkTgVdPQE2Ywmy7D3v6wufRgwffYMxyErKBVwd7O88Vj7795lv4fXPcFm7CtrNd9y0A0vD71gKUHAABk14uZPO5js/KgT178vcUfD62sydYYJrx4vffkNojtkKh7aZv6LQlHvj0/PoEuoscLkAVFjpBYxj88O0PCBDgeDkHWACz2wk+fkzKilg8WzsolkSX++3ydIixnGcLjD4bCdDzBCk0p9/4omrRJKBmiHxovqVhPJ7Xpr72sUj7/GLyPUOw4Ig4iFj3tz744W8/wA9Hd7pynNh8qMBpkw+pPQIiW1snjnc+U+Lp5fumK1k8oT1U/ZlIYNt6iSrpBt343MkOLkUp7YW8099QfC/19GaxvDfRNng6em4NPcN3AJ/g8u2cIjxf/Ps//g6/f2AQcTrc6efNE7LZtmeGPv4boS8K8fMOc3LyEqUcgSTGb5e3lA1y5QjYz0gC1JQlP0Lz2rM9wonNkADKUzTfuxXi3Fzxpr/9Dh7dWshDPHLtbcNcJGV/B9z5+x0ECFCcDHdWrlV4cgR2ti4Lb31Pyo4MUUBXcOK4KiavXTt27CAKn5HlK3GCvA6tHTt27drdfxWznOyeiQSoqRBq6k7z+f1C1yRbey6pZNtyPH1ovoNDNBKJ8yYLOzzNXo9MG1DH5LIFEXLpn2chFBUVLZ1FxgDLP/t03SvHjm2XyllOgjOFJp97BIoSAzWeHB6Ple6cKlu1f/9fCOzb9yGhvzN/HwASGPv2gQ5j//4vcvSR3jw7/jOSYMtJdw4sou31WM+CrkAoHdhOoi+/x7wDlhpS1c7S6E2ULamQAmPvhys8wadQab+Q/SaEU0FBQXhxsCIeYvHxvsQ6QS1meX3ua7rffq8doSIhDpHgxGPJpYEFkJ/Gj+0EnqDEE8h+D363TAxWZUVLrCIhRZ219h6Fhx+5hpG9ypEvTPJcBfzfuwO/e4Pi3N3UIYGbIBMt6wtS93iDkx0fSPCWuMX7IKwLDw//FEV69sUDwn/B0ko3P/mGFaaeVoT21tYtsYmpCpcwcIdcTarhxn0GPUgPJDxEiYcoDr/7ZsjP0fuJeM/oDo6IBH1AbDtwi+3x4H1xhMDekSBIwPJ7sR0DlFpllpvezX0ppEgZA9I2lObRQhik+IiEIX+93nr9eqsPkLDpOsK6oJiYmFP3r4O4tVi/wdd06xGOA5ZrdbJoP5aTrSDJVRKd1YPl8KNDgIUMQMWLUqUpLKdnHhiFnHR1gK4IDAEAhn0V3k5sLukNLvoHrSTvO/2V7kBCwFKIY9moRYuGDRs2Dv1BuGjTTsKemIXHci8h285JJHEzLOu4fr3jH6diYrZ0IDzQJvgn7PPp6LjecX3t6ybTje87SCyfo8qUDZF42toJeSI/dWAPEuJ88Ovog77yIjcYZG2flQQHOy9XZ/eoQTTfv57w9IJuhVVJuV+0U3wv94jLCFEDCZQdHi0aNm78+NEI48ePByJmMfZ6qIehGkiIdDNs+hrhRZVqTCuKdKwK1YW++gMWHil8/OBrCsvJMWAhYi8iXZPs8/UfQBEaF4V8rs0zAXmuIjVNS/Pqsz2FY8t3xJ7C8ptPy8ONhmS1NDpgKUX+o3Gj87NHhiPMGZmdP3r8sJ20mR586eplawfeFC3bcg1hVKxHwqzLvZd7e4elxX3x5Fpv77XeawXrrmFAdOvyfSZybS5gswUwRw7xwXloXL52GcpjGfwsdBAtUouf2RvwyBghjjYYiyhO7xRKRNgfuIieUZR4pzYqK0SjCclaSkke5YfHqBL8PQD+Caox8SPzx9GG+fZLGFmEApY4JMDjciegNdbosai3s7ez87MCw/77vahBlXHrIA3C3s6i/JG+PZcvd16G9FxYPoW5KpJ9OjtBcLloy5Yto9eR+ZaP3jJ6/DrgApVfDprsB1jeax0J0OnDPKVZmYNovn8c4sJjO2BH8Txxh+J7uX9cqnOkRJ21lLLDo3iVMSotMRiQGKfUxari8ysoe7VmKbxhgENjblRFZ2ddZ90cXew4FNZVGGS+5XUIu3Xr6rCueEv2yFO3rtfVdUJ6IM9WCCOjJhBIQPmXho/MHr2O0NWNz8/OhwSB0dAPTz0CBbpEiJglQKazxh/iEjoBmO+HG9KThLDu5cO8sQoaBCJQxBtl0RJxpNp9KbYXCB+pdMFZqUOi3QCpGQGJmf5BO0GO8193d3blAQlydUDUrIsI43TGkRcx4jY8weHKhNi1ENQN3jJyTnhQ4f2LBA5HOAmcOJ5Sdx8iPesVwIekcp15AsWHPiDig90irSEB+0OIwViMeYd/37/vxxLYc2HBx5J8CoRjG4A35EjFnmKpexFOw78HxuBAvSJSLBb7+Uk06lRZVMIsSrdTppYnCQSoj0V9hmu5SWdMuHjl4pUrV44U9kDk4pVKlf/YlZVjY4Lig2K0fzHdARXIV0rxuhnYAxJQ/gcmwA2iqVd+QYlfQIx0eLF0h4gPTyad2Bp/cM8cdJFEHZ4kYcHHcxlSTgnBG5IVni5yIIESPYjK0ke6sjgcTgSL5ZKiSTao6OxFhhAxR2DLc3XOUY5vQygNNQ71wZh/rPdK25UrPwWp/GE0UWm1WpX/qhW/tl1pawP5VJjvvXisFL1hFE5fufMQ8KgN44oPSvggOaDn4cOecjI+PNUqEvDiWAL+cJHCfTxJwnIxfQO2BTJRUKhML/YW5Tq7F5F2uPIgLVCBH3wBArTSlRVeg9JYNyg4WsyxtQVHC0zb3YZhNK4wYfxlLU5Xav2NoaHG2NhYoy7U90lv2yUsDoblb5IXjKgFQML/Ach+CX5UvCxVYQ0JeOWM/YG6/KPt0AB7tgAmSMwAkF0K3uDsyWJ5AgmYe0BJ4pBIFuoyfNgSsOOd+cj3Pi6O9NoCIAHNkZFuBR6DMY6E+tRhrByO01oPnTItTalUpsXFHTOVXyIwvCCZICG6YNSlS92XuuF36fcxJQ56goDtaGOFP3ghfxhLkdCLJ0k7MGMJxXelfyJUjsOBdVUpla3k2Ovvv/8nArB5Cr7aSamKYw0hKUACDK0f+/oORYD/o7pru2tru3shhSW+GwKysrLccwyFpp7aWlB2104xBsN9wngssEolKevGIYCKW4QYbbuD3dBABiRY6w80r2iSFNqGeZ7oJAVtyBvkETxEQjGksY1KTBb4pecKfYFBoTJ1epIdPInnvs/kGFWLcY0WbHCLDtHrv3zVdB8ag7E71ABPDzwYGPWy4bX/GrpXDh6jg+rhJZ7V/jCY4rtnQzoaoVNOUXyXqqJyNK5hTmGIBMoO10oYlLd3mtmrWJuJpkggIclzfi+Ntvra+tra+m5aMFAjiYw8PRT6QT2BSlVUlhTfG55nQkf+ef6LL87/MwAiAJSgU7QGcGqVMsPZFS/2rfIHV+QPFLfLYJL08hJJPqMElR6JQySw/+HlAiT8rmlWhvuDi3o7oZ7gOb+eRFd9FwIEdHpgpPxz6CmPII7lg2Nig5MV3rDAALYzlMdM/yp8DW7Igx1srACX9Id6DLCWr8KFE+E6pIISYG9AUx4igRBBLvj3NBTnx4TKQmDZzEY7d/Ovkui6ijmAAMVxOFC6fYXpSTmlHxwPD6pSOQc9RnpLkgv23fhX8WEAKmbPte6tGOEPUyh73T8h9/YWb6DsV6xSZmhgmBDSJJC2o0MG5TcK5/inBWqgd8KU4R0Z33C14bewcaHplk89RK42XL3aMHjOKu0Xp7/8/Iwdm+3EEusD5mM5/PtdXJ0scTHfVrLieTpzLGWvku2S3FzJsKuk3QZ5BMNsCJbFJCAZgLanBepLnpgKdbIQPxZ4gxAeAQ43VDfAr7qaDGlAYvXC+22UvKFyTiH5/oYN0zMn1zlwPlPu6eUZ+VH68cl6f+gime0udPaLVJeTqXro3mo5R0iQMAWJGBsxcSp3j2k/dIQwoT0MCenSyXs2FtfiWq+sI2tfioObG/eUfXqTatLEQSPn3HqMsWoEeox0gZ256v8LN6tvwo9MHJVHCNCQYK0/pITIjEsofm9kaDSna0m+SW9g8wkSzG2B0ddeD1dk+IFh+LDbDNuXSv9XLt0EtGwqaUG4Wf9iV8tNCHeHKj+9SWJw9pyYV369ieUtO+zYaG9Jf7gFBDQggQABjlvqjqZzLB6frNlfGk61z2eDXn+K4hu8AT+jObAtSGhgQAhoxQ2YYm3tHexhy12dFZVwrKWlGWr/GZCAUL/oJxwO8g/9lGjWki0jw2O0KyoI/Zs8gdAWBgX1/760Z+PGgb+HjXv2vPTycXkEJsF6f0iOS6D47n09NfUzku+GGF0A8gY+SQJlh3fRHuM4AsM2FdUy9qr4k2cSIgHWStIcpf+PzRiLSoiwa1EvDperPIZDsHhgeHh8jNZ//+NmAjNYPIHgo4WFha8CfH8fKFth4cKPqTHBen9oIeEbkNZJRilvcCBJoLK8i/YYR2OgLcZFpWBvEsfQhAUvWr1cFKmJ2ht3EaoXldzF6Fq0E4ebVP7DF29cGxMUBBTE+q8ov0vgg1wWj7fd9EexUGjPdbR2fkCPvVFgGgIPv1hFRbE34B0GggRKvgz2GGE7BIHYYrzaTGEdGhPQ2xe0ybjfp+lu0927K4EEiDQ1NSya1YSwVeVBPEqr/I2ZymNPmptwvnn6SJcIzqqf/igmzkWHHf4t/rCYNEf5/s/I2E3kDekc2GsiSbhLYhm9x4i3GLNHF9+lMEoD07YD4Q/ux7biNhcPK6lpqkEkDNuEBTdjiEdpo06ZaNhuWtZE4GSqRu4tWoXyWgAESPbbeM8WsWC1P+jBH6AJyF7Vr1KVmqJSBiJvoEiYCGqcZxm1x4i3GD204ZUgB4CuXI0eZ7jQvVwUibfu1iAsH1dSg1E9blwDjszPVALSEg1ZGWkrHtYQeDMuQ+rn6bkKNfqPYQePPFVgvT9QfN9oIUkYG0s8pnJtKBJILCP2GIktRlmcThVO22sZXltx8ePp/vuNjTWNNYtHjy6HECp7c/ToKTWNgJIogyzAPSPVLWRI4ZMWpIMMU9Ny1BKx3/82moPQ4RCA4wDLdM0aWJ/xuf8Gf0j0n0byWkeGi8eAN+SinVeKBIr5ZeQeI95i1AcW6LS0USpgJIVBAV1Tv6L37NnGs42D8/PLIYD44vz85Y1IdnN/TnK0WqpRqBeatjYCQL8gNjFQKolUfIDTWIbzmsefLmuc5OIlBFP9G/whdEEfvpckKAPRniNDAmWHCmqPMYIlchVLAxNjayh7bc2Swg4dnk7+dOMswrQtI7PLz2Iszs7OfhvHek5LJWJ5rmShaRSkcLYxoQY3TWSkc/Lhk2W70RGFD28QGD8WjissO0sCziSsIxXD0OmEspMvTJai93CYBOv9oQ/fY2MLSG+gSKD0Fcweo8BLJFZnZdZQttmK9lSABGHSaVPFOYSB4fHh5ecwFsN0MgjHGgo16d4s+esmn3MkxiYokTcACTKlMUEbE3/s1iiMkoHoNVcJlS975Mjlowj8OCdojCo2syBQKqdXjdb7w1lz3CW8AfYraBIo1VZijxFvMcLzJbzLq6FVhhBYXaFtyqG/4kpPi4+JCSo/d+HchQvnpkE0fAGOl5x2ZX1eaBpFtW0g6giKdM8UjVtAWqiHaswrpnJStSA+HJFwAYpBCt7/DSTjl3znwJat0pDqnItJsNof5MgfzpmD9gaGBCw/e+7s1mA3McwB5Av+CD+34GlUqa1x0aBiw97lk+YLgNtjx6hU2vILGNMgGhNfhaLnjqDzCaMukFgS4xEX6AwTpGukOtCg1Pm/YrpxjtStjYmJzy6hcmZDb6oi46OGrgqNCnYPkRBnbKz3B01O1FqgF3OMwXgDQwIJmgSAg5AjDzEQJEDRn3RAggC9kK24cPvC7dsbYUkYm/DubYQL0/xjwcZrN98GchbAjsIykKH4hSXxCVEBarGIw2HlKkICZat8TTdqUHnAW1oV9IuS22TecDjlMBaVQYKHpvfTctw0cutnB+wPLPAHj80XGEwDb5DmoqMrNAlvUzoLEuyS0tWyKkrVtsrNL0IggE278+dvn4cWeIRm6mLfPY8xzajTgb8DC7fPbzX92oyFkG9gvEoH22To9FqYSH7iY9i/vt+IykO+qgR4khhqWnaeRIwK1mcbQYVLjjKteH2Ds3cSc3rNen+4TfIN/5YkpJHewJBwm9RbkhCWq5a9eZvEzUIggceLSIlGlXxL5aFLS1SGUiRkxsUpQ/1Vu6t+Pv9TOdWsC5Xx2tDgVA2cZxPCC1kRUPB4K6Ws2m0cik4unaMECcZQo7/2rfM/E8muX02m0xzm8KH1/jD1PAPwBtgCR67GkEDpLEmAVxcB8yjV7SfbI0VeYTDQ/vzzJy8lxGYmymQFme9+hbE5zSAzpOk8EhJW3/7q55+/+hkJ39wSrzUmwggfATtS6BBo4aja86DC+qrdHpmjurpaICeBqlAl4jFmI13+ZonOyxaf67XaH+CN0ZBE/800B9PGZMKMj73BkgQwwc915iSwea7SrNfogiWvS2CrFmaMr/KOeBijCtwDAwOU736H8NXmYPfUwIBEXay//1aU/u6rrz4ZOCdIFZqYIRWzwJx8RMLS7wgd/BYEqYxEYUq2Wol4DFUFjd2M0/Dvu3le1LFe6/1BDf7wFYW3YO8ce4MNRYImJw9zD//m4VdtfDNVGbYLxiGFK7y006QeUmZmKg0Z0fronDSyHZsNqXr9EPfgTCOQgPDJW7ChkKALzoBBkQddGh+yBRIIvDk2XuuRGUcWJgocCc5JDZSlGbXx4Rs/IYXzOMS4aL0/QFMClVMJvgFr8d456Q346IomMA9UxF3xYoBPqxSBfwUFiW0KT1hHKtyyChKDA1LVCoU0NXE12QRZtEbhHJ0TnBm7AFMQD3sqHmi1AxzAKVD0yMHx3EUQ9tbY8CAtDCnBb5hxsDYqwE2tTw5QxmqDwuOH5xF3FFFnm633B79oQ+iY7PHoXFp+vD/9ZofZjk30CMqH81ojtZkBanSag/Ekt+DYmPzx48ZDOdhzzxWxXCLVyRk5gW7OkXK5ws1AkeCu9ktPUYS4J+rmfffmcDidgBY7smTnFBF+DuTyYave78AnefNe2h0Tj5eDcQUGioTzVUuC0PMF0AqrylhVTFDMmISpr23L2+bJsXp2oE9vOmekxcaMzB89OhumLFl0JPFmh+FIplPFZ2ePhHVNhgYRxByHhFMpCfHZ+dnhWmNwKvSECFGuRKrXSyWw/HHx0wfotPHZ4UH+cYggkackOiCtbLc2JkabYIS1TrQil4U5cIS3gknQh2RKGP/HaFWxujRDQJYsONNjTDhs3YzOD1dFBYRI0j3FsKyMg2WlVgsjb3AgeWjJehKIk7gBmOCgMf66Apiy8DKMbmm6NCMxNAEq5xElo199Yfq8XBWpBp0/tEoVqwyIlrhEeHFEnuJIP7lLRFgYKxeRC8oEvBbghMGAMUSmDPXw9zBmxgWkSiNdiSnOkThRrQEz62I9PIy6OFlOqltyhkFpVAXNAfaDVLqCZGAsAngMATHkigUWM9R+InzA22oQRojOSowKNcKGj8zymKgj6qeRITnBUTpdZhr033TUAWn6WClStNY1hurSUEFRmBPPK0LkLYoIc4InLDjhK4syenjo4jLwsW441QFPSYnKKGWiDJ7I5aIwAeKAqYR7gTIKK6OlGo3UzR2GENWYmDEqPHrIWV5OPI6Ln9QtxxCHrgF3ZE65W98VOJ4Sfaq7DPY7MtycxSIv6AiMVgBadap7AKnkCSklbKV5efs5u2UEyGQBOUOkkS4cJwEcVeHxIGDj45lwcD0xLa0AFvkuXnB0gScSQ/asrJzUEI0YctOzPBy8h0tJh+TAXdxBGSnPTY90BhaUulBjaFQcaq8Ivo+xE3ixwN/cArMCIJ9eYf2YQH/lYefEcRErpPoQvVoTmQsc4Asz2ghX0Kr1amdJuiiMmZm5QBAsdiXO6pAQvVSBW2UHjQew0aQnxG0OzMhI1ks8oeOjl0zeKXAlNWR2ZXkJmM+OuHyog2ukRh0SrUdKUQSH5SLWRAdmyQwGGaIlBVXL3h6WExxRLmTUo1vK6bpazwIYLYzl4ilPkae7ijg8i1UY/qgpCWlB6c3hCbCS+YyIF+Htmp6SIvd0YSU5CYnP2uAfl0tRpHF2Vvi5spCODxKWa7ocMiMK8GdxzMc4vAiXdNixSsn1hn4vEMDnQJjf6BCCM1QtmErhRR9UB+eUuyJ/wtWxngR8ZQEvDM6kJfGcoHJ8INfiuzDo4mGghLqhZtI1RywIBU5eSbgkdAOshG8cAQxFnq4uLOLrL9wCdJswnoDIy9yFj1UsFosThqoAHQoVBsOIU9LhE6QwJyHmDFdWKOCh03MRYBL60cF6FqB6cFehUAgdGfHt2OcLQVBiLRt1c0YJVSIKwkYTVlqUpCgK88L84M7BB0JRZuIu5nXAKgHAFvkSALUVMUaSjy9O3pOPbkllBem/BZhgCsiQfbRcRttHSRZklI7mOoJbAMksysy3B/ThmWob5GaDjsxK8ctYxiKvPZXX5r8aDLeYWVICQAlLMDoILArz+9JLa6nc/ehHP/rRj348Lxx9AeMokZqM4pMnHCaEhycf97bMzWQCvGchdTheVllaVHl4ApEc8IIlHBz6CAbMtUhOtrEBAXXbEeRFqYqY3XfScyDBblJxe3vpJDZZ9cn32k8OsHHYUdHePvWFk8Pb24dDo/piBMiL1wywkO0YXHF4x4AJxysrTtqj9Nz2iuFlZWUV7cVlZVOL77UPGADXAkHpvVL4P7i9fYKNwxq482SEwydLS6EMf9K99ooy4rYEDcLJUJH2NfY4Yf8ByOfaPBfsaG0dyKRKp+JgeGsF1pW2lj7lth+0tk7u06FaBxP52FNbhwshfK8Ud5Ti1qlEgREjSrENBxI3W1PxHk4MJsvPBRIYwaSK1mIWoTje2lrKJzMNaJ3qYPOcMLyjYwQVn9BBtKXs6w6iuV93DP/nEms6Oo5bCCZ14HKYhcFfT0X0vYBTxZBAODlhQhnRzK8Jxt/Zge9MkACYyrahBaDtgHKkoqPjKMV08QCb54XjvZdpu77zEhGWXeslyIdP/oT/TELvZQvXHLDyWhnTTa5dOw4kECPGlMtTiRIT5hIlBl4mSHgP6V+6RpOwA0hgBBMuX1tJ+d6UaytHEHeZApd4XuBPqRvsQEap+8zorMOh48q6uhH/TEJnp0V9TtZ17mAYqasbSPfaKZ2YBAYD6/YwiZfqaBIsBQPgAzt7ykZ1dVOJOkHw/PDOxYtkmyZN4ZMkXPyJMAl8s/cUd0AFGHCnXPyJbdaSixffo0m40qfmGy/uMc+5hBwSJlkKdlxEEeZ6k5AMOsRzxIC2tj3k/d4hRTPa2nB4qK3tnaeQcKXNnIS5bW0bzZIzzMpMaXu5Dwlt5iS0kU09OslCwH25re0DCCmHaJsywIa95KjNc8WMS5fmYrt3j2AkiJ1D3d0z7J9CQvclcxImXbq0x7xjdV+aQcUndvch4a1L5iR0L5kLeO/oxPWE4OVuRMIIuPshrtlkdAku+M4ekDxPTKivn4Ht/jJNS33tO4denjhxxpqn5V9TWzvdfMasrzdv6sFaJjmxvi8J9auZxGv19asBC+rrKRJqJ74zA/7NsFiIOUK+gxMnPFcKcG26oA/YT1zDkNA1ffqC+gVPn5PWgNYsub6r6zVzErqA0t8kocuchK4FRIdfTZHQNXH6+oldb7H7rM4m1nf9j83zxvSGq3CT9Qu4NAkNDTY2s69eZZrAABQNDQwJON9qs+T/NDQcouJv973C6gZzEq4uIO+/nhQ0LIAEVZ7BoYYGMNJzBndB9dv2Nq8dZEaJ6mrUnOrq9U/bOptdXW1OwoDq6sVAH1OW0b5d3ZeEanMSqkkSRsw0FxyyvDxRESDheeNgS8v6mYuZzn+gZTF6KHrt5uKnueLslhamlmyoe0vLTEY7r4W50Nstb6DAXDmPjkO5Ny21b2ABe17L2yMsSWhp+Q+QMGBx87xdB5j0gebF2EJvN8+zfwoJzc0MCbugA99tZlx2ZnMziCgSmvuS0DzPrM3NDAkTZjOCmYub3+BakNDc/PxJgKbAxwezzUhomkY4a9PdXU8hoalpOh2H5ju+0fTmAOZKEKdQ1dSXhLvmJDTlMfERWECwcrCp6aAFCU1N/wkSJtTUQO0YEmqa7MlIzfp/HkdrmijhhDzkCCPyag5wKYKqzFxjWk0fEvJq8pjENoaEg28QgiqSkpomMAmNvTU14JbPH280mnHPz2tsJJrChthBfp+8exsbt82eCZi9t4poxohtjW8g+ztOrwJWGGobG/McLNxuWuNmup+wqxobZ6OXU+yZuxrXkwLyYSmvcdp6rlnlGqHrPX/MZio3Ye82OK9ctQvfd+bms2fzDiAdbbQDZ8/CMV8ECPYSQvuDeZu37TqQV7WXyTp7Vx5cZ9te2ogz9yJB3t6ZOLErD58WJgB3By2k8/bOxmVRxgN8TAiuzuZd6/8TLFh7gZnT10+fybXpRz/60Y9+9KMf/9X4/1Xm6LfQPBSYAAAAAElFTkSuQmCC"
                            alt=""
                          />
                        </div>
                        <div class="_2qIXCuoN">
                          <img alt="" class="ls-is-cached lazyloaded" src="/static/image/lottery_xl_img_vr-9ee0.png" data-src="/static/image/lottery_xl_img_vr-9ee0.png" />
                        </div>
                        <div class="_349CzCYy xJQe3jRu _1IpIguRl">
                          <span>进入场馆</span>
                        </div>
                      </div>
                      <div class="_3qsc2gtG"></div>
                    </li>
                    <!-- IG香港彩 -->
                    <li class="_3xMhR1us BOBCP" @click="goGamePage('ig', 'LOTTO', '')">
                      <div class="_2p3kUWUL _1vBjoqAI _1Rce9DUC" style="animation-delay: 0.2s">
                        <div class="_3Ii96E8G">
                          <img class="_2ywsn6BQ" src="/static/image/img_igxgc_title.png" alt="" />
                        </div>
                        <div class="_2qIXCuoN">
                          <img alt="" class="ls-is-cached lazyloaded" src="/static/image/lottery_xl_img_bob-1ffb.png" data-src="/static/image/lottery_xl_img_bob-1ffb.png" />
                        </div>
                        <div class="_349CzCYy xJQe3jRu _1IpIguRl">
                          <span>进入场馆</span>
                        </div>
                      </div>
                      <div class="_3qsc2gtG"></div>
                    </li>
                    <!-- IG时时彩 -->
                    <li class="_3xMhR1us BOBCP" @click="goGamePage('ig', 'LOTTERY', '')">
                      <div class="_2p3kUWUL _1vBjoqAI _1Rce9DUC" style="animation-delay: 0.2s">
                        <div class="_3Ii96E8G">
                          <img class="_2ywsn6BQ" src="/static/image/img_igssc_title.png" alt="" />
                        </div>
                        <div class="_2qIXCuoN">
                          <img alt="" class="ls-is-cached lazyloaded" src="/static/image/lottery_xl_img_double-f329.png" data-src="/static/image/lottery_xl_img_double-f329.png" />
                        </div>
                        <div class="_349CzCYy xJQe3jRu _1IpIguRl">
                          <span>进入场馆</span>
                        </div>
                      </div>
                      <div class="_3qsc2gtG"></div>
                    </li>
                    <!-- BBIN彩票 -->
                    <li class="_3xMhR1us BOBCP" @click="goGamePage('bbin', 'bbinlottery', '')">
                      <div class="_2p3kUWUL _1vBjoqAI _1Rce9DUC" style="animation-delay: 0.2s">
                        <div class="_3Ii96E8G">
                          <img class="_2ywsn6BQ" src="/static/image/img_bbincp_title.png" alt="" />
                        </div>
                        <div class="_2qIXCuoN">
                          <img alt="" class="ls-is-cached lazyloaded" src="/static/image/lottery_xl_img_tcg-2fb3.png" data-src="/static/image/lottery_xl_img_tcg-2fb3.png" />
                        </div>
                        <div class="_349CzCYy xJQe3jRu _1IpIguRl">
                          <span>进入场馆</span>
                        </div>
                      </div>
                      <div class="_3qsc2gtG"></div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="_9eNaWz24 nav" v-if="pcCategoriesLoaded && pcCategories.length === 0">
              <a @click="goNav('/cards')" :class="url == '/cards' ? '_5v-zJhSB _--jQI_nz' : '_5v-zJhSB '" href="javascript:;"
                >棋牌
                <div class="_17Hw2tUT"></div>
                <div class="P4bUdpZY _3hNI-m60"><span></span><span></span></div>
              </a>
              <div class="PjlHS4wt" style="display: none; background: #808080; background-color: #808080;">
                <div class="_1b6LLqfO">
                  <ul class="_2q_0n3sH">
                    <li class="_3xMhR1us OBESPORT" v-for="(item, index) in jokerList" :key="index" v-if="index < 4 && item.app_state == 1" @click="goGamePage(item.platform_name, item.game_code, '')">
                      <div class="d9QhCBa4 _1vBjoqAI _1Rce9DUC" style="animation-delay: 0.2s">
                        <div class="_3JFVWFYi">
                          <img src="/static/image/home_rebate_box3-d4a2.png" alt="" />
                        </div>
                        <div class="_3Ii96E8G">
                          <img class="_2ywsn6BQ" :src="jokerImg[item.platform_name]" alt="" />
                        </div>
                        <div class="_2qIXCuoN">
                          <img alt="" class="ls-is-cached lazyloaded" :src="jokerImgs[index]" />
                        </div>
                        <div class="_349CzCYy xJQe3jRu _1IpIguRl">
                          <span>进入场馆</span>
                        </div>
                      </div>
                      <div class="_3qsc2gtG"></div>
                    </li>
                  </ul>
                  <ul class="_2q_0n3sH" v-if="false">
                    <!-- BBIn棋牌 -->
                    <li class="_3xMhR1us BYQP">
                      <div class="_215bloyL _1vBjoqAI _1Rce9DUC" style="animation-delay: 0.3s">
                        <div class="_3Ii96E8G">
                          <img class="_2ywsn6BQ" src="/static/image/img_bbinqp_title.png" alt="" />
                        </div>
                        <div class="_2qIXCuoN" @click="goGamePage('bbin', 'bbinqp', '')">
                          <img alt="" class="ls-is-cached lazyloaded" src="/static/image/chess_xl_img_boya-8d32.png" data-src="/static/image/chess_xl_img_boya-8d32.png" />
                        </div>
                        <div class="_349CzCYy xJQe3jRu _1IpIguRl">
                          <span>进入场馆</span>
                        </div>
                      </div>
                      <div class="_3qsc2gtG"></div>
                    </li>
                    <!-- 开元 -->
                    <li class="_3xMhR1us LBQP" @click="goGamePage('leg', '7', '')">
                      <div class="_215bloyL _1vBjoqAI _1Rce9DUC" style="animation-delay: 0.7s">
                        <div class="_3Ii96E8G">
                          <img class="_2ywsn6BQ" src="/static/image/img_ky_title.png" alt="" />
                        </div>
                        <div class="_2qIXCuoN">
                          <img alt="" class="ls-is-cached lazyloaded" src="/static/image/chess_xl_img_lb-f82f.png" data-src="/static/image/chess_xl_img_lb-f82f.png" />
                        </div>
                        <div class="_349CzCYy xJQe3jRu _1IpIguRl">
                          <span>进入场馆</span>
                        </div>
                      </div>
                      <div class="_3qsc2gtG"></div>
                    </li>
                    <!-- 欢乐 -->
                    <li class="_3xMhR1us YYQP" @click="goGamePage('hlgame', '1', '')">
                      <div class="_215bloyL _1vBjoqAI _1Rce9DUC" style="animation-delay: 0.5s">
                        <div class="_3Ii96E8G">
                          <img class="_2ywsn6BQ" src="/static/image/img_hg_title.png" alt="" />
                        </div>
                        <div class="_2qIXCuoN">
                          <img alt="" class="ls-is-cached lazyloaded" src="/static/image/chess_xl_img_yy-e0e2.png" data-src="/static/image/chess_xl_img_yy-e0e2.png" />
                        </div>
                        <div class="_349CzCYy xJQe3jRu _1IpIguRl">
                          <span>进入场馆</span>
                        </div>
                      </div>
                      <div class="_3qsc2gtG"></div>
                    </li>
                    <!-- 乐游 -->
                    <li class="_3xMhR1us BOBQP" @click="goGamePage('ly', '1', '')">
                      <div class="_215bloyL _1vBjoqAI _1Rce9DUC" style="animation-delay: 0.2s">
                        <div class="_3Ii96E8G">
                          <img class="_2ywsn6BQ" src="/static/image/img_leg_title.png" alt="" />
                        </div>
                        <div class="_2qIXCuoN">
                          <img alt="" class="ls-is-cached lazyloaded" src="/static/image/chess_xl_img_bob-047c.png" data-src="/static/image/chess_xl_img_bob-047c.png" />
                        </div>
                        <div class="_349CzCYy xJQe3jRu _1IpIguRl">
                          <span>进入场馆</span>
                        </div>
                      </div>
                      <div class="_3qsc2gtG"></div>
                    </li>
                    <!-- 凯旋 -->
                    <li class="_3xMhR1us SY" @click="goGamePage('kx', '1', '')">
                      <div class="_215bloyL _1vBjoqAI _1Rce9DUC" style="animation-delay: 0.6s">
                        <div class="_3Ii96E8G">
                          <img class="_2ywsn6BQ" src="/static/image/img_kx_title.png" alt="" />
                        </div>
                        <div class="_2qIXCuoN">
                          <img alt="" class="ls-is-cached lazyloaded" src="/static/image/chess_xl_img_sy-5a46.png" data-src="/static/image/chess_xl_img_sy-5a46.png" />
                        </div>
                        <div class="_349CzCYy xJQe3jRu _1IpIguRl">
                          <span>进入场馆</span>
                        </div>
                      </div>
                      <div class="_3qsc2gtG"></div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="_9eNaWz24 nav" v-if="pcCategoriesLoaded && pcCategories.length === 0">
              <a @click="goNav('/amusement')" :class="url == '/amusement' || url == '/amusementList' ? '_5v-zJhSB _--jQI_nz' : '_5v-zJhSB '" href="javascript:;"
                >电子
                <div class="_17Hw2tUT"></div>
                <div class="P4bUdpZY _3hNI-m60"><span></span><span></span></div>
              </a>
              <div class="PjlHS4wt" style="display: none; background: #808080; background-color: #808080;">
                <div class="_1b6LLqfO">
                  <ul class="_2q_0n3sH">
                    <li class="_3xMhR1us OBESPORT" v-for="(item, index) in conciseList" :key="index" v-if="index < 4 && item.app_state == 1">
                      <div class="d9QhCBa4 _1vBjoqAI _1Rce9DUC" style="animation-delay: 0.2s" v-if="item.platform_name == 'obgdy' || item.platform_name == 'fgdz' || item.platform_name == 'pp' || item.platform_name == 'ae'" @click="goNav(`/amusementList?type=${item.platform_name}`)">
                        <div class="_3JFVWFYi">
                          <img src="/static/image/home_rebate_box3-d4a2.png" alt="" />
                        </div>
                        <div class="_3Ii96E8G">
                          <img class="_2ywsn6BQ" :src="conciseImg[item.platform_name]" alt="" />
                        </div>
                        <div class="_2qIXCuoN">
                          <img alt="" class="ls-is-cached lazyloaded" :src="conciseBg[item.platform_name] || conciseBgDefault" />
                        </div>
                        <div class="_349CzCYy xJQe3jRu _1IpIguRl">
                          <span>进入场馆</span>
                        </div>
                      </div>
                      <div class="d9QhCBa4 _1vBjoqAI _1Rce9DUC" style="animation-delay: 0.2s" v-else @click="goGamePage(item.platform_name, item.game_code, '')">
                        <div class="_3JFVWFYi">
                          <img src="/static/image/home_rebate_box3-d4a2.png" alt="" />
                        </div>
                        <div class="_3Ii96E8G">
                          <img class="_2ywsn6BQ" :src="conciseImg[item.platform_name]" alt="" />
                        </div>
                        <div class="_2qIXCuoN">
                          <img alt="" class="ls-is-cached lazyloaded" :src="conciseBg[item.platform_name] || conciseBgDefault" />
                        </div>
                        <div class="_349CzCYy xJQe3jRu _1IpIguRl">
                          <span>进入场馆</span>
                        </div>
                      </div>
                      <div class="_3qsc2gtG"></div>
                    </li>
                  </ul>
                  <ul class="_2q_0n3sH _1YZt-Bm7" v-if="false">
                    <!-- pg -->
                    <li class="_3xMhR1us FISH" @click="goGamePage('pg', '2', '')">
                      <div class="_1vBjoqAI _1Rce9DUC" style="animation-delay: 0.2s">
                        <div class="_3Ii96E8G">
                          <img class="_2ywsn6BQ" src="/static/image/img_pg_title.png" alt="" />
                        </div>
                        <div class="_2qIXCuoN">
                          <img alt="" class="ls-is-cached lazyloaded" src="/static/image/slot_xl_img_bob-1-3b3c.png" data-src="/static/image/slot_xl_img_fishing-9166.png" />
                        </div>
                        <div class="_349CzCYy xJQe3jRu _1IpIguRl">
                          <span>进入场馆</span>
                        </div>
                      </div>
                      <div class="_3qsc2gtG"></div>
                    </li>
                    <!-- bg 捕鱼 -->
                    <li class="_3xMhR1us FISH" @click="goGamePage('bg', 'egame', '')">
                      <div class="_1vBjoqAI _1Rce9DUC" style="animation-delay: 0.2s">
                        <div class="_3Ii96E8G">
                          <img class="_2ywsn6BQ" src="/static/image/img_bgby_title.png" alt="" />
                        </div>
                        <div class="_2qIXCuoN">
                          <img alt="" class="ls-is-cached lazyloaded" src="/static/image/slot_xl_img_fishing-9166.png" data-src="/static/image/slot_xl_img_fishing-9166.png" />
                        </div>
                        <div class="_349CzCYy xJQe3jRu _1IpIguRl">
                          <span>进入场馆</span>
                        </div>
                      </div>
                      <div class="_3qsc2gtG"></div>
                    </li>
                    <!-- pp -->
                    <li class="_3xMhR1us FISH" @click="goNav('/amusementList?type=pp')">
                      <div class="_1vBjoqAI _1Rce9DUC" style="animation-delay: 0.2s">
                        <div class="_3Ii96E8G">
                          <img class="_2ywsn6BQ" src="/static/image/img_pp_title.png" alt="" />
                        </div>
                        <div class="_2qIXCuoN">
                          <img alt="" class="ls-is-cached lazyloaded" src="/static/image/slot_xl_img_pg-ccb8.png" data-src="/static/image/slot_xl_img_fishing-9166.png" />
                        </div>
                        <div class="_349CzCYy xJQe3jRu _1IpIguRl">
                          <span>进入场馆</span>
                        </div>
                      </div>
                      <div class="_3qsc2gtG"></div>
                    </li>

                    <!-- ps -->
                    <li class="_3xMhR1us FISH">
                      <div class="_1vBjoqAI _1Rce9DUC" style="animation-delay: 0.2s">
                        <div class="_3Ii96E8G">
                          <img class="_2ywsn6BQ" src="/static/image/img_ps_title.png" alt="" />
                        </div>
                        <div class="_2qIXCuoN" @click="goGamePage('ps', '2', '')">
                          <img alt="" class="ls-is-cached lazyloaded" src="/static/image/slot_xl_img_pp-2dd4.png" data-src="/static/image/slot_xl_img_fishing-9166.png" />
                        </div>
                        <div class="_349CzCYy xJQe3jRu _1IpIguRl">
                          <span>进入场馆</span>
                        </div>
                      </div>
                      <div class="_3qsc2gtG"></div>
                    </li>
                    <!-- AG捕鱼  plat_name=ag&game_type=2-->
                    <li class="_3xMhR1us FISH" @click="goGamePage('ag', '2', '')">
                      <div class="_1vBjoqAI _1Rce9DUC" style="animation-delay: 0.2s">
                        <div class="_3Ii96E8G">
                          <img class="_2ywsn6BQ" src="/static/image/img_agby_title.png" alt="" />
                        </div>
                        <div class="_2qIXCuoN">
                          <img alt="" class="ls-is-cached lazyloaded" src="/static/image/slot_xl_img_fishing-9166.png" data-src="/static/image/slot_xl_img_fishing-9166.png" />
                        </div>
                        <div class="_349CzCYy xJQe3jRu _1IpIguRl">
                          <span>进入场馆</span>
                        </div>
                      </div>
                      <div class="_3qsc2gtG"></div>
                    </li>
                    <!-- AE -->
                    <!-- <li class="_3xMhR1us FISH">
                      <div class="_1vBjoqAI _1Rce9DUC" style="animation-delay: 0.2s">
                        <div class="_3Ii96E8G">
                          <img class="_2ywsn6BQ" src="/static/image/img_ae_title.png" alt="" />
                        </div>
                        <div class="_2qIXCuoN" @click="goGamePage('ae', 'ae', '')" >
                          <img alt="" class="ls-is-cached lazyloaded" src="/static/image/slot_xl_img_bob-6cbf.png" data-src="/static/image/slot_xl_img_bob-6cbf.png" />
                        </div>
                        <div class="_349CzCYy xJQe3jRu _1IpIguRl">
                          <span>进入场馆</span>
                        </div>
                      </div>
                      <div class="_3qsc2gtG"></div>
                    </li> -->
                    <!-- At -->
                    <!-- <li class="_3xMhR1us FISH">
                      <div class="_1vBjoqAI _1Rce9DUC" style="animation-delay: 0.2s">
                        <div class="_3Ii96E8G">
                          <img class="_2ywsn6BQ" src="/static/image/img_at_title.png" alt="" />
                        </div>
                        <div class="_2qIXCuoN" @click="goGamePage('at', 'at', '')">
                          <img alt="" class="ls-is-cached lazyloaded" src="/static/image/img_pg-523b.png" data-src="/static/image/img_pg-523b.png" />
                        </div>
                        <div class="_349CzCYy xJQe3jRu _1IpIguRl">
                          <span>进入场馆</span>
                        </div>
                      </div>
                      <div class="_3qsc2gtG"></div>
                    </li> -->
                    <!-- bbin -->
                    <!-- <li class="_3xMhR1us FISH">
                      <div class="_1vBjoqAI _1Rce9DUC" style="animation-delay: 0.2s">
                        <div class="_3Ii96E8G">
                          <img class="_2ywsn6BQ" src="/static/image/img_bbindz_title.png" alt="" />
                        </div>
                        <div class="_2qIXCuoN" @click="goGamePage('bbindz', 'bbindz', '')">
                          <img alt="" class="ls-is-cached lazyloaded" src="/static/image/img_pp-29ed.png" data-src="/static/image/img_pp-29ed.png" />
                        </div>
                        <div class="_349CzCYy xJQe3jRu _1IpIguRl">
                          <span>进入场馆</span>
                        </div>
                      </div>
                      <div class="_3qsc2gtG"></div>
                    </li>         -->

                    <!-- bng  -->
                    <!-- <li class="_3xMhR1us FISH">
                      <div class="_1vBjoqAI _1Rce9DUC" style="animation-delay: 0.2s">
                        <div class="_3Ii96E8G">
                          <img class="_2ywsn6BQ" src="/static/image/img_bng_title.png" alt="" />
                        </div>
                        <div class="_2qIXCuoN" @click="goGamePage('bng', 'bng', '')">
                          <img alt="" class="ls-is-cached lazyloaded" src="/static/image/slot_xl_img_fishing-9166.png" data-src="/static/image/slot_xl_img_fishing-9166.png" />
                        </div>
                        <div class="_349CzCYy xJQe3jRu _1IpIguRl">
                          <span>进入场馆</span>
                        </div>
                      </div>
                      <div class="_3qsc2gtG"></div>
                    </li>   -->
                    <!-- cg  -->
                    <!-- <li class="_3xMhR1us FISH">
                      <div class="_1vBjoqAI _1Rce9DUC" style="animation-delay: 0.2s">
                        <div class="_3Ii96E8G">
                          <img class="_2ywsn6BQ" src="/static/image/img_cg_title.png" alt="" />
                        </div>
                        <div class="_2qIXCuoN" @click="goGamePage('cg', 'cg', '')">
                          <img alt="" class="ls-is-cached lazyloaded" src="/static/image/slot_xl_img_fishing-9166.png" data-src="/static/image/slot_xl_img_fishing-9166.png" />
                        </div>
                        <div class="_349CzCYy xJQe3jRu _1IpIguRl">
                          <span>进入场馆</span>
                        </div>
                      </div>
                      <div class="_3qsc2gtG"></div>
                    </li>   -->
                    <!-- dt  -->
                    <!-- <li class="_3xMhR1us FISH">
                      <div class="_1vBjoqAI _1Rce9DUC" style="animation-delay: 0.2s">
                        <div class="_3Ii96E8G">
                          <img class="_2ywsn6BQ" src="/static/image/img_dt_title.png" alt="" />
                        </div>
                        <div class="_2qIXCuoN" @click="goGamePage('dt', 'dt', '')">
                          <img alt="" class="ls-is-cached lazyloaded" src="/static/image/slot_xl_img_fishing-9166.png" data-src="/static/image/slot_xl_img_fishing-9166.png" />
                        </div>
                        <div class="_349CzCYy xJQe3jRu _1IpIguRl">
                          <span>进入场馆</span>
                        </div>
                      </div>
                      <div class="_3qsc2gtG"></div>
                    </li>  -->
                    <!-- fg -->
                    <!-- <li class="_3xMhR1us FISH">
                      <div class="_1vBjoqAI _1Rce9DUC" style="animation-delay: 0.2s">
                        <div class="_3Ii96E8G">
                          <img class="_2ywsn6BQ" src="/static/image/img_fg_title.png" alt="" />
                        </div>
                        <div class="_2qIXCuoN" @click="goGamePage('gf', 'gf', '')">
                          <img alt="" class="ls-is-cached lazyloaded" src="/static/image/slot_xl_img_fishing-9166.png" data-src="/static/image/slot_xl_img_fishing-9166.png" />
                        </div>
                        <div class="_349CzCYy xJQe3jRu _1IpIguRl">
                          <span>进入场馆</span>
                        </div>
                      </div>
                      <div class="_3qsc2gtG"></div>
                    </li> -->

                    <!-- hb -->
                    <!-- <li class="_3xMhR1us FISH">
                      <div class="_1vBjoqAI _1Rce9DUC" style="animation-delay: 0.2s">
                        <div class="_3Ii96E8G">
                          <img class="_2ywsn6BQ" src="/static/image/img_hb_title.png" alt="" />
                        </div>
                        <div class="_2qIXCuoN" @click="goGamePage('habaner', 'habaner', '')">
                          <img alt="" class="ls-is-cached lazyloaded" src="/static/image/slot_xl_img_fishing-9166.png" data-src="/static/image/slot_xl_img_fishing-9166.png" />
                        </div>
                        <div class="_349CzCYy xJQe3jRu _1IpIguRl">
                          <span>进入场馆</span>
                        </div>
                      </div>
                      <div class="_3qsc2gtG"></div>
                    </li> -->
                    <!-- 皇朝 -->
                    <!-- <li class="_3xMhR1us FISH">
                      <div class="_1vBjoqAI _1Rce9DUC" style="animation-delay: 0.2s">
                        <div class="_3Ii96E8G">
                          <img class="_2ywsn6BQ" src="/static/image/img_hc_title.png" alt="" />
                        </div>
                        <div class="_2qIXCuoN" @click="goGamePage('hc', 'hc', '')">
                          <img alt="" class="ls-is-cached lazyloaded" src="/static/image/slot_xl_img_fishing-9166.png" data-src="/static/image/slot_xl_img_fishing-9166.png" />
                        </div>
                        <div class="_349CzCYy xJQe3jRu _1IpIguRl">
                          <span>进入场馆</span>
                        </div>
                      </div>
                      <div class="_3qsc2gtG"></div>
                    </li> -->
                    <!-- jdb -->
                    <!-- <li class="_3xMhR1us FISH">
                      <div class="_1vBjoqAI _1Rce9DUC" style="animation-delay: 0.2s">
                        <div class="_3Ii96E8G">
                          <img class="_2ywsn6BQ" src="/static/image/img_jdb_title.png" alt="" />
                        </div>
                        <div class="_2qIXCuoN" @click="goGamePage('jdb', 'jdb', '')">
                          <img alt="" class="ls-is-cached lazyloaded" src="/static/image/slot_xl_img_fishing-9166.png" data-src="/static/image/slot_xl_img_fishing-9166.png" />
                        </div>
                        <div class="_349CzCYy xJQe3jRu _1IpIguRl">
                          <span>进入场馆</span>
                        </div>
                      </div>
                      <div class="_3qsc2gtG"></div>
                    </li> -->

                    <!-- ob -->
                    <!-- <li class="_3xMhR1us FISH">
                      <div class="_1vBjoqAI _1Rce9DUC" style="animation-delay: 0.2s">
                        <div class="_3Ii96E8G">
                          <img class="_2ywsn6BQ" src="/static/image/img_obdz_title.png" alt="" />
                        </div>
                        <div class="_2qIXCuoN" @click="goGamePage('obgdy', 'obgdy', '')">
                          <img alt="" class="ls-is-cached lazyloaded" src="/static/image/slot_xl_img_fishing-9166.png" data-src="/static/image/slot_xl_img_fishing-9166.png" />
                        </div>
                        <div class="_349CzCYy xJQe3jRu _1IpIguRl">
                          <span>进入场馆</span>
                        </div>
                      </div>
                      <div class="_3qsc2gtG"></div>
                    </li> -->

                    <!-- sg -->
                    <!-- <li class="_3xMhR1us FISH">
                      <div class="_1vBjoqAI _1Rce9DUC" style="animation-delay: 0.2s">
                        <div class="_3Ii96E8G">
                          <img class="_2ywsn6BQ" src="/static/image/img_sg_title.png" alt="" />
                        </div>
                        <div class="_2qIXCuoN" @click="goGamePage('sg', 'sg', '')">
                          <img alt="" class="ls-is-cached lazyloaded" src="/static/image/slot_xl_img_fishing-9166.png" data-src="/static/image/slot_xl_img_fishing-9166.png" />
                        </div>
                        <div class="_349CzCYy xJQe3jRu _1IpIguRl">
                          <span>进入场馆</span>
                        </div>
                      </div>
                      <div class="_3qsc2gtG"></div>
                    </li> -->
                    <!-- zeus -->
                    <!-- <li class="_3xMhR1us FISH">
                      <div class="_1vBjoqAI _1Rce9DUC" style="animation-delay: 0.2s">
                        <div class="_3Ii96E8G">
                          <img class="_2ywsn6BQ" src="/static/image/img_zeus_title.png" alt="" />
                        </div>
                        <div class="_2qIXCuoN" @click="goGamePage('zeus', 'zeus', '')">
                          <img alt="" class="ls-is-cached lazyloaded" src="/static/image/slot_xl_img_fishing-9166.png" data-src="/static/image/slot_xl_img_fishing-9166.png" />
                        </div>
                        <div class="_349CzCYy xJQe3jRu _1IpIguRl">
                          <span>进入场馆</span>
                        </div>
                      </div>
                      <div class="_3qsc2gtG"></div>
                    </li> -->
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="_1XwyY7sN"></div>
        </div>
        <!-- 右侧图标按钮区域 -->
        <div class="header-icon-btns">
          <div class="header-icon-item" @click="openKefu">
            <img src="/static/image/kefu.png" alt="客服" />
            <span>客服</span>
          </div>
          <div class="header-icon-item" @click="goNav('/agent')">
            <img src="/static/image/heying.png" alt="合营" />
            <span>合营</span>
          </div>
          <div class="header-icon-item header-icon-dropdown" @click="goNav('/zhanzhu01')">
            <img src="/static/image/zanzhu.png" alt="赞助" />
            <span>赞助</span>
            <div class="icon-dropdown-panel zanzhu-dropdown">
              <div class="dropdown-item" @click.stop="goNav('/zhanzhu01')">威尔士国家队</div>
              <div class="dropdown-item" @click.stop="goNav('/zhanzhu02')">那不勒斯俱乐部</div>
              <div class="dropdown-item" @click.stop="goNav('/zhanzhu03')">多特蒙德俱乐部</div>
              <div class="dropdown-item" @click.stop="goNav('/zhanzhu04')">菲利波·因扎吉</div>
              <div class="dropdown-item" @click.stop="goNav('/zhanzhu05')">法甲里昂俱乐部</div>
            </div>
          </div>
          <div class="header-icon-item header-icon-dropdown" @click="goNav('/discount')">
            <img src="/static/image/youhui.png" alt="优惠" />
            <span>优惠</span>
            <div class="icon-dropdown-panel youhui-dropdown">
              <div class="dropdown-item" v-for="(item, index) in activityDropdownList" :key="index" @click.stop="goNav(`/discountInfo?id=${item.id}`)">{{ item.title }}</div>
              <div class="dropdown-item" v-if="activityDropdownList.length === 0">暂无优惠活动</div>
            </div>
          </div>
          <div class="header-icon-item" @click="goNav('/app')">
            <img src="/static/image/app.png" alt="APP" />
            <span>APP</span>
          </div>
          <!-- 登录后显示：存款、转账、取款、推广 -->
          <div v-show="is_login == 1" class="header-icon-item header-icon-large" style="margin-left: 20px;" @click="goNav('/mine/deposit')">
            <img src="/static/image/cunkuan.png" alt="存款" />
            <span>存款</span>
          </div>
          <div v-show="is_login == 1" class="header-icon-item header-icon-large" @click="goNav('/mine/transfer')">
            <img src="/static/image/zhuanzhang.png" alt="转账" />
            <span>转账</span>
          </div>
          <div v-show="is_login == 1" class="header-icon-item header-icon-large" @click="goNav('/mine/withdrawal')">
            <img src="/static/image/qukuan.png" alt="取款" />
            <span>取款</span>
          </div>
          <div v-show="is_login == 1" class="header-icon-item header-icon-large" @click="goNav('/mine/agent')">
            <img src="/static/image/tuiguang.png" alt="推广" />
            <span>推广</span>
          </div>
        </div>
        <!--已登录-->
        <div v-if="is_login == 1" class="user-info-panel">
          <div class="user-info-left">
            <div class="user-info-row user-name-row">
              <a href="javascript:;" @click="goNav('/mine/myVip')" class="username">{{ $store.state.userInfo.username ? $store.state.userInfo.username : '' }}</a>
              <a href="javascript:;" @click="goNav('/vipInfo')" class="vip-badge"><img :src="baseURL + $store.state.userInfo.vipname" alt="" /></a>
            </div>
            <div class="user-info-row user-balance-row">
              <span class="balance-symbol">¥</span>
              <span class="balance-amount">{{ balanceVisible ? ($store.state.userInfo.balance || '0.00') : '****' }}</span>
              <img class="balance-toggle" @click="toggleBalanceVisible" :src="balanceVisible ? '/static/image/see.png' : '/static/image/no_see.png'" alt="" />
            </div>
            <div class="user-info-row user-url-row">
              <span>永久网址:</span>
              <span class="site-url">{{ ($store.state.appInfo.h5_url || 'jiuyou.com').replace(/^https?:\/\//, '') }}</span>
            </div>
          </div>
          <div class="user-info-right">
            <div class="user-avatar" @click="goNav('/mine')">
              <img :src="$store.state.userInfo.avatar ? $store.state.userInfo.avatar : '/static/image/CristianoRonaldo.jpg'" alt="" />
            </div>
          </div>
        </div>
        <!--已登录-->
        <!--未登录-->
        <form v-if="is_login == 0" class="ant-form ant-form-horizontal _1_iN76zv login-form-inline">
          <input type="text" placeholder="用户名" maxlength="16" class="_10rTDi18 loginInput" autocomplete="none" id="name" v-model="username" />
          <div class="_1xLtCzwl">
            <input type="password" placeholder="密码" maxlength="16" class="_2uN-VcWm loginInput" id="password" v-model="psw" />
            <a v-show="!psw" class="_1ZUvLsxY" @click="openKefu" href="javascript:;">忘记?</a>
          </div>
          <div class="login-btn-wrapper">
            <div class="login-btn-group">
              <div class="_349CzCYy xJQe3jRu _3iaWcDfb" @click="login"><span>登录</span></div>
              <div class="_349CzCYy xJQe3jRu _3iaWcDfb" @click="goNav('/register')"><span><a>注册</a></span></div>
            </div>
            <div class="permanent-url-text">永久网址:{{$store.state.appInfo.h5_url}}</div>
          </div>
        </form>
        <!--未登录-->
      </div>
      <!--右下角悬浮项开始-->
      <!-- 新手帮助和在线客服已移除 -->
      <!-- <div class="_3KI9todu" style="bottom: 290px">
        <div class="_35z2_rOL" @click="goNav('/help?topType=3&sumType=2')">
          <img
            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFQAAABUCAMAAAArteDzAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAMAUExURUxpcf/////////////////////////////////////7++7SyOK9sPDYz+/Uy/Pg2eO8r+7Uy96yo/Xi2PHYz+O+sf/5+evJvebBs/DWzOvOw9aijtqolvDXzujKv9mqmevOxOvOw+3Rx+nIvOvMwdOahffj3dqpmO3Rxt2un9+1pdejkNObh/fk3fbj2+bCtOO7rN+4qOzQxunHuvTg2OC4qdmql+/0+fv8/fX3+ff6/O7y9vn8/u7z9/X4+vb5/Pn6/Ly/wt7n8Ovw9drj7fL2+Pv6+9ji7Nfd4uLp8ZOiweHp8PD1+Ozx9vr5+fDz9/r7/OTr8fH2+uXr8tvk7drj7Pf7/fr498TJznyMr/j5+97m7vP3+8TIy/H0+O3WzfPj3eju9OrPxPfr5W19nuvRx+TGuebt8uLo7u7Y0MediODn79zl7uvUyt3m79Te53eGp968reC5q+3z+PLb0vT4/PPc1O/Sx/Xg2erOwsPGyujMwM+qmL7BxOvMwPvt6PDXzfHZ0O7TyvDe1tjh6/P2+dbg69/l7Pjk3qu3z+7PxOfKvs/W3pCevcqgjOPKwM6tn3+Pst2you7a0d+/sJuow77CxvTn4fTe1omYt8HEyOnGudinlvno4sujkOTEteXNw/Dc08jMzurJvOHHvMihj+TJvOfPxeHCtNi9suLAsebHu9rg5mV1ltuvn9a6r86mlPDVy+jDtvHg2dLb5dDY4dbe6fX09du5qd61puHEuMvQ1OW9r9ajkObBs9zCuNOundTa37q9we3Vytqrm9a4qYGQsMrS2be6v3qKq2Fxk9G1rNWxocinnc/T2N3k6YSSssXM1NO0pq+1vL3I2tSei/fz8PHr6ufSyM6vppyqybK90sPN37zF02h4mnGAo8nN0NvAtO3v8crT3+Xq7ti1pKOwyqavvltrjfTv7cKglYaSqenh3+/x9Km31Z6ouHaDnqKtwpCcsn2KpuTW0t7GvOvn5oqWsKy2xpemw7i/ypWivNGZhN/OyLW4u9Gso6e4qsQAAACJdFJOUwAJEAwGDQgBAgQTN/xFKyJEgoYcVM4V2uny0LrV1PRutcOg7JbN1vXkxa6f8p/li7v2b6e03sD////////////////////////////////////////////////////////////////////////////////////////////////////////////+IxnCkAAAEBJJREFUeNqNmQlcU8e+x0MQreBe91qt1nu7t7e99z4LGFwCAiUUEFIRxIQlYAghgFRBloIJooYaHvBYVUCQsIMGAUGLgAiiAiICKqCA4r7Wve297zfnQFAhH/115Mw5mfPtb/4zZ87MHMYoGjfuvffeGz9+jJa2tg5Td/rUf/39a/9Nm/zDw2vnzPnwo6kTdZk62tpaY8aPR7Fx40YBaEKOGaulzdSd+NXX2/dshwICEhOBDQs7sHnzzp2zFgGsrTV2zLtiB5HwOOmr7a6urnugISzMhh3YunlnaGjGx4smwe8g9h1s0sjpf9/zC0RBExIGsQgCzMJraEZKyqzpNPZtZsfRsaSQe1zBhPbEdioqsiH3rCyFsrNTfABmQc04+BvBIrYE+xabiKUekHtcCTRd0VteXu7rGxeXm53qnpcnDwoKFIgFgs07A0NTDv52ZJYeYqs2q5mpM/Mr/nbKJz/r2unT167RUDh1z8sC00UgqK0Vil12Eq9H/P45U0czlWaO1WZO/Jow9/wSWxR87BgFJciKCvcsuTwoMFAA1R4QhvsLaa9+sycytcdqoIJJVX1qegCBCuuKgwkUPtNUHe3tZWvWrCkra2+/mSDl1YaFhYf7b0oXyonXI37f0CEYSR2q+r8SA7ZvT+D7FhcXB8NnufTmmhFqd/X3p5+GzpQUQp0xFILRfOq8/+GmRBV/u6J4717CVA4Ty97gJiQmhgt5PLE8hZidPVmH9joKc/KH/ptUAfy6XbsIs7P9R4ggRqJx3TU9lscTCNJSCHb2pJFUVJ5ihqdLVbxgT0CDK9pXrSJMmkoOyKu16sdVq9bwhbxOpVKZhxj8RlERgNcDSuqONpV27vX03LX3WMcqMDULWOimUNyZlqbIy4BZEoFXw0r3pZkLxQfC0xW74LO4d833q6zVWmW9Csl6hL7//kdpZ5oiU5GFLntw1kz0rGEqCag2c5FALCRMxDMW5SHr74cBOEF6Awp1KNMyn1RkhcLsQqY2CeswU4v5nQugaYQZnGANLV++3Ho5fbOBtYHBcgPqHEl9HQeAbyoVT6qq5BgLUqYyqcYa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"
            alt=""
          />
        </div>
        <div>新手帮助</div>
      </div>
      <div class="_3KI9todu" style="bottom: 200px">
        <div class="_35z2_rOL" @click="openKefu">
          <img
            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFQAAABUCAMAAAArteDzAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAMAUExURUxpcf////////////////////////////////////////Td1P/5+f////Pf1+/Uy+vNwuO8r+zOxN2woO/Vy/HYz/DXzuzOw/Xf1+O+se3Qxffm3vfj3daijuvPwtqolvDXzerKv/HZ0ejEtuzOxOjKv+3TydOahe3e19qpmO/TyezPxeO8rOzPxeXBtNqpmNmqmdejkOW+sPfk3eC1punJvN62pubBs9+1ptKYg/jn4PTg2OC4qObW0Onw9ff5+/n6/PX4+ujv9drk7vv8/fD09+Xs8+Dp8e7z99fh697m7urx9vH1+Pr8/e3y9t/o8OLq8u70+eTq8fj7/fv5+ff6/dnj7PT4+/r49+Lp8fL2+uzx9eDo8Oft8/r8/uzy+Pv6+/T2+dzl7u7Y0PTj3PP4++Xt9OTs8+rPw+3Wzd3l7fX5/YKRse/Uy/H2+u3Uyunu9PLh2vHZ0PDXzeLAsevRx+vw9PTf197n7+bCs3SDpOTGuOC5quHHu3eGp+zMwOjLwHqJq/Tp5N2yourJvPjm3/Lb0u3Rxs6olvDe1sihjtbg6vTl32R0lr2/wdfi7OnGud27rO3Pw+TJvN22p9DY4Gl5m8meit6/sOG7rvDc1MediObHu/np5M/W3Pvt6OfJvtrg5evTye/SyNi9stTc56q41G9+ntajkdvj6+XNw9e4qdiol9uvn82kkubQx9/l632NruW+r9vAtu/b0ta6r+TKv+fDtuPDtejNxNXa38DGzXCAorq+xMusodSfi8uijt/DtsXL0MrR1/bx79G1rNWyobK2ucHExtqsnOXq7tCuoMTHyr3Cxs+sm7e7wPfs5/Pt69SunaWyzpakwre7vV5ukK272J+tyvj19N3EuujOwOHKwczU3MrO0omWtMemnLW4u/b29/Pz9Ni1pM+wp6e104+evIuZt9S0pqWuwNGrmO/v8ezp6eni4M7Y5NLV2ZWfsePV0Jqox7vH37jD2auxusGflMajlbG3wbO90sDK2tGZhISPpcDM4sq3sd+a1E4AAAA+dFJOUwAKDBAGCA0BAgQP/hQSIivVRDbA8T33okXOlBvauk7V0+lb5Yb0eM379ePE3bT0hWef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"
            alt=""
          />
        </div>
        <div>在线客服</div>
      </div> -->
      <!-- <div class="_3KI9todu" style="bottom: 200px">
        <div class="_35z2_rOL">
          <img
            src="data:image/png;base64,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"
            alt=""
          />
        </div>
        <div>官方登录器</div>
      </div> -->
      <div class="ant-back-top _3O809Ks9" style="bottom: 130px">
        <div class="">
          <div class="eXcZ1T4r">
            <img
              src="data:image/png;base64,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"
              alt=""
            />
          </div>
          <span>回到顶部</span>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: 'Header',
  data() {
    return {
      is_login: 0,
      psw: null,
      dogameLis: [],
      gameUrlListL: [],
      url: '',
      baseURL: '',
      username: null,
      jumpUrl: null,
      show: false,
      balanceVisible: true,
      realbetList: [],
      jokerList: [],
      gamingList: [],
      sportList: [],
      lotteryList: [],
      conciseList: [],
      activityDropdownList: [],
      pcCategories: [], // PC端游戏分类数据
      pcCategoriesLoaded: false, // PC端游戏分类是否加载完成
      sportImg: {
        sbtest: '/static/image/img_saba_title.png',
        oap: '/static/image/img_ss_title.png',
        cmd: '/static/image/img_cmd_title.png',
        hbb: '/static/image/img_asia_title.png',
        saba: '/static/image/img_tgty_title.png',
        xsbo: '/static/image/img_sbo_title.png',
        obgty: '/static/image/img_obty_title.png',
        bbin: '/static/image/img_bbinty_title.png',
      },
      sportBgDefault: '/static/image/sport_xl_img_bob-5566.png',
      sportBg: {
        xsbo: '/static/image/sport_xl_img_fb-cae6.png',
        cmd: '/static/image/sport_xl_img_im-c07e.png',
        saba: '/static/image/sport_xl_img_bob-5566.png',
        obgty: '/static/image/sport_xl_img_bob-5566.png',
        bbin: '/static/image/sport_xl_img_bob-5566.png',
        oap: '/static/image/sport_xl_img_bob-5566.png',
        sbtest: '/static/image/sport_xl_img_bob-5566.png',
        hbb: '/static/image/sport_xl_img_bob-5566.png'
      },
      sportImgs: ['/static/image/sport_xl_img_bob-5566.png', '/static/image/sport_xl_img_fb-cae6.png', '/static/image/sport_xl_img_im-c07e.png'],
      gamingImg: {
        ia: '/static/image/img_ia_title.png',
        ld: '/static/image/img_ld_title-.png',
        avia: '/static/image/img_avia_title.png',
        obgdj: '/static/image/img_obdj_title.png',
      },
      gamingBgDefault: '/static/image/gaming_xl_img_bob-14bd.png',
      gamingBg: {
        ia: '/static/image/gaming_xl_img_avia-1b4b.png',
        ld: '/static/image/gaming_xl_img_bob-14bd.png',
        avia: '/static/image/gaming_xl_img_avia-1b4b.png',
        obgdj: '/static/image/gaming_xl_img_bob-14bd.png'
      },
      gamingImgs: ['/static/image/esport_xl_img_im-a454.png', '/static/image/gaming_xl_img_bob-14bd.png', '/static/image/gaming_xl_img_avia-1b4b.png'],
      realbetImg: {
        bbin: '/static/image/img_bbinzr_title.png',
        bg: '/static/image/img_bgzr_title.png',
        ag: '/static/image/img_ag_title.png',
        wm: '/static/image/img_wm_title.png',
        qg: '/static/image/img_og_title.png',
        dg: '/static/image/img_dg_title.png',
        allbet: '/static/image/img_allbet_title.png',
        obgzr: '/static/image/img_obzr_title.png',
      },
      realbetImgs: ['/static/image/live_xl_img_bob-c013.png', '/static/image/live_xl_img_ag-f4fe.png', '/static/image/live_xl_img_wm-0725.png', '/static/image/live_xl_img_bg-d46a.png'],
      lotteryImg: {
        yb: '/static/image/img_tgcp_title.png',
        vrbet: '/static/image/img_vr-dea3.png',
        GFC: '/static/image/img_iggfc_title.png',
        LOTTO: '/static/image/img_igxgc_title.png',
        LOTTERY: '/static/image/img_igssc_title.png',
        gfc: '/static/image/img_iggfc_title.png',
        lotto: '/static/image/img_igxgc_title.png',
        Llottery: '/static/image/img_igssc_title.png',
        dl: '/static/image/img_dl_title.png',
        bbin: '/static/image/img_bbincp_title.png',
        tc: '/static/image/img_tcg_title.png',
        imone: '/static/image/img_sy-7dd9.png',
        obgcp: '/static/image/img_obcp_title.png',
        jz: '/static/image/img_jz_title.png',
      },
      lotteryImgs: ['/static/image/lottery_xl_img_vr-9ee0.png', '/static/image/lottery_xl_img_bob-1ffb.png', '/static/image/lottery_xl_img_double-f329.png', '/static/image/lottery_xl_img_tcg-2fb3.png'],
      jokerImg: {
        bbin: '/static/image/img_bbinqp_title.png',
        bg: '/static/image/img_bgqp_title.png',
        datqp: '/static/image/img_dt_title1.png',
        fg: '/static/image/img_fgqp_title.png',
        hlgame: '/static/image/img_hg_title.png',
        kx: '/static/image/img_kx_title.png',
        kx2: '/static/image/img_kx2_title.png',
        leg: '/static/image/img_ky_title.png',
        obgqp: '/static/image/img_obqp_title.png',
        sy: '/static/image/img_syqp_title.png',
        vg: '/static/image/img_vg_title.png',
        xsj: '/static/image/img_xsj_title.png',
        ly: '/static/image/img_leg_title.png',
      },
      jokerImgs: ['/static/image/chess_xl_img_boya-8d32.png', '/static/image/chess_xl_img_lb-f82f.png', '/static/image/chess_xl_img_yy-e0e2.png', '/static/image/chess_xl_img_bob-047c.png'],
      conciseImg: {
        ae: '/static/image/img_ae_title.png',
        icg: '/static/image/img_at_title.png',
        bbin: '/static/image/img_bbindz_title.png',
        bg: '/static/image/img_bgby_title.png',
        bng: '/static/image/img_bng_title.png',
        cg: '/static/image/img_cg_title.png',
        dt: '/static/image/img_dt_title.png',
        fgdz: '/static/image/img_fg_title.png',
        habaner: '/static/image/img_hb_title.png',
        hc: '/static/image/img_hc_title.png',
        jdb: '/static/image/img_jdb_title.png',
        obgpy: '/static/image/img_obby_title.png',
        obgdy: '/static/image/img_obdz_title.png',
        pg: '/static/image/img_pg_title.png',
        pp: '/static/image/img_pp_title.png',
        ps: '/static/image/img_ps_title.png',
        sg: '/static/image/img_sg_title.png',
        zeus: '/static/image/img_zeus_title.png',
        bbdz: '/static/image/img_bbindz_title.png',
        egame: '/static/image/img_bgby_title.png',
      },
      conciseBgDefault: '/static/image/slot_xl_img_bob-6cbf.png',
      conciseBg: {
        obgdy: '/static/image/slot_xl_img_bob-6cbf.png',
        obgpy: '/static/image/slot_xl_img_fishing-9166.png',
        fgdz: '/static/image/slot_xl_img_bob-6cbf.png',
        pg: '/static/image/slot_xl_img_pg-ccb8.png',
        pp: '/static/image/slot_xl_img_pp-2dd4.png',
        ae: '/static/image/slot_xl_img_pg-ccb8.png'
      },
      conciseImgs: ['/static/image/slot_xl_img_fishing-9166.png', '/static/image/slot_xl_img_pg-ccb8.png', '/static/image/slot_xl_img_pp-2dd4.png', '/static/image//slot_xl_img_bob-6cbf.png'],
      index: 0,
      imgLis: ['2PYL', '6AQ5', '8PHD', '21I7', '69HM', 'ACWA', 'DUZ7', 'IY98', 'K647', 'M52T', 'NY52', 'NZFA', 'SN76', 'SP4D', 'VAEO', 'YFQM', 'ZZU5', '7GQT', 'LFW3', 'NU2T', 'UAE3'],

    };
  },
  computed: {
    // 获取主分类列表（pid = 0）
    mainCategoryList() {
      return this.pcCategories.filter(cat => cat.pid == 0 || !cat.pid);
    }
  },
  created() {
    // console.log(this.$store.state.userInfo)
    let that = this;
    that.baseURL = sessionStorage.getItem('baseURL') || '';
    console.log(sessionStorage.getItem('baseURL'));
    if (this.$store.state.userInfo.username) {
      that.username = this.$store.state.userInfo.username;
    }
    // 获取信息数量
    // that.getDatalist();

    // 获取平台全部游戏
    // that.getdogame();
    // 获取游戏code
    // that.gamelistBycode();
    that.url = this.$route.fullPath;
    that.getGameList();
    that.getActivityDropdown();
    that.getPcCategories(); // 获取PC端游戏分类
    // that.getGameList('joker');
    // that.getGameList('gaming');
    // that.getGameList('sport');
    // that.getGameList('lottery');
    // that.getGameList('concise');
  },
  methods: {
    toggleBalanceVisible() {
      this.balanceVisible = !this.balanceVisible;
    },
    changIndex() {
      this.index = parseInt(20 * Math.random());
    },
    // 获取PC端游戏分类数据
    getPcCategories() {
      let that = this;
      that.$apiFun.get('/api/game/pc_categories', {}).then(res => {
        if (res.code == 200) {
          that.pcCategories = res.data || [];
        }
        that.pcCategoriesLoaded = true;
      }).catch(err => {
        console.error('获取PC端游戏分类失败:', err);
        that.pcCategoriesLoaded = true;
        // 请求失败时保持 pcCategories 为空数组，将显示静态导航
      });
    },
    // 获取分类对应的路由路径
    getCategoryRoute(code) {
      const routeMap = {
        'sport': '/sports',
        'gaming': '/electronic',
        'realbet': '/people',
        'joker': '/cards',
        'lottery': '/lottery',
        'concise': '/amusement'
      };
      return routeMap[code] || '/';
    },
    // 判断分类是否激活
    isCategoryActive(code) {
      const routeMap = {
        'sport': ['/sports'],
        'gaming': ['/electronic'],
        'realbet': ['/people'],
        'joker': ['/cards'],
        'lottery': ['/lottery'],
        'concise': ['/amusement', '/amusementList']
      };
      const routes = routeMap[code] || [];
      return routes.includes(this.url);
    },
    // 点击弹出层游戏（不需要登录判断，只切换 games 显示）
    onGameClick(game) {
      // 根据 child_id 切换 games 显示
      if (game.child_id) {
        this.$root.$emit('switchGamesByChildId', game.child_id);
      }
    },
    // 点击弹出层子元素（根据 changguan 值显示 games）
    onCategoryPopupClick(gameNav) {
      // 如果有 changguan 值，通过 changguan 显示对应的 games
      if (gameNav.changguan) {
        this.$root.$emit('switchGamesByChangguan', gameNav.changguan);
      }
      // 如果有 child_id，也可以通过 child_id 显示 games
      else if (gameNav.child_id) {
        this.$root.$emit('switchGamesByChildId', gameNav.child_id);
      }
    },
    // 显示下拉菜单
    showDropdown(event, category) {
      const dropdown = event.currentTarget.querySelector('.PjlHS4wt');
      if (dropdown) {
        // 先设置display，然后添加动画类
        dropdown.style.display = 'block';
        // 使用requestAnimationFrame确保display生效后再添加动画
        this.$nextTick(() => {
          dropdown.classList.remove('popup-hide');
          dropdown.classList.add('popup-show');
        });
      }
      const overlay = document.querySelector('._1XwyY7sN');
      if (overlay) {
        overlay.classList.add('_2fDy0Bg6');
      }
    },
    // 隐藏下拉菜单
    hideDropdown(event) {
      const dropdown = event.currentTarget.querySelector('.PjlHS4wt');
      if (dropdown) {
        // 先添加隐藏动画类
        dropdown.classList.remove('popup-show');
        dropdown.classList.add('popup-hide');
        // 动画结束后隐藏
        setTimeout(() => {
          if (dropdown.classList.contains('popup-hide')) {
            dropdown.style.display = 'none';
            dropdown.classList.remove('popup-hide');
          }
        }, 500); // 与动画时间一致
      }
      const overlay = document.querySelector('._1XwyY7sN');
      if (overlay) {
        overlay.classList.remove('_2fDy0Bg6');
      }
    },
    // 点击分类导航
    onCategoryClick(code, banner) {
      // 隐藏轮播图，显示当前分类的 banner
      if (banner) {
        this.$root.$emit('showCategoryBanner', banner);
      }
      // 导航到对应页面
      this.goNav(this.getCategoryRoute(code));
    },
    getGameList() {
      let that = this;

      that.$apiFun.get('/api/game/list', { category: '' }).then(res => {
        if (res.code == 200) {
          // API返回的数据结构是 {list: Array, app_list: Array}
          let data = res.data;
          let list = Array.isArray(data) ? data : (data.list || []);
          // 检查 list 是否为数组
          if (Array.isArray(list)) {
            list.forEach(el => {
              if (el.category_id == 'realbet') {
                that.realbetList.push(el);
              }
              if (el.category_id == 'joker') {
                that.jokerList.push(el);
              }
              if (el.category_id == 'gaming') {
                that.gamingList.push(el);
              }
              if (el.category_id == 'sport') {
                that.sportList.push(el);
              }
              if (el.category_id == 'lottery') {
                that.lotteryList.push(el);
              }
              if (el.category_id == 'concise') {
                that.conciseList.push(el);
              }
            });
          } else {
            console.warn('游戏列表数据格式不正确:', list);
          }
        }
      });
    },
    getActivityDropdown() {
      let that = this;
      that.$apiFun.post('/api/activitylist', {}).then(res => {
        if (res.code === 200) {
          that.activityDropdownList = res.data.data ? res.data.data.slice(0, 5) : [];
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
      type = type || 0;
      that.$apiFun.post('/api/getGameUrl', { plat_name: name, game_type: type, game_code: code, is_mobile_url: 0 }).then(res => {
        console.log(res);
        if (res.code != 200) {
          that.showTost(res.message);
        }
        if (res.code == 200) {
          that.jumpUrl = res.data.url;
        }
      });
    },
    getdogame() {
      let that = this;
      that.$apiFun.post('/api/getdogame', {}).then(res => {
        console.log(res);
        if (res.code != 200) {
          that.showTost(res.message);
        }
        if (res.code == 200) {
          that.dogameLis = res.data;
          let gameUrl = [];
          for (let code in res.data) {
            // pp:PP电子  ae:AE电子  fg:FG电子    obgdy:OBG电子
            // 没有二级游戏的直接查地址
            if (code != 'pp' || code != 'ae' || code != 'fg' || code != 'obgdy') {
              //  that.getGameUrl(code,res.data[code])
              // console.log(`${code}:${res.data[code]}`)
            }
            if (code == 'pp' || code == 'ae' || code == 'fg' || code == 'obgdy') {
            }
            console.log(`${code}:${res.data[code]}`);
          }
          // bbinqp:BINN棋牌
          // that.getGameUrl('bbinqp','BINN棋牌')
        }
      });
    },
    //  参数  gamecode  pp ae fg obgdy  获取二级游戏 获取二级游戏
    // 游戏地址之前发的就两个参数，plat_name是游戏名称代码，game_type是游戏类型代码
    gamelistBycode() {
      let that = this;
      //  pp ae fg obgdy
      that.$apiFun.post('/api/gamelistBycode', { gamecode: 'bbin' }).then(res => {
        console.log(res);
        if (res.code != 200) {
          that.showTost(res.message);
        }
        if (res.code == 200) {
        }
      });
    },
    // plat_name	是	string	平台名称
    // game_type	是	string	游戏类型
    // game_code	否	string	游戏代码
    getGameUrl(code, name) {
      let that = this;
      //  pp ae fg obgdy
      that.$apiFun.post('/api/getGameUrl', { plat_name: code, game_type: code, game_code: '', is_mobile_url: 0 }).then(res => {
        console.log(res);
        if (res.code != 200) {
          that.showTost(res.message);
        }
        if (res.code == 200) {
        }
      });
    },
    getDatalist() {
      let that = this;
      that.$apiFun.post('/api/noticeList', { page: 1 }).then(res => {
        if (res.code != 200) {
          that.showTost(res.message);
        }
        if (res.code == 200) {
          that.$store.commit('changMessageNum', res.data.total);
        }
      });
    },
    goNav(url) {
      let that = this;
      // let urlStr = url.split('?')[0];
      console.log(this.$route.fullPath);
      if (url == this.$route.fullPath) {
        that.$parent.showTost('您就在当前页');
        return;
      }
      if (url == '/agent') {
        const routeData = this.$router.resolve({
          path: url,
          query: {},
        });
        that.jumpUrl = routeData.href;
        return;
      }
      // 如果点击首页，显示轮播图
      if (url === '/' || url === '/index') {
        that.$root.$emit('showCarousel');
      }
      this.url = url;
      this.$router.push({ path: url });
    },
    outLogin() {
      let that = this;
      that.show = true;

      this.$parent.close();
      that.is_login = 0;
      that.$apiFun
        .post('/api/logoff', {})
        .then(res => {
          that.show = false;
          localStorage.clear();
          sessionStorage.clear();
          that.$store.commit('changUserInfo');
          that.$store.commit('changToken');
          that.goNav('/login');
        })
        .catch(() => {
          localStorage.clear();
          sessionStorage.clear();
          that.$store.commit('changUserInfo');
          that.$store.commit('changToken');

          that.show = false;
          that.goNav('/login');
        });
    },
    login() {
      let that = this;

      let userInfo = that.$store.state.userInfo;
      userInfo.username = that.username;
      if (!that.psw || that.psw.length < 6) {
        that.showTost('请输入正确的密码长度！');

        return;
      }
      //
      if (!userInfo.username || userInfo.username.length < 4) {
        that.showTost('请输入正确的账号信息！');

        return;
      }
      let info = {
        name: userInfo.username,
        password: that.psw,
      };
      that.show = true;
      that.$apiFun.login(info).then(res => {
        if (res.code !== 200) {
          that.showTost(res.message);
          that.show = false;
        }
        if (res.code === 200) {
          that.getUserInfo();

          sessionStorage.setItem('token', res.data.api_token);
          that.$store.commit('changToken');

          that.is_login = 1;
          that.psw = info.password;
          that.$parent.openDaoTime();
        }
      });
    },
    getUserInfo() {
      let that = this;
      that.$apiFun.post('/api/user', {}).then(res => {
        console.log(res);
        that.show = false;

        if (res.code !== 200) {
          that.showTost(res.message);
        }
        if (res.code === 200) {
          that.showTost('登陆成功！');

          let userInfo = res.data;
          let str = userInfo.current_vip;
          let index = str.indexOf('P');
          let vip = str.substr(index + 1, str.length); //04
          userInfo.vip = vip;
          localStorage.setItem('userInfo', JSON.stringify(userInfo));
          that.userInfo = userInfo;
          that.$store.commit('changUserInfo');
        }
      });
    },

    openKefu() {
      let that = this;
      that.$parent.openKefu();
    },
    copyUrl() {
      let that = this;
      let url = that.$store.state.appInfo.h5_url || 'jiuyou.com';
      navigator.clipboard.writeText(url).then(() => {
        that.showTost('网址已复制');
      }).catch(() => {
        // 降级方案
        let input = document.createElement('input');
        input.value = url;
        document.body.appendChild(input);
        input.select();
        document.execCommand('copy');
        document.body.removeChild(input);
        that.showTost('网址已复制');
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
    let that = this;
    that.is_login = sessionStorage.getItem('token') ? 1 : 0;
    that.userInfo = JSON.parse(localStorage.getItem('userInfo'));
    // 监听localhostStorage的数据变化，结合utils/tool.js配合使用
    window.addEventListener('setItemEvent', function (e) {
      console.log(e);
      // let newdata = JSON.parse(e.newValue)
      // that.order = newdata.order
      // that.cart = newdata.cart
    });
    //导航下拉

    $('.nav').hover(
      function () {
        $(this).find('.PjlHS4wt').css('display', 'block');
        $('._1XwyY7sN').addClass('_2fDy0Bg6');
      },
      function () {
        $(this).find('.PjlHS4wt').css('display', 'none');
        $('._1XwyY7sN').removeClass('_2fDy0Bg6');
      },
    );

    // 图标按钮下拉
    $('.header-icon-dropdown').hover(
      function () {
        $(this).find('.icon-dropdown-panel, .sponsor-dropdown-panel').css('display', 'flex');
      },
      function () {
        $(this).find('.icon-dropdown-panel, .sponsor-dropdown-panel').css('display', 'none');
      },
    );

    // 回到顶部的显示与隐藏
    $(window).on('load scroll', function () {
      var top = $(document).scrollTop(),
        wHeight = $(window).height();
      if (top > wHeight) {
        $('.ant-back-top').fadeIn('fast');
      } else {
        $('.ant-back-top').hide();
      }
    });
    // 回到顶部
    $('.ant-back-top').on('click', function () {
      $('html,body').stop().animate(
        {
          scrollTop: 0,
        },
        500,
      );
    });
    //底部logo鼠标经过效果_1XwyY7sN _2fDy0Bg6
    $('.foot_logo').hover(
      function () {
        var src = $(this).find('img').attr('src');
        src = src.substring(0, src.lastIndexOf('.'));
        $(this)
          .find('img')
          .attr('src', src + '-hover.png');
      },
      function () {
        var src = $(this).find('img').attr('src');
        src = src.substring(0, src.lastIndexOf('-hover.png'));
        $(this)
          .find('img')
          .attr('src', src + '.png');
      },
    );
  },
  updated() {
    // ----------页头  页脚  主页 逻辑
    // this.url = this.$route.fullPath;
  },
  watch: {
    // 新窗口打开页面，解决浏览器拦截问题
    jumpUrl() {
      if (this.jumpUrl) {
        window.open(this.jumpUrl, '_blank');
      }
      this.jumpUrl = null;
    },
    '$store.state.token': {
      handler: function (newVal, oldVal) {
        let that = this;
        that.is_login = sessionStorage.getItem('token') ? 1 : 0;
      },
    },
  },
};
</script>
<style lang="scss" scoped>
.nRE1dUST ._9eNaWz24{
  font-size: 18px !important;
  color: #ffffffb2 !important;
  font-family: "PingFang SC", "DIN Pro", dinpro, PingFangSC-Regular, "SF Pro SC", "SF Pro Text", "Microsoft Yahei", "Helvetica Neue", Helvetica, Arial, sans-serif !important;
  font-feature-settings: "tnum" !important;
}

// 导航栏整体布局优化
::v-deep .nRE1dUST {
  align-items: center !important;
}

// 图标按钮文字缩小
::v-deep .header-icon-item span {
  font-size: 11px !important;
}

// 导航滚动容器样式
.nav-scroll-container {
  max-width: 30vw !important; // 限制最大宽度
  overflow-x: auto !important;
  overflow-y: hidden !important;
  flex-wrap: nowrap !important;
  scrollbar-width: none !important; // Firefox 隐藏滚动条
  -ms-overflow-style: none !important; // IE 隐藏滚动条
  flex-shrink: 1 !important;
  &::-webkit-scrollbar {
    display: none !important; // Chrome/Safari 隐藏滚动条
  }
}

// 重置所有子元素的 order 属性，覆盖 style.css 中的 nth-child order 规则
// 确保动态导航按照 DOM 顺序显示（首页 -> 动态分类 -> 代理登录）
::v-deep .nRE1dUST .X_9C3y3f.nav-scroll-container > div {
  -webkit-order: 0 !important;
  order: 0 !important;
}

// 动态导航菜单游戏名称覆盖层样式
.game-name-overlay {
  position: absolute;
  bottom: 40px;
  left: 0;
  right: 0;
  text-align: center;
  color: #fff;
  font-size: 14px;
  font-weight: 600;
  text-shadow: 0 1px 3px rgba(0, 0, 0, 0.5);
  padding: 5px;
  background: linear-gradient(transparent, rgba(0, 0, 0, 0.6));
}

// 动态导航游戏列表样式
.pc-category-games {
  display: flex !important;
  flex-wrap: wrap !important;
  gap: 15px !important;
  padding: 15px !important;
}

.pc-category-games li {
  flex: 0 0 calc(25% - 12px) !important;
  min-width: 180px !important;
}

.gameNametop {
  padding-top: 30px;
  height: 60px;
  font-size: 24px;
  font-weight: 700;
}

// 弹出层背景色改为灰色
::v-deep .PjlHS4wt {
  background: #808080 !important;
  background-color: #808080 !important;
}

// 单个元素布局：左侧logo、中间标题、右侧按钮
::v-deep ._1Rce9DUC {
  display: flex !important;
  align-items: center !important;
  padding: 16px 20px !important;
  gap: 20px !important;
}

// 内容区域布局
::v-deep ._1Rce9DUC ._2i_36JbR {
  display: flex !important;
  align-items: center !important;
  flex: 1 !important;
  gap: 20px !important;
  position: relative !important;
}

// 左侧logo（方形，白色背景，绿色边框，Nine game文字）
::v-deep ._1Rce9DUC ._2i_36JbR::before {
  content: 'Nine game' !important;
  width: 60px !important;
  height: 60px !important;
  background: #fff !important;
  border: 2px solid #4CAF50 !important;
  border-radius: 4px !important;
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
  flex-shrink: 0 !important;
  font-size: 10px !important;
  font-weight: bold !important;
  color: #000 !important;
  text-align: center !important;
  line-height: 1.2 !important;
  padding: 4px !important;
  box-sizing: border-box !important;
}

// 中间标题区域（垂直排列）
::v-deep ._1Rce9DUC ._2i_36JbR > div:first-of-type {
  display: flex !important;
  flex-direction: column !important;
  gap: 4px !important;
}

// 主标题
::v-deep ._1Rce9DUC ._1IpseGVC {
  font-size: 24px !important;
  font-weight: bold !important;
  color: #fff !important;
  margin: 0 !important;
  line-height: 1.2 !important;
}

// 英文副标题
::v-deep ._1Rce9DUC ._2ln0B4fc {
  font-size: 12px !important;
  color: #fff !important;
  margin: 0 !important;
  text-transform: uppercase !important;
  opacity: 0.8 !important;
}

// 隐藏不需要的元素
::v-deep ._1Rce9DUC ._2FUZe5W0,
::v-deep ._1Rce9DUC ._1idiRBeK {
  display: none !important;
}

// 右侧按钮（椭圆形，32种）
::v-deep ._1Rce9DUC ._349CzCYy {
  background: rgba(0, 0, 0, 0.4) !important;
  border-radius: 20px !important;
  padding: 8px 20px !important;
  color: #fff !important;
  font-size: 14px !important;
  white-space: nowrap !important;
  flex-shrink: 0 !important;
  border: none !important;
  cursor: pointer !important;
}

::v-deep ._1Rce9DUC ._349CzCYy span {
  color: #fff !important;
}

// 新的弹出层样式 - 横向拉满
.category-dropdown-popup {
  background: #1b1e2a !important;
  background-color: #1b1e2a !important;
  padding: 0 !important;
  border-radius: 8px !important;
  overflow: hidden !important;
  width: 100% !important;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3) !important;
  // 初始状态：隐藏在上方
  transform: translateY(-20px) !important;
  opacity: 0 !important;
  transition: transform 0.5s ease-out, opacity 0.5s ease-out !important;
  
  // 鼠标悬停不改变背景色
  &:hover {
    background: #1b1e2a !important;
    background-color: #1b1e2a !important;
  }
  
  // 显示动画：从上向下弹出
  &.popup-show {
    transform: translateY(0) !important;
    opacity: 1 !important;
  }
  
  // 隐藏动画：向上收起
  &.popup-hide {
    transform: translateY(-20px) !important;
    opacity: 0 !important;
  }
}

// 弹出层包装器：背景宽度100%
.category-popup-wrapper {
  width: 100% !important;
  background: #1b1e2a !important;
  padding: 15px 0 !important;
}

// 内容容器：最大宽度1200px，居中，支持横向滚动
.category-popup-container {
  display: flex !important;
  flex-direction: row !important;
  align-items: flex-start !important;
  gap: 15px !important;
  max-width: 1200px !important;
  width: 100% !important;
  margin: 0 auto !important;
  padding: 0 20px !important;
  overflow-x: auto !important;
  overflow-y: hidden !important;
  -webkit-overflow-scrolling: touch !important;
  
  // 隐藏滚动条但保持滚动功能
  scrollbar-width: thin !important;
  scrollbar-color: rgba(255, 255, 255, 0.3) transparent !important;
  
  &::-webkit-scrollbar {
    height: 6px !important;
  }
  
  &::-webkit-scrollbar-track {
    background: transparent !important;
  }
  
  &::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.3) !important;
    border-radius: 3px !important;
    
    &:hover {
      background: rgba(255, 255, 255, 0.5) !important;
    }
  }
}

// 单个元素：固定宽度200px，最多显示5个，超出可滚动
.category-popup-content {
  display: flex !important;
  flex-direction: column !important;
  flex: 0 0 200px !important; // 固定宽度200px，不缩放
  width: 200px !important;
  min-width: 200px !important;
  max-width: 200px !important;
  background: #1b1e2a !important;
  border-radius: 8px !important;
  overflow: hidden !important;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3) !important;
}

// 第一行：官方标签、高达X%、无限返水
.category-popup-header {
  display: flex !important;
  align-items: center !important;
  gap: 12px !important;
  padding: 10px 16px !important;
  background: rgba(0, 0, 0, 0.3) !important;
  border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
  
  // 鼠标悬停不改变背景色
  &:hover {
    background: rgba(0, 0, 0, 0.3) !important;
  }
  
  .official-tag {
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    padding: 2px 8px !important;
    background: rgba(255, 255, 255, 0.12) !important;
    border: 1px solid rgba(255, 255, 255, 0.2) !important;
    border-radius: 4px !important;
    font-size: 11px !important;
    color: #fff !important;
    font-weight: 400 !important;
    white-space: nowrap !important;
    
    // 鼠标悬停不改变背景色
    &:hover {
      background: rgba(255, 255, 255, 0.12) !important;
    }
  }
  
  .rebate-text {
    font-size: 13px !important;
    color: #fff !important;
    font-weight: 400 !important;
    white-space: nowrap !important;
  }
  
  .unlimited-rebate {
    font-size: 13px !important;
    color: #fff !important;
    margin-left: auto !important;
    font-weight: 400 !important;
    white-space: nowrap !important;
  }
}

// 第二行：图标和名称
.category-popup-info {
  display: flex !important;
  align-items: flex-start !important;
  gap: 16px !important;
  padding: 18px 16px !important;
  background: transparent !important;
  min-height: 110px !important;
  
  // 鼠标悬停不改变背景色
  &:hover {
    background: transparent !important;
  }
  
  .category-icon-wrapper {
    flex-shrink: 0 !important;
    width: 70px !important;
    height: 70px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    background: transparent !important;
    
    // 鼠标悬停不改变背景色
    &:hover {
      background: transparent !important;
    }
    
    .category-game-icon {
      width: 100% !important;
      height: 100% !important;
      object-fit: contain !important;
      border-radius: 4px !important;
    }
    
    .category-icon-placeholder {
      width: 100% !important;
      height: 100% !important;
      background: rgba(255, 255, 255, 0.1) !important;
      border-radius: 4px !important;
      border: 1px solid rgba(255, 255, 255, 0.2) !important;
    }
  }
  
  .category-name-wrapper {
    flex: 1 !important;
    display: flex !important;
    flex-direction: column !important;
    gap: 6px !important;
    position: relative !important;
    min-height: 70px !important;
    
    .category-name-main {
      font-size: 22px !important;
      font-weight: 700 !important;
      color: #fff !important;
      line-height: 1.3 !important;
      margin: 0 !important;
    }
    
    .category-name-en {
      font-size: 11px !important;
      color: rgba(255, 255, 255, 0.65) !important;
      text-transform: uppercase !important;
      letter-spacing: 0.5px !important;
      margin: 0 !important;
      font-weight: 400 !important;
    }
    
    .category-game-count {
      display: inline-block !important;
      padding: 3px 10px !important;
      background: rgba(0, 0, 0, 0.5) !important;
      border-radius: 10px !important;
      font-size: 11px !important;
      color: #fff !important;
      margin-top: auto !important;
      width: fit-content !important;
      align-self: flex-end !important;
      font-weight: 400 !important;
    }
  }
}

// 第三行：背景图片 - 占据整个卡片宽度
.category-popup-image {
  width: 100% !important;
  height: 130px !important;
  overflow: hidden !important;
  position: relative !important;
  background: transparent !important;
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
  
  // 鼠标悬停不改变背景色
  &:hover {
    background: transparent !important;
  }
  
  .category-app-img {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
    object-position: center !important;
  }
  
  .category-image-placeholder {
    width: 100% !important;
    height: 100% !important;
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.08) 0%, rgba(255, 255, 255, 0.03) 100%) !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    
    &::after {
      content: '暂无图片' !important;
      color: rgba(255, 255, 255, 0.3) !important;
      font-size: 14px !important;
    }
  }
}
</style>
