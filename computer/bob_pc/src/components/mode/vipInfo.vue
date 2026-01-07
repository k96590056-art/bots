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
      <div class="_3LPqql-T">
        <div class="_1T9MY2MW"><img class="NO9x7T89" src="/static/image/my_vip_v-36b4.png?PageSpeed=off" /></div>
        <section>
          <div class="_2E6jtCgT">
            <div class="_1ihMz9IT" style="top: -162px">
              <ul class="EH7HrmCC">
                <span class="_2rSHHo9U"><i style="width: 0%"></i></span>
                <li :class="`vip${index}`" v-for="(item, index) in vipLis" :key="index">
                  <div class="_3a-pKTMT" v-if="index == $store.state.userInfo.vip * 1 - 1"><img class="_3LMLDUFo" src="/static/image/yuan1.png" /><img class="_3B6YH0ov" src="/static/image/yuan1.png" /></div>
                  <img :class="index == $store.state.userInfo.vip * 1 - 1 ? '_3PpgCJLA _3W1_25Yq' : '_3PpgCJLA '" :src="`/static/image/vip${index + 1}.png`" />
                  <p>{{ item.vipname }}</p>
                </li>
              </ul>
            </div>
            <ul class="_3e4HH8iZ">
              <span class="_3VRVyqAh"> <div style="width: 0%"></div> </span
              ><span class="_1lBySHOA">
                <div style="width: 0%"></div>
              </span>

              <li :class="`vip${index}`" v-for="(item, index) in vipLis" :key="index">
                <div class="_3a-pKTMT" v-if="index == $store.state.userInfo.vip * 1 - 1"><img class="_3LMLDUFo" src="/static/image/yuan1.png" /><img class="_3B6YH0ov" src="/static/image/yuan1.png" /></div>
                <img :class="index == $store.state.userInfo.vip * 1 - 1 ? '_3PpgCJLA _3W1_25Yq' : '_3PpgCJLA '" :src="`/static/image/vip${index + 1}.png`" />
                <p>{{ item.vipname }}</p>
              </li>
            </ul>
          </div>

          <div class="_3EUFt5Wv">
            <div class="_29gnuiyG" style="margin: 100px 0px 52px">
              <div class="_35_vygsc">
                <h1 style="margin-top: 0px">晋级条件</h1>
              </div>
              <div class="_2zJiZW9W"></div>
            </div>
            <div class="_3VD5zTpM">
              <div class="_2szQExG9">
                <img
                  class="_1nSvFFDr"
                  src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASgAAAEoCAMAAADc2ZwrAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAMAUExURUxpcevHtvTWyf///+a9que+q+Pj4/PUxerFs+e9q+/YzOW8p+vJt/PVyOPOuPHSwu/Sv+nDsPDQwfTYzPDNxPXczunDsevGtfTXzO7MvPLUwv////fe0/PXyv///+nSv+nAr+rIuPHTw/XXzO3MvPLVyO7NwPbczufBrvXd0OrHt/TSw+/Pv41+fvHPwvDQwuS5punBr/fUxO3KufXRwufArPXd0PHSw/TUx+S5pv/+/fv08enCsejAruO3pOa+q+vHtvXbz/POv+3Lu/TQwfDPwe7MvenCsvTZzfTc0ezJuvDKuvLMu/TOvvXazujBsPTQwPPOvtmehOzHt/HSxPLUx//9/PPWyfbd0OjAruG1oerFtP37++S2of77+ea+rO3Mvdedg/37+ue5pdeehdaagNOXfvHXzPjq4/78+v77+f/8+v35996qkuCwm9aXev78+9GSddajjP///9usl96slfTg192ki/TWzP328/PZz9qgiP////////////fr5eW9qvjk2tumj/ry7/Pe0/Tl3O/UyPDWzO7Rw+rEs+3SxuS6p+O1ov///8J/YcyFZs2GZsyGZs2GZ8F+YO7Ese3Dr9OSdeq9qee4oua2oOOwmem7puSym9eafs+KbNmdguu/q+W0nebAr/DIttaYe+vArOO7qNSUd9CMbuS8qu/GtN6nje7Fs9qfhOC1otKQc+KultWWeeG3pM6JaeGslOW9q+zAreW/rdyvmuK5p9yjifHJt8SDZtibgOi5pOi5o92li+Cqks2HaMaFadioktKbg8OBZN+pkd+ynt+zn9Sgiem8p9mqlNGZgdGOcN+oj9Wiituhh9qrltutmNOehuzCrtimj8uPdPDHtdakjtKPcdCXfseJbcqNcsmMcOnCsdughs6VfMeHa82Uedmcgd2xnevNv9yiiMyRdum6pfjt6NajjP79/MiKbu7Rxdusl/DXzM2SeP35+PLc0ubCs+K1oenKu/Xn4PTj3PPg2O7KuujGt/jq5cyRd+Cwm+S4pD1bHUAAAACNdFJOUwDHxQHHxwLHx6e0x8fGBscLx8fACL6nx43HFE6GxE8Dp6SXwaCSnL7HiaUfxwINx8fH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"
                />
                <div class="_3d_hDAu4">
                  <div class="_15yexfD5">累计流水</div>
                  <div class="_3cIZGfn2" id="n1"><span>￥</span></div>
                </div>
              </div>
              <div class="_2szQExG9">
                <img class="_1nSvFFDr" src="/static/image/vip_promotion_2_icon-4840.png" />
                <div class="_3d_hDAu4">
                  <div class="_15yexfD5">累计充值</div>
                  <div class="_3cIZGfn2" id="n2"><span>￥</span></div>
                </div>
              </div>
            </div>
          </div>
          <div class="_29gnuiyG" style="margin: 94px 0px 13px">
            <div class="_35_vygsc">
              <h1 style="margin-top: 0px">返水比例</h1>
            </div>
            <div class="_2zJiZW9W"></div>
          </div>
          <ul class="_1qdtjegd item1">
            <li class="sWAv_g1H">
              <div>VIP等级</div>
              <div>真人返水</div>
              <div>电子返水</div>
              <div>棋牌返水</div>
              <div>体育返水</div>
              <!-- <div>捕鱼返水</div> -->
              <div>彩票返水</div>
              <div>电竞返水</div>
            </li>
            <li :class="index == $store.state.userInfo.vip * 1 - 1 ? '_3EaYtsps' : ' '" v-for="(item, index) in vipLis" :key="index">
              <img src="/static/image/vip_icon_5_bright-4a8c.png" />
              <div class="-p-khenT">{{ item.vipname }}</div>
              <div>{{ item.realperson }}%</div>
              <div>{{ item.electron }}%</div>
              <div>{{ item.joker }}%</div>
              <div>{{ item.sport }}%</div>
              <!-- <div>{{ item.fish }}%</div> -->
              <div>{{ item.lottery }}%</div>
              <div>{{ item.e_sport }}%</div>
            </li>
          </ul>
          <div class="_36tYfDFP">注：以上为{{$store.state.appInfo.title}}自研场馆（包含博雅棋牌）、OB体育、FB体育、AG真人最高返水比例，具体返水金额请以实际游戏为准，其它疑问请联系7*24在线客服咨询。</div>

          <div class="_29gnuiyG" style="margin: 100px 0px 60px">
            <div class="_35_vygsc">
              <h1 style="margin-top: 0px">条款和规则</h1>
            </div>
            <div class="_2zJiZW9W"></div>
          </div>
          <div class="_6M6n3DaL">
            <div>
              <h1>晋升标准</h1>
              <p>会员的累计有效投注额达到相应级别的要求，即可在次日24点前晋级相应VIP等级。</p>
              <h1>晋升顺序</h1>
              <p>VIP等级达到相应的要求可每天晋升1级，但VIP等级不可越级晋升。</p>
              <h1>保级要求</h1>
              <p class="MsoNormal">会员在达到某VIP等级时刻起计算，每90天内投注需要完成保级要求。如果在此期间完成晋升，保级要求从新按照当前等级计算。</p>
              <h1>降级标准</h1>
              <p>如果会员在一个季度（90天计算）内没有完成相应的保级要求流水，系统会自动降级一个等级，相应的返水及其它优惠也会随之调整至降级后的等级。</p>
              <h1>特别优惠</h1>
              <p class="MsoNormal">
                达到相应等级的VIP会员可点击折换彩金按钮，系统将在5分钟内添加对应彩金至中心钱包内，仅需3倍流水即可出款，每个级别的彩金每位会员仅能获得1次。{{$store.state.appInfo.title}}体育对折换彩金拥有最终解释权。（名贵礼品折换彩金仅针对VIP6/VIP7/VIP8/VIP9/VIP10）会员，请会员在达到对应VIP等级后及时领取，若升级到下一等级VIP后前一等级VIP豪礼折现彩金未领取，则视为放弃该彩金。
              </p>
              <h1>升级礼金</h1>
              <p>升级礼金在会员达到该会员级别后通过VIP详情页面进行自助领取，每个级别的升级礼金每位会员仅能获得1次，请在升至下一VIP等级之前及时领取，逾期未领视为放弃。<em>（升级礼金1倍流水即可提款）</em></p>
              <h1>生日礼金</h1>
              <p>VIP5或以上等级会员可享受生日礼金，若会员生日在注册时间之后的3个月以内（含3个月），则今年将不能领取生日礼金。若会员生日在注册时间之后的三个月以外，则可以在生日当天通过VIP详情页面进行自助领取，每年仅可领取一次。<em>（生日礼金1倍流水即可提款）</em></p>
              <p></p>
              <h1>每周红包</h1>
              <p class="MsoNormal">会员可根据上一周有效流水（周一0点至周日23点59分59秒）与VIP等级（以上周周日其所在的VIP等级为准）在活动页面领取每周红包，领取截止时间为自然周每周五24点，过期作废，不可补发。</p>
              <p class="MsoNormal">彩金仅支持转入{{$store.state.appInfo.title}}体育、OB体育、{{$store.state.appInfo.title}}电竞、{{$store.state.appInfo.title}}真人、{{$store.state.appInfo.title}}棋牌、{{$store.state.appInfo.title}}彩票、{{$store.state.appInfo.title}}电子、{{$store.state.appInfo.title}}捕鱼场馆、博雅棋牌 。仅需满足对应场馆流水要求即可解锁。</p>
              <p>
                周红包领取时间详情：<br />
                VIP1-VIP5 开启时间（自然周每周一）01:00—结束时间（自然周每周五）24:00
              </p>
              <p>VIP6-VIP10开启时间（自然周每周一）13:00—结束时间（自然周每周五）24:00<br /></p>

              <p></p>
              <p></p>
              <!-- <h1>{{$store.state.appInfo.title}}保留对活动的修改，停止及最终解释权。</h1> -->
              <p></p>
              <!-- <h2 class="MsoNormal">每日返水将会在13:30-16:00发放，每日返水总额最低为1元，每日返水总额小数点后将不进行计算，场馆锁定期间流水不参与返水。</h2> -->
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: 'vipInfo',
  data() {
    return { vipLis: [], show: false };
  },
  created() {
    let that = this;

    that.uservip();
  },
  methods: {
    uservip() {
      let that = this;
      that.show = true;
      that.$apiFun.post('/api/uservip', {}).then(res => {
        if (res.code != 200) {
          that.showTost(res.message);
        }
        if (res.code == 200) {
          that.vipLis = res.data;
          let num = that.$store.state.userInfo.vip * 1;
          console.log(num);
          $('#n1').html(`<span>￥</span>${that.vipLis[num - 1].flow}`);
          $('#n2').html(`<span>￥</span>${that.vipLis[num - 1].recharge}`);
        }
        that.show = false;
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
  mounted() {},
  updated() {
    let that = this;
    $('._3e4HH8iZ li').click(function () {
      var index = $(this).index();
      $('._3e4HH8iZ li').find('._3PpgCJLA').removeClass('_3W1_25Yq');
      $('._3e4HH8iZ li ._3a-pKTMT').remove();
      $(this).find('._3PpgCJLA').addClass('_3W1_25Yq');
      $(this).prepend("<div class='_3a-pKTMT'><img class='_3LMLDUFo' src='/static/image/yuan1.png'><img class='_3B6YH0ov' src='/static/image/yuan1.png'></div>");
      $('.item1 li').eq(index-1).addClass('_3EaYtsps').siblings().removeClass('_3EaYtsps');
      $('.item2 li').eq(index).addClass('_3EaYtsps').siblings().removeClass('_3EaYtsps');

      $('.EH7HrmCC li').find('._3PpgCJLA').removeClass('_3W1_25Yq');
      $('.EH7HrmCC li')
        .eq(index - 2)
        .find('._3PpgCJLA')
        .addClass('_3W1_25Yq');
      $('.EH7HrmCC li').find('._3a-pKTMT').remove();
      $('.EH7HrmCC li')
        .eq(index - 2)
        .prepend("<div class='_3a-pKTMT'><img class='_3LMLDUFo' src='/static/image/yuan1.png'><img class='_3B6YH0ov' src='/static/image/yuan1.png'></div>");
    });

    $('.EH7HrmCC li').click(function () {
      var index = $(this).index();
      $('.EH7HrmCC li').find('._3PpgCJLA').removeClass('_3W1_25Yq');
      $('.EH7HrmCC li ._3a-pKTMT').remove();
      $(this).find('._3PpgCJLA').addClass('_3W1_25Yq');
      $(this).prepend("<div class='_3a-pKTMT'><img class='_3LMLDUFo' src='/static/image/yuan1.png'><img class='_3B6YH0ov' src='/static/image/yuan1.png'></div>");
      $('.item1 li').eq(index).addClass('_3EaYtsps').siblings().removeClass('_3EaYtsps');
      $('.item2 li').eq(index).addClass('_3EaYtsps').siblings().removeClass('_3EaYtsps');

      $('._3e4HH8iZ li').find('._3PpgCJLA').removeClass('_3W1_25Yq');
      $('._3e4HH8iZ li')
        .eq(index - 2)
        .find('._3PpgCJLA')
        .addClass('_3W1_25Yq');
      $('._3e4HH8iZ li').find('._3a-pKTMT').remove();
      $('._3e4HH8iZ li')
        .eq(index - 2)
        .prepend("<div class='_3a-pKTMT'><img class='_3LMLDUFo' src='/static/image/yuan1.png'><img class='_3B6YH0ov' src='/static/image/yuan1.png'></div>");
    });

    //vip1参数
    $('.vip1').click(function () {
      $('#n2').html(`<span>￥</span>${that.vipLis[0].recharge}`);
      $('#n1').html(`<span>￥</span>${that.vipLis[0].flow}`);
      $('#n3').html("<div class='ELKEJniT' style='color: rgb(77, 77, 128);'><span>¥</span>8</div>");
      $('#n4').html("<div class='ELKEJniT' style='color: rgb(98, 69, 128);'><span>¥</span>8</div>");
      $('#n5').html("<div class='_2_3Gl8dL' style='color: rgb(102, 41, 53);'>无</div>");
      $('#n6').html("<div class='_2_3Gl8dL' style='color: rgb(102, 66, 35);'>无</div>");
    });
    //vip2参数
    $('.vip2').click(function () {
      $('#n2').html(`<span>￥</span>${that.vipLis[1].recharge}`);
      $('#n1').html(`<span>￥</span>${that.vipLis[1].flow}`);
      $('#n3').html("<div class='ELKEJniT' style='color: rgb(77, 77, 128);'><span>¥</span>18</div>");
      $('#n4').html("<div class='ELKEJniT' style='color: rgb(98, 69, 128);'><span>¥</span>18</div>");
      $('#n5').html("<div class='_2_3Gl8dL' style='color: rgb(102, 41, 53);'>无</div>");
      $('#n6').html("<div class='_2_3Gl8dL' style='color: rgb(102, 66, 35);'>无</div>");
    });
    //vip3参数
    $('.vip3').click(function () {
      $('#n2').html(`<span>￥</span>${that.vipLis[2].recharge}`);
      $('#n1').html(`<span>￥</span>${that.vipLis[2].flow}`);
      $('#n3').html("<div class='ELKEJniT' style='color: rgb(77, 77, 128);'><span>¥</span>38</div>");
      $('#n4').html("<div class='ELKEJniT' style='color: rgb(98, 69, 128);'><span>¥</span>38</div>");
      $('#n5').html("<div class='_2_3Gl8dL' style='color: rgb(102, 41, 53);'>无</div>");
      $('#n6').html("<div class='_2_3Gl8dL' style='color: rgb(102, 66, 35);'>无</div>");
    });
    //vip4参数
    $('.vip4').click(function () {
      $('#n2').html(`<span>￥</span>${that.vipLis[3].recharge}`);
      $('#n1').html(`<span>￥</span>${that.vipLis[3].flow}`);
      $('#n3').html("<div class='ELKEJniT' style='color: rgb(77, 77, 128);'><span>¥</span>88</div>");
      $('#n4').html("<div class='ELKEJniT' style='color: rgb(98, 69, 128);'><span>¥</span>88</div>");
      $('#n5').html("<div class='_2_3Gl8dL' style='color: rgb(102, 41, 53);'>无</div>");
      $('#n6').html("<div class='_2_3Gl8dL' style='color: rgb(102, 66, 35);'>无</div>");
    });
    //vip5参数
    $('.vip5').click(function () {
      $('#n2').html(`<span>￥</span>${that.vipLis[4].recharge}`);
      $('#n1').html(`<span>￥</span>${that.vipLis[4].flow}`);
      $('#n3').html("<div class='ELKEJniT' style='color: rgb(77, 77, 128);'><span>¥</span>388</div>");
      $('#n4').html("<div class='ELKEJniT' style='color: rgb(98, 69, 128);'><span>¥</span>188</div>");
      $('#n5').html("<div class='ELKEJniT' style='color: rgb(102, 41, 53);'><span>¥</span>388</div>");
      $('#n6').html("<div class='_2_3Gl8dL' style='color: rgb(102, 66, 35);'>无</div>");
    });
    //vip6参数
    $('.vip6').click(function () {
      $('#n2').html(`<span>￥</span>${that.vipLis[5].recharge}`);
      $('#n1').html(`<span>￥</span>${that.vipLis[5].flow}`);
      $('#n3').html("<div class='ELKEJniT' style='color: rgb(77, 77, 128);'><span>¥</span>688</div>");
      $('#n4').html("<div class='ELKEJniT' style='color: rgb(98, 69, 128);'><span>¥</span>388</div>");
      $('#n5').html("<div class='ELKEJniT' style='color: rgb(102, 41, 53);'><span>¥</span>688</div>");
      $('#n6').html("<div class='_2W_CrD6j' style='color: rgb(102, 66, 35);'>飞利浦剃须刀+圣罗兰唇部精华霜 兑换￥(588.00) 流水倍数3倍</div>");
    });
    //vip7参数
    $('.vip7').click(function () {
      $('#n2').html(`<span>￥</span>${that.vipLis[6].recharge}`);
      $('#n1').html(`<span>￥</span>${that.vipLis[6].flow}`);
      $('#n3').html("<div class='ELKEJniT' style='color: rgb(77, 77, 128);'><span>¥</span>1088</div>");
      $('#n4').html("<div class='ELKEJniT' style='color: rgb(98, 69, 128);'><span>¥</span>688</div>");
      $('#n5').html("<div class='ELKEJniT' style='color: rgb(102, 41, 53);'><span>¥</span>1088</div>");
      $('#n6').html("<div class='_2W_CrD6j' style='color: rgb(102, 66, 35);'>阿玛尼香水+雅诗兰黛精华30ml 兑换￥(1288.00) 流水倍数3倍</div>");
    });
    //vip8参数
    $('.vip8').click(function () {
      $('#n2').html(`<span>￥</span>${that.vipLis[7].recharge}`);
      $('#n1').html(`<span>￥</span>${that.vipLis[7].flow}`);
      $('#n3').html("<div class='ELKEJniT' style='color: rgb(77, 77, 128);'><span>¥</span>3888</div>");
      $('#n4').html("<div class='ELKEJniT' style='color: rgb(98, 69, 128);'><span>¥</span>1088</div>");
      $('#n5').html("<div class='ELKEJniT' style='color: rgb(102, 41, 53);'><span>¥</span>3888</div>");
      $('#n6').html("<div class='_2W_CrD6j' style='color: rgb(102, 66, 35);'>周生生黄金+Whoo后津率享套装+TF哑光黑管 兑换￥(3288.00) 流水倍数3倍</div>");
    });
    //vip9参数
    $('.vip9').click(function () {
      $('#n2').html(`<span>￥</span>${that.vipLis[8].recharge}`);
      $('#n1').html(`<span>￥</span>${that.vipLis[8].flow}`);
      $('#n3').html("<div class='ELKEJniT' style='color: rgb(77, 77, 128);'><span>¥</span>5888</div>");
      $('#n4').html("<div class='ELKEJniT' style='color: rgb(98, 69, 128);'><span>¥</span>1888</div>");
      $('#n5').html("<div class='ELKEJniT' style='color: rgb(102, 41, 53);'><span>¥</span>5888</div>");
      $('#n6').html("<div class='_2W_CrD6j' style='color: rgb(102, 66, 35);'>Gucci1955系列卡包+Gucci提花针织围巾+卡地亚LOVE戒指 兑换￥(20888.00) 流水倍数3倍</div>");
    });
    //vip10参数
    $('.vip10').click(function () {
      $('#n2').html(`<span>￥</span>${that.vipLis[9].recharge}`);
      $('#n1').html(`<span>￥</span>${that.vipLis[9].flow}`);
      $('#n3').html("<div class='ELKEJniT' style='color: rgb(77, 77, 128);'><span>¥</span>18888</div>");
      $('#n4').html("<div class='ELKEJniT' style='color: rgb(98, 69, 128);'><span>¥</span>5888</div>");
      $('#n5').html("<div class='ELKEJniT' style='color: rgb(102, 41, 53);'><span>¥</span>18888</div>");
      $('#n6').html("<div class='_2W_CrD6j' style='color: rgb(102, 66, 35);'>苹果电脑16GB+欧米茄星座系列28毫米石英腕表+CHANEL口盖卡包 兑换￥(56888.00) 流水倍数3倍</div>");
    });

    // 悬浮显示与隐藏
    $(window).on('load scroll', function () {
      var top = $(document).scrollTop();
      if (top > 600) {
        $('._1ihMz9IT').css('top', '0');
      } else {
        $('._1ihMz9IT').css('top', '-162px');
      }
    });
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
._1qdtjegd {
  justify-content: space-between;
}
._1qdtjegd li div {
  width: 109px;
}
</style>
