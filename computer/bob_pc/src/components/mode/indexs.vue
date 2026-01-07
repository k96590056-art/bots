<template>
  <div class="_24vddGqv">
       <!-- 网站弹窗 -->
      <div data-v-d47f0a72="" class="_1euN-aP1" v-if="tanshow && $store.state.appInfo.index_modal == 1">
        <div data-v-d47f0a72="" class="_2v39xVwk animated animated-3 fadeIn"></div>
        <div data-v-d47f0a72="" class="_3Pc_iCss animated animated-3 zoomIn" style="width: 700px">
          <div data-v-d47f0a72="" class="_3DZ99c6r">
            <span data-v-d47f0a72=""></span>
            <div data-v-d47f0a72="" class="_3x7x8GsG">欢迎来到{{ $store.state.appInfo.title }}</div>
            <img
              @click="changtanshow"
              data-v-d47f0a72=""
              src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAMAAACdt4HsAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAC0UExURUxpcf/////Uqv+2tv//qv///+u3o/////W8qv/Gxv/9/emwoOWunO+zouiyovC0peexneeyn+qxouWvnOWvneWwnOWunOWvnee5ouWxneaxoeSunOSunOWxpOSvneSvnPC4m+SvneWwn+SwnfXf1+avnPTe1fvw7eSunOewnuSum+mynuSunPXg2vLVzeSum//9/eSunOSunPPa0uStnfbm3/HWzfjr5vnh1vzz8f359////2ASjEAAAAA7dFJOUwD9BgcDAg0BCQT9G0cPFREkHxg6Pi5RYAsoNkxaE1VkEkIdMJAzlWpoK4AidYm6jPSWbZ9xf651HmONntaUtAAABAdJREFUeNrtlsly4kgQhgdJCMlaKe37ZmFAYDDgrXn/95qsqqRlRxSaufSlw3khQsn/qZSV2z8/9mN/ny3QJn0TNp/PFTD4wT9+UY+++6+fK7ougem6rgDim1xBH7iUxR29okuypsVxrGmyRBFf9Lp+c2ngEhPmuqTFquXUzoetavJIWABaRpdlf1CXUK/ommoVNjF+XY+flqoxAupBXoPHIJ/H6y84w1wUAF2OrYK0Q3q9XmeftapJQEC96thGO7ju0wycH5oODgFAUwuydDfpkRKeCk5YsJPVpHWTIHin+iMBhwCgSJplt27Qe6+zLwTUD0mXouPTiWUxIHbIsOm9xtyPBLg70BvsOYKNQpV1MaA23MBrsjBEgm1pYGoB+tRH7HvS3gc4FGCGZZ4/IsFRVQv0Qdpk+wf66LVnAEUcRIsMFJDn0Y1AbBvCR/WPTL/3O9eoVekOQLWXG/hvHkVVhIRhCeHzUP+wN71gIJbwFiARZfhat/PNMq+qG+E96ODzQ65/zJo0aW1VmAcQBPoN7AhlVK2raMUIr36T3fQhOwC9RSGAHqE2eBSAsK5W/LPDcsX0q9CkEYDLFVYTpix8BCeswVCIP6Xp9/ABFqa46AhI6CihWp8ulzOToj4D/ZLqMQJCgnQjlNH6sttt32gcvutlpp8i2G3S+1leXXbbw4ETHs552KSbJZnWI8Gi2WCG0QX0L88zPADPgBj1kwSoKciGMDptUc+uEDIALkCgFyYk3GWWA4DpZzwfepen4P8CLDngjUmfOeYdAGMGTAeBDJ2fRSfUvxzeHhjBqAUhECZTm6RNGJ1R/3LYnhnhSZRE4mSEA0D+4vsP2+3uRsBOO6nHcuD6ty213YVl9dhp/0ufNlh/5x2zy+lUrWZTBAwg77+0oFFfVdBboDBP6/Wtw/BiBIJ4sjhf9au8DMFKXtwjAfuJqKFgHaC+DM3G9xszo4iRgB1N1NJ4Xzf3qM8aL+263vNpfxi73CceQZyCkAHlEfV+GiSu6256JET5HkcbACbaeoT9z+83g0GIsYS2TAlRlPOJ8xFLyuRgeb4emT5ZksKyahiYQIBA5HlovsJ4x8EyMdqiMuN6R4W1xLIhNdnEC+Fxmk6NNsKGIFjjdbR/QfHoMu+0/LnvBe794UrHAp3ivu+lgduy/ge7Fe+Tmx6e+ynEhdT3ZiObw0nQ9V2QDAb2T94n0dEHGwYWz0a+yCzdJHGHlhSox05Ldx/01CyZxUsaEIjRtgaBuY79H9C4fhHDoB7QA1lUTAqNl+UURVFbaoz63wRw1dxFI7O4t2jCralg2rgmIuGba2JVhV2VmqSjflxV0QeuqcY6ZysxW6m/l/yCIm6+xfS6jyZyoefH/oD9C6i3ptIfvSpmAAAAAElFTkSuQmCC"
              alt=""
              class="_8iC2lrZe"
            />
          </div>
          <div data-v-d47f0a72="" class="n8VMb-cz" style="text-align:left" v-html="$store.state.appInfo.webcontent">

          </div>
        </div>
      </div>
    <div id="redPacket" v-if="1 == 2 && $store.state.appInfo.redpacket_switch == 1 && hongbashow">
      <i class="grab" @click="goNav('/userredpacket')"></i>
      <img @click="changhongbashow" src="/static/image/hongbaocolse.png" />
    </div>
    <div class="_1PthxidG">
      <div class="_2gKtEzzo" style="height: 580px; position: relative; overflow: hidden; width: 100%">
        <div class="ant-carousel">
          <div class="slick-slider">
            <div class="swiper-wrapper">
              <div class="swiper-slide" v-for="(item, index) in bannerList" :key="index">
                <div>
                  <div class="_22T49mH0"><img class="boKYdSn5" :src="item.src" />_3SRAbm08</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="_1rdiSS19">
          <div class="swiper-wrapper">
            <div class="_1TurqGH- swiper-slide" v-for="(item, index) in bannerList" :key="index">
              <img :src="item.src" />
              <div></div>
            </div>
          </div>
        </div>
        <div class="WBPgrnx-"></div>
        <div class="_3NjvkxEd"></div>
      </div>
      <!-- 公告滚动 -->
      <section class="-Op22lpt">
        <div class="hXRfTFkY">
          <div class="_2HJrs1EE">
            <section class="_21C8lCqy">
              <div class="_14siVnpy" style="width: 1064px">
                <div class="rxKMqsdd _3G3po4ib">
                  <div class="_20-URCGF">
                    <div class="_16eN5goK" @click="changGshow">
                      <a class="_3XlVLgzC" v-for="(item, index) in homenoticelis" :key="index">{{ item }}</a>
                    </div>
                  </div>
                </div>
              </div>
            </section>
            <a target="_self" class="_3bn9cEp8" href="javascript:;">
              <div class="_349CzCYy xJQe3jRu" @click="openKefu">
                <img
                  class="_2JoosS9F"
                  src="https://pbs3img.ggh0807.com/images/new_public/web/bg/fd/cs/d0rhau1dl7hqrafj5e3g_122627.png"
                  alt=""
                /><span>在线客服</span>
              </div>
            </a>
            <!-- <div class="_349CzCYy xJQe3jRu" style="margin-left: 8px">
              <img
                class="_2JoosS9F"
                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADwAAAA0CAMAAADhcastAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAEmUExURUxpcZuqyZ+tzLPC4GZ2mKKqxHqKrZ2ryqGxzaO106682JWmvYCQsoCSs3yMr3WEpJakxIuZuYCPsnyJrI6cvG+Ao5+sy3uKqoCPsm9/oG9/onKAoltqjVxsj11vkWBvkp6syq662aWy0aKwzai21Km21K++26262KWy0ZOgv5OiwXiHqGFxk3OCpXyMrWNzlWFwjlxsjq+926+82mx8n4OSsoCOr2h4m46dvHSEp3CAo5KhwHyLrHeHqniHqGZ1l4uZuXGAoWJylGR0l5akw3WEpYeVtWBwk15ukVtrjWBwkpmnxn+Psl1tj4eWtmp5m1xsj218nnuLrpqox2l5mnyMr1pqjYCQs3yMrmV0l5Wkw4uauZ2syqKwzqe103SDpKy52Gp5nHYdBisAAAA0dFJOUwDO6xyVBvXBKQkiD58hVJbh+tUlzNlgxP3IoWiz+Ejel1PluePCweC+jIzr9DOBhSKB1dSlKBtRAAABtklEQVR42u3LaVOCUBSAYTRR1LTUVrWysn0v2xctRNJyAcEsBf3/v6Ljna5cbI7wqS/5zJnh3MO83MS/NXWxPTVy2T6Hiyvr/f5OiD2Edvr9dZcxv2Wa2RDTZk1zK8i5FNw1zA2BvoQNw9yF1nW9aRhe4af1Gsamq5ZfyAQGPN1u1xsgvLB6yJZZ4Me1gqf51oR5I+hu3TwC3oZniwNfxS+YIrtTs2E03rt3tI/GczeO5tA41ukUOgUWPO23GBrXSqVaqQYz/FLWHY0vXUDjKxfQ+MHmOBJdfPgFjZ9YixxIHTyNQGNJknpSD0YCM+QUnpFsemj8zIKYOFq2ndFYYfnolV9mz2is1QmtrsGQmEhp9AZfNM6zrNjHntH4hUVj/sR2RuNX1k+8uvZqg8atMtEqt2DSHDhNk7081ELjRnWoUV1Z5YJnKw0AD5gGUUXjikxU5AqMLK8d0t36ymgs5vNiXrT5FD9hrK+IxtcuoHFOIXJK7heF/kPj+TtH82icvHWUROOE/9GBP8Ghon5VV9W22oZRYdX1tt6G0WEdvP1RbozIdHzp/eP9g4CFtRSfjnATE3/oG/359bUynhFyAAAAAElFTkSuQmCC"
                alt=""
              /><span>赛事直播</span>
            </div> -->
          </div>
        </div>
      </section>
      <div class="_2RTjvPAW">
        <div class="_3SRAbm08" @click="goNav('/zhanzhu01')">
          <div class="wrOFiuzZ">全球赞助合作伙伴</div>
          <div class="_3uDxgkBc">
            <img
              class="ls-is-cached lazyloaded"
              src="https://p3static.qwevo7g2g.com/images/new_public/web/bg/fd/cs/d48nmig6h9rghgf68fn0_660694.png"
              data-src="https://p3static.qwevo7g2g.com/images/new_public/web/bg/fd/cs/d48nmig6h9rghgf68fn0_660694.png"
            />
            <p>佛罗伦萨</p>
            <p>Fiorentina</p>
            <div class="_349CzCYy xJQe3jRu bHWUakGy" style="border-radius: 25vh">
              <span>查看详情</span>
            </div>
          </div>
          <img class="_3pM3qxGX ls-is-cached lazyloaded" src="https://p3static.qwevo7g2g.com/images/new_public/web/bg/fd/cs/d48nmig6h9rghgf68fn0_660694.png" />
        </div>
        <div class="_3SRAbm08" @click="goNav('/zhanzhu02')">
          <div class="wrOFiuzZ">亚洲区官方合作伙伴</div>
          <div class="_3uDxgkBc">
            <img
              class="ls-is-cached lazyloaded"
              src="https://p3static.qwevo7g2g.com/images/new_public/web/bg/fd/cs/d48nmm0i2sccru47etr0_693832.png"
              data-src="https://p3static.qwevo7g2g.com/images/new_public/web/bg/fd/cs/d48nmm0i2sccru47etr0_693832.png"
            />
            <p>赫塔菲</p>
            <p>Getafe</p>
            <div class="_349CzCYy xJQe3jRu bHWUakGy" style="border-radius: 25vh">
              <span>查看详情</span>
            </div>
          </div>
          <img class="_3pM3qxGX ls-is-cached lazyloaded" src="https://p3static.qwevo7g2g.com/images/new_public/web/bg/fd/cs/d48nmm0i2sccru47etr0_693832.png" />
        </div>
      </div>
      <div v-if="1==2" class="_2RTjvPAW_hidden_backup">
        <div class="_3SRAbm08" @click="goNav('/zhanzhu01')">
          <div class="wrOFiuzZ">全球赞助合作伙伴</div>
          <div class="_3uDxgkBc">
            <img
              class="ls-is-cached lazyloaded"
              src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEgAAABICAMAAABiM0N1AAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAMAUExURUxpcdKpnP/Mmdm2n9ewnNGonc+qm//Q0P///9aurt+/n/+/v9iwntevn8+pm8+nms+pmtStns+nmtGqnM6nmtCsndGqnNCqm8+om9ConNSqqs+nms6nms6nmc6nms6nms6pm+KqqtCnms+oms6nms6nms6nms+om86nms6nms+nms6om+jY0tq9tNu+tNKtod3DuufVz+DOxt7Hvt/Hv86nmg+ZRMjAt+fb1uTOx9Ouo9W0qeLMxMnFvLm5raW6rtfHv9Syp46ej091YNXDui6hXMvBt9e2rKWtoCSMTdComs2mm9u+tOTl4NW0qu3u7N/W0ERrVIaYifT29GeafJuom3qSgTSNVlWMbMLHvdjSy6KvojmbYGilg7e4rUOIYL7KwLTNv664rVd4Y5Shk5qmmLnLwN/t5P///+cbGvD69D6ybRimVa0SGesaGekbGuIaGdwaGsoWGdgYGegWFaoKEb4WGQOWPM4YGv319P/+/gOhRsQWGfrLyucSEdMYGfzx8LkUGQGaQLkrL/b7+P35+R6rW/vs67MTGHvInOv38Pzn5tARExerV/3i4eksK7YVGuIVFfSpqA+mUNwWFvXa2vnEw7AVG/Xi4vLR0nDIlelDQjqEWX2aid+en9B1eOtLSpSyodooKdQMDuc2Ncbp1QqOPWeLdtExMrILEfPFxOB1de91dOIKCYfRpuT16yauYdmDhfvV1O5jYfi3tq8MErw3PP/7+ue3uOuPjvWenPa9vM0kJd0+PtyQkvSzsoynmK3gw0y7ezKzaRaKQ3GSf75DR9xdXcRPU+okI9VDRPKKichWWb0NEunBwojHo1K+gNvx5NHt3Vp9aWCCbuSpqfJ+fONpaccLDtlRUdk1NddsbdYkJO/LzOycm/vc29sODslcX7QcIfGUk8dAQqjMuEupcnaykJjJrS95UES5dYagkUVzWOtXVb4eIumurso0NuIdHfBratFSVMQhI7zlzpfXsjq2b6Pbu0B9W2LBicppbV2wgFR5ZMllac5maHKWmRMAAADVdFJOUwAZBQoNFiQCAQYIBA8TNiw9EVEhYBseKDkwDE1VdX6GMwkmQVtmbHBKaUWZ1qubibfOy6m+j/3Y2r90n7Dh5f7Hk/L+uv3MrOv9R0iQ5IHu2/7z8/7w+P7+69Px+f7d/vX97fjw7fz2//////////////////////////////////////7//////////////////////////////////////////////////////////////////////////////////////////////////////////qDNjfMAAAscSURBVHjalZhnXFP3GscvhICBhABhBggjTAvIENSruEXt1GrVLrvv58TbSDZJCEkAIVAQwl6yhLJRloAI4lZc1bZu3Fbrnt3z+Z9DOCDXW/i9kBcevj7P7xnn8fxrSJMmTTIzM7OwMDY2po1DxiALMxD8HgEY5gDFmGbuQaGw2WyTfxKbTaFQPMxpAAPUaA5gKGw63ZpBHZ8Y1nQ6xYNmPJoEHJoHm86gGtnbs0zHIRbL3t6IyqBTzGkWZpNGc0ysqfYsB6aTu7vlP8vdicn0ZNlRrU08aBATCTL2MGEYYRMWy8jaxNx4BMiCxrY2MlX+d2LaomQCiUIjQRAQncpibkiI/XwCiv11gyXTnkr3sDAbzozGZtg7WK5ISN66btzauvHXFVx3BzsIiQSZ06mmTtwVsckbsHFrQ3LxChsrJotqQoIsPKztHBz93siZCGhdcuobXi9behrRzS0MIGMKw55pZfNGCwFq69B27cjvwrCkPG2XIiPuMqZoaLichiElEX9qCZA3hGRvTbEY9ppNZTlN9nptT/I6eCru0bES7aljjU0dbUd7D5+vO3zufvXhg7yBOPi7wnLEabgfB6CNqa/5unCdWAyKsQFEM6GaWvrZvlZMgIr+Ontdl3KmTz2QmZuePri9qbk5M3Pgelxbv/JCJ4blnRFkKjDsCwC5ek12Z1HZtGEQ3cjT0dl/eupGACH9Vtd6rKOsSqDR61Wi9NzBxsaSuI5q+cOH2w6ltQ6q1fcxHDSdY+tnaQpujwA5ONr4Lkvd+AU8kX+952k9vzcj6VC8TCZTaeSibgxLyz5zo7vh2rZHdVd4PPVpeGxrzlfL3LydHcFtAwiqb+dgZeP7TmrOVgzL6JXGx/P5fV2Y9mpKikgglj04czq7p0Gr3PEgXibKigZQDwF6x83f2dHheZDLv0O/QqC4Cw+LLiZK+5TYznqRYD1Pry+oT2/OVCi3Q3xiwACo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"
              data-src="404.png,404.png"
            />
            <p>威尔士国家足球队</p>
            <p>Wales National</p>
            <div class="_349CzCYy xJQe3jRu bHWUakGy" style="border-radius: 25vh">
              <span>查看详情</span>
            </div>
          </div>
          <img class="_3pM3qxGX ls-is-cached lazyloaded" src="/static/image/home_people_walesnati-5849.png" data-src="/static/image/home_people_walesnati-5849.png" />
        </div>
        <div class="_3SRAbm08" @click="goNav('/zhanzhu02')">
          <div class="wrOFiuzZ">亚洲区官方合作伙伴</div>
          <div class="_3uDxgkBc">
            <img
              class="ls-is-cached lazyloaded"
              src="data:image/png;base64,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"
              data-src="404.png,404.png"
            />
            <p>那不勒斯俱乐部</p>
            <p>SSC Napoli</p>
            <div class="_349CzCYy xJQe3jRu bHWUakGy" style="border-radius: 25vh">
              <span>查看详情</span>
            </div>
          </div>
          <img class="_3pM3qxGX ls-is-cached lazyloaded" src="/static/image/home_people_sscnapoli-f7f3.png" data-src="/static/image/home_people_sscnapoli-f7f3.png" />
        </div>
        <div class="_3SRAbm08" @click="goNav('/zhanzhu03')">
          <div class="wrOFiuzZ">亚洲区官方合作伙伴</div>
          <div class="_3uDxgkBc">
            <img
              class="ls-is-cached lazyloaded"
              src="data:image/png;base64,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"
              data-src="404.png,404.png"
            />
            <p>多特蒙德俱乐部</p>
            <p>Borussia Dortmund</p>
            <div class="_349CzCYy xJQe3jRu bHWUakGy" style="border-radius: 25vh">
              <span>查看详情</span>
            </div>
          </div>
          <img class="_3pM3qxGX ls-is-cached lazyloaded" src="/static/image/home_people_borussia-22fb.png" data-src="/static/image/home_people_borussia-22fb.png" />
        </div>
        <div class="_3SRAbm08" @click="goNav('/zhanzhu04')">
          <div class="wrOFiuzZ">{{ $store.state.appInfo.title }}体育形象代言人</div>
          <div class="_3uDxgkBc">
            <img
              class="ls-is-cached lazyloaded"
              src="data:image/png;base64,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"
              data-src="404.png,404.png"
            />
            <p>菲利波·因扎吉</p>
            <p>Filippo Inzaghi</p>
            <div class="_349CzCYy xJQe3jRu bHWUakGy" style="border-radius: 25vh">
              <span>查看详情</span>
            </div>
          </div>
          <img class="_3pM3qxGX ls-is-cached lazyloaded" src="/static/image/home_people_filippo-82d8.png" data-src="/static/image/home_people_filippo-82d8.png" />
        </div>
        <div class="_3SRAbm08" @click="goNav('/zhanzhu05')">
          <div class="wrOFiuzZ">亚洲区官方合作伙伴</div>
          <div class="_3uDxgkBc">
            <img
              class="ls-is-cached lazyloaded"
              src="03.png"
              data-src="404.png,404.png"
            />
            <p>法甲里昂俱乐部</p>
            <p>Olympique Lyonnais</p>
            <div class="_349CzCYy xJQe3jRu bHWUakGy" style="border-radius: 25vh">
              <span>查看详情</span>
            </div>
          </div>
          <img class="_3pM3qxGX ls-is-cached lazyloaded" src="/static/image/home_people_olympique-1ca9.png" data-src="/static/image/home_people_olympique-1ca9.png" />
        </div>
      </div>
      <div class="skeleton-placeholder" style="min-height: 600px; margin-top: 109px">
        <div id="clientPage">
          <div class="_29gnuiyG">
            <div class="_35_vygsc">
              <h1 style="margin-top: -23px">APP下载</h1>
              <h2>APP DOWNLOAD</h2>
            </div>
            <!-- <div class="_2zJiZW9W">
              <div class="_349CzCYy xJQe3jRu _12ZkQT2g _3gi7jqcw"><img class="_2JoosS9F _1kN15kEe" src="/static/image/2.png" alt="" /><img class="_2JoosS9F _1kN15kEe hover" src="/static/image/2-hover.png" alt="" /><span>体育APP</span></div>
              <div class="_349CzCYy xJQe3jRu _3gi7jqcw"><img class="_2JoosS9F _1kN15kEe" src="/static/image/1.png" alt="" /><img class="_2JoosS9F _1kN15kEe hover" src="/static/image/1-hover.png" alt="" /><span>综合APP</span></div>
              <div class="_349CzCYy xJQe3jRu _3gi7jqcw"><img class="_2JoosS9F _1kN15kEe" src="/static/image/7.png" alt="" /><img class="_2JoosS9F _1kN15kEe hover" src="/static/image/7-hover.png" alt="" /><span>登录器</span></div>
            </div> -->
          </div>
          <div class="clientPage _1LFTn_TC">
            <div class="_2EhulCr4">
              <div class="_3vHAeaEW">
                <div class="_3rjYMFmr other">
                  <img style="width: auto; margin-left: 20px;" src="https://xb0033.xyz/uploads/2025-07-22/88c1076818df909e095609036c96bf35.png" :alt="$store.state.appInfo.title" />
                </div>
                <div class="_2UHEyMU-">原生体育APP，便捷登录、操作简单、界面一目了然、游戏畅通无阻、酷炫玩法全覆盖，指尖体育APP精彩无处不在。</div>
                <div class="_1_C6-P0l">
                  <div>
                    <div class="DbVlY68a">
                      <img src="/static/image/04.png" style="height: 130px; width: 130px" alt="" />
                    </div>
                    <p class="_2pBcwUBP">扫码进入下载页面</p>
                    <a :href="$store.state.appInfo.ios_download_url" target="_blank"
                      ><span>{{ $store.state.appInfo.ios_download_url }}</span></a
                    >
                  </div>
                  <div>
                    <div class="DbVlY68a">
                      <img alt="" src="/static/image/04.png"
                        style="width: 132px"
                      />
                    </div>
                    <p class="_2pBcwUBP">手机免下载访问</p>
                    <a :href="$store.state.appInfo.h5_url" target="_blank"
                      ><span>{{ $store.state.appInfo.h5_url }}</span></a
                    >
                    <!-- <a href="javascript:;" target="_self"><span>www.fhtcmn.com:8899</span></a>  -->
                  </div>
                </div>
              </div>
            </div>
            <div class="_21tMkZGL">
              <div class="_2G3nuwKJ">
                <div class="uImxsxpQ" style="width: 100%;">
                  <img class="Jt15YIRj ls-is-cached lazyloaded" src="/static/image/03.png" data-src="/static/image/03.png" />
                </div>
                <div class="_2UXn9vKG" style="z-index: 9; bottom: 0; top: none;">
                  <img class="Jt15YIRj ls-is-cached lazyloaded" src="/static/image/04.png" data-src="/static/image/04.png" />
                </div>
              </div>
              <div class="nw0pbZif"></div>
              <div class="_2v3kEE8g"></div>
              <div class="fD4kRERv"></div>
              <div class="_1gIVvkxa _2ta8XOUu" style=""></div>
            </div>
          </div>
          <div class="clientPage _1LFTn_TC" style="display: none">
            <div class="_2EhulCr4">
              <div class="_3vHAeaEW" style="padding: 0 20px;">
                <div class="_3rjYMFmr">
                  <img style="width: auto; margin-left: 20px;" src="https://xb0033.xyz/uploads/2025-07-22/88c1076818df909e095609036c96bf35.png" :alt="$store.state.appInfo.title"/>
                </div>
                <div class="_2UHEyMU-">综合手机客户端，便捷的登录方式，丰富的游戏品类，应有尽有的炫酷玩法，24小时多平台无缝应用体验。带您开启掌上精彩！</div>
                <div class="_1_C6-P0l">
                  <div>
                    <div class="DbVlY68a">
                      <canvas height="115" width="115" style="height: 115px; width: 115px"></canvas>
                    </div>
                    <p class="_2pBcwUBP">扫码进入下载页面</p>
                    <a href="javascript:;" target="_self"><span>www.wrqpgy.com:9063</span></a
                    ><a href="javascript:;" target="_self"><span>www.wrqpgy.com:9063</span></a>
                  </div>
                  <div>
                    <div class="DbVlY68a">
                      <img
                        alt=""
                        src="https://pbs3img.ggh0807.com/images/new_public/web/bg/fd/cs/d0rhau1dl7hqrafj5e3g_122627.png"
                        style="width: 132px"
                      />
                    </div>
                    <p class="_2pBcwUBP">手机免下载访问</p>
                    <a href="javascript:;" target="_self"><span>www.fhtcmn.com:8899</span></a
                    ><a href="javascript:;" target="_self"><span>www.fhtcmn.com:8899</span></a>
                  </div>
                </div>
              </div>
            </div>
            <div class="_21tMkZGL">
              <div class="_2XNuAIEa aSkAvBrA _3fA8H8tW">
                <div>
                  <img
                    src="data:image/png;base64,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"
                    alt=""
                  />白天模式
                </div>
                <div>
                  <img
                    src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAMAAAC7IEhfAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAEUUExURUxpcV1tj32NsmR2mnWEpqm216Wz0X2MrnCAo4eVtnGCpYKStJK2tn2MrrTS4X+PsV5tka262K+82l5ukV5tkVxskGFylF1tj2Bxk2NzlXODpn6PsX6Osl5ukGFxkqSy0ICPs5urx2FtkXqJqoWUtIuZuYqZuGd2l5CevZilxI+fvZ+ty2x6m5qox2Z2l5Wjwm5/oXCAoXmJrGt6m6S00Zqox6q31bC824CPsaSy0Ku417C926S00GV1mV1tkGFxkmZ1mGNzlml5nGl4m2NzlW5+oXSEpltrjnmJrGBwkmZ1l2t6nHGAoV1tkHuKqnWEpYWUtIuZuZCevZqox5+tzF5ukICPr4COr5Sjwqq41aSy0JWjwsFnupAAAABDdFJOUwD7HxXsGWSvSxlncwOSCPI79tpnI7N5sS3v9923nW7saVI/34+l+YWfOeL/2f6z7Yj2+NBPt5lr3fiGslJdvZA0+m0IsT+pAAAA6UlEQVR42u3M11LCYBSF0R0SUkCEUO1dUUOxdwErtqioqbz/e0ASM5PxBw+3zLDu9pxvDiZ802JWzV6exkdJLxzHUU9GSa/OXdddPgJN1H40TRNBO/7uq66CtNO17a5dj4O0++XZBmmz49lSQNn49CVBSZmmZVqWBIr07lsHYUr48AkgyG+Bferh4WugwpyuEVV++VVjwmYxMorPoSUmzLRLeQTyhXaI48Fo6FwhtzaTyZU4wzB0Q/csgtW6uWfM8hjg9o4hY6C9hz8SGCIx9xghyBgqJj2FDlIK/hNLLsyn02fSioKJ8dADB8o9eLdT+0kAAAAASUVORK5CYII="
                    alt=""
                  />黑夜模式
                </div>
              </div>
              <div class="_2G3nuwKJ"></div>
              <div class="nw0pbZif">
                <div class="uImxsxpQ">
                  <img class="Jt15YIRj ls-is-cached lazyloaded" src="/static/image/home_app_day_all2-828f.png" data-src="/static/image/home_app_day_all2-828f.png" />
                </div>
                <div class="_2UXn9vKG">
                  <img class="Jt15YIRj ls-is-cached lazyloaded" src="/static/image/home_app_day_all1-dbd9.png" data-src="/static/image/home_app_day_all1-dbd9.png" />
                </div>
                <div class="_3lW2YUm-">
                  <img class="Jt15YIRj ls-is-cached lazyloaded" src="/static/image/home_app_day_all3-84eb.png" data-src="/static/image/home_app_day_all3-84eb.png" />
                </div>
              </div>
              <div class="_2v3kEE8g"></div>
              <div class="fD4kRERv"></div>
              <div class="_1gIVvkxa _2ta8XOUu" style=""></div>
            </div>
          </div>
          <div class="clientPage _1LFTn_TC" style="display: none">
            <div class="_2EhulCr4">
              <div class="_37cjjTF_">
                <div class="_2pBcwUBP">
                  <p class="_3rjYMFmr"><span>官方登录器</span></p>
                  <div class="_18xLmyi_">
                    <p>{{ $store.state.appInfo.title }}体育倾情打造，自主研发的防劫持安全登录器；登录器支持 Windows | MacOS | Android平台，使用登录器可直接访问{{ $store.state.appInfo.title }}官方站点，有效防御和避免站点被拦截/劫持等问题。</p>
                    <p>登录器安装简单，能给玩家带来安全娱乐游戏环境体验！</p>
                  </div>
                </div>
                <div class="_2WwTnXb8">
                  <a href="javascript:;" target="_self" class="NQY4olXp"><i class="_1eUkpX4k"></i><span class="_1eUkpX4k">Windows下载</span></a
                  ><a href="javascript:;" target="_self" class="NQY4olXp"><i class="jZP1b--5"></i><span class="jZP1b--5">MacOS下载</span></a
                  ><a href="javascript:;" target="_self" class="NQY4olXp"><i class="_1y1f6P4u"></i><span class="_1y1f6P4u">Android下载</span></a>
                </div>
              </div>
            </div>
            <div class="_21tMkZGL">
              <div class="_2G3nuwKJ"></div>
              <div class="nw0pbZif"></div>
              <div class="_2v3kEE8g"></div>
              <div class="fD4kRERv">
                <div class="_15atzXde">
                  <img
                    class="ls-is-cached lazyloaded"
                    src="https://pbs3img.ggh0807.com/images/new_public/web/bg/fd/cs/d0rhau1dl7hqrafj5e3g_122627.png"
                    data-src="404.png,404.png"
                  />
                </div>
                <div class="_36hm3g03">
                  <img class="ls-is-cached lazyloaded" src="/static/image/home_client_04-3d30.png" data-src="/static/image/home_client_04-3d30.png" />
                </div>
                <div class="j51j3s2P">
                  <img class="ls-is-cached lazyloaded" src="/static/image/home_client_01-9712.png" data-src="/static/image/home_client_01-9712.png" />
                </div>
                <div class="_22e-Azu0">
                  <img class="ls-is-cached lazyloaded" src="/static/image/home_client_02-9085.png" data-src="/static/image/home_client_02-9085.png" />
                </div>
                <div class="_1o7De_AL">
                  <img class="ls-is-cached lazyloaded" src="/static/image/home_client_shadow-27d8.png" data-src="/static/image/home_client_shadow-27d8.png" />
                </div>
              </div>
              <div class="_1gIVvkxa _2wurebx3 _2ta8XOUu _3sRetgKC" style="top: 411px; left: 32px"></div>
            </div>
          </div>
        </div>
      </div>
      <div v-if="1==2" class="skeleton-placeholder" style="min-height: 650px">
        <div class="hotMatchPage _3k3t76l4" style="visibility: visible">
          <div class="AdE-6i2q">
            <div class="_29gnuiyG _1wrvq4El">
              <div class="_35_vygsc">
                <h1 style="margin-top: -23px">热门赛事</h1>
                <h2>POPULAR EVENTS</h2>
              </div>
              <div class="_2zJiZW9W"></div>
            </div>
            <div class="_1TyCTOg1">
              <div class="_2TQiMaa9">
                <div class="_2fwdlWR_ _3aqB3ztJ lazyloaded" data-bg="/static/image/home_hot_events_box-c775.png" style="flex: 1 1 auto; background-image: url(/static/image/home_hot_events_box-c775.png); background-size: 100%">
                  <div class="_13dUgEE5">澳洲甲组联赛</div>
                  <div class="kA_Piv-G">2022-03-27 16:05:00</div>
                  <div class="_3pvZQTss">
                    <div class="_2iwFmLom">
                      <div class="_3hROuJmH">
                        <img src="/static/image/806320285656974bb09f04328a791dcec81b30f6.png" />
                      </div>
                      <div class="_3drxgMix">墨尔本胜利</div>
                    </div>
                    <div class="_2iwFmLom">
                      <div class="_3hROuJmH">
                        <img src="/static/image/ab58732a23857f62da9289308fcbb305e53d7ea4.png" />
                      </div>
                      <div class="_3drxgMix">西悉尼流浪者俱乐部</div>
                    </div>
                  </div>
                  <div class="_17u-gRsX">
                    <div class="JAWawQjY">
                      <div>胜</div>
                      1.84
                    </div>
                    <div class="JAWawQjY">
                      <div>平</div>
                      3.83
                    </div>
                    <div class="JAWawQjY">
                      <div>负</div>
                      4.19
                    </div>
                  </div>
                  <div class="_349CzCYy xJQe3jRu WkGXKdY5" style="border-radius: 25vh" @click="goGamePage('sbtest', '2', '')">
                    <span
                      >进入投注
                      <div></div>
                    </span>
                  </div>
                </div>
              </div>
              <div class="_2TQiMaa9 _3QSskiSo">
                <div class="_2fwdlWR_ _3QSskiSo _3L_wtLP- lazyloaded" data-bg="/static/image/home_hot_events_box-c775.png" style="flex: 1 1 auto; background-image: url(/static/image/home_hot_events_box-c775.png); background-size: 100%">
                  <div class="_13dUgEE5">西班牙乙级联赛</div>
                  <div class="kA_Piv-G">2022-03-27 22:00:00</div>
                  <div class="_3pvZQTss">
                    <div class="_2iwFmLom">
                      <div class="_3hROuJmH">
                        <img src="/static/image/09cb36df7d90e89ecb78cca7a763a2dd.png" />
                      </div>
                      <div class="_3drxgMix">布尔戈斯</div>
                    </div>
                    <div class="_2iwFmLom">
                      <div class="_3hROuJmH">
                        <img src="/static/image/6adbbb2bf898c51e27e5966e7d853da70c3e9a3e.png" />
                      </div>
                      <div class="_3drxgMix">特内里费</div>
                    </div>
                  </div>
                  <div class="_17u-gRsX">
                    <div class="JAWawQjY">
                      <div>胜</div>
                      3.22
                    </div>
                    <div class="JAWawQjY">
                      <div>平</div>
                      3.03
                    </div>
                    <div class="JAWawQjY">
                      <div>负</div>
                      2.49
                    </div>
                  </div>
                  <div class="_1vlObydt">
                    <div class="_2AAN9lD4">
                      <div>大1.5</div>
                      <div>1.59</div>
                    </div>
                    <div class="_2AAN9lD4">
                      <div>+0.5</div>
                      <div>1.62</div>
                    </div>
                    <div class="_2AAN9lD4">
                      <div>-0.5</div>
                      <div>2.42</div>
                    </div>
                    <div class="_2AAN9lD4">
                      <div>小1.5</div>
                      <div>2.44</div>
                    </div>
                  </div>
                  <div class="_349CzCYy xJQe3jRu WkGXKdY5" @click="goGamePage('saba', '2', '')" style="border-radius: 25vh">
                    <span
                      >进入投注
                      <div></div>
                    </span>
                  </div>
                </div>
              </div>
              <div class="_2TQiMaa9">
                <div class="_2fwdlWR_ _2gTJ-Sjp lazyloaded" data-bg="/static/image/home_hot_events_box-c775.png" style="flex: 1 1 auto; background-image: url(/static/image/home_hot_events_box-c775.png); background-size: 100%">
                  <div class="_13dUgEE5">西班牙甲级联赛RFEF</div>
                  <div class="kA_Piv-G">2022-03-27 18:00:00</div>
                  <div class="_3pvZQTss">
                    <div class="_2iwFmLom">
                      <div class="_3hROuJmH">
                        <img src="/static/image/4bf35ede7056a75de85488251f301397505a2779.png" />
                      </div>
                      <div class="_3drxgMix">塞尔塔B队</div>
                    </div>
                    <div class="_2iwFmLom">
                      <div class="_3hROuJmH">
                        <img src="/static/image/919bf7dc69e3750152fd7abc4cd56084226903fa.png" />
                      </div>
                      <div class="_3drxgMix">拉科鲁尼亚</div>
                    </div>
                  </div>
                  <div class="_17u-gRsX">
                    <div class="JAWawQjY">
                      <div>胜</div>
                      2.66
                    </div>
                    <div class="JAWawQjY">
                      <div>平</div>
                      2.95
                    </div>
                    <div class="JAWawQjY">
                      <div>负</div>
                      2.47
                    </div>
                  </div>
                  <div class="_349CzCYy xJQe3jRu WkGXKdY5" @click="goGamePage('obgty', '2', '')" style="border-radius: 25vh">
                    <span
                      >进入投注
                      <div></div>
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div v-if="1==2" class="skeleton-placeholder" style="min-height: 650px">
        <div class="venueBettingPage _3u2zVkvN" style="visibility: visible">
          <div class="_29gnuiyG _1gV_y6ef" style="margin-top: 190px">
            <div class="_35_vygsc">
              <h1 style="margin-top: -23px">场馆投注</h1>
              <h2>TOP GAMES</h2>
            </div>
            <div class="_2zJiZW9W">
              <div class="_349CzCYy xJQe3jRu _12ZkQT2g _3gi7jqcw">
                <img class="_2JoosS9F" src="/static/image/1.png" alt="" style="height: 40px; margin-left: -8px" /><img class="_2JoosS9F hover" src="/static/image/1-hover.png" alt="" style="height: 40px; margin-left: -8px" />
                <span>真人娱乐</span>
              </div>
              <div class="_349CzCYy xJQe3jRu _3gi7jqcw"><img class="_2JoosS9F" src="/static/image/2.png" alt="" style="height: 40px; margin-left: -8px" /><img class="_2JoosS9F hover" src="/static/image/2-hover.png" alt="" style="height: 40px; margin-left: -8px" /><span>体育投注</span></div>
              <div class="_349CzCYy xJQe3jRu _3gi7jqcw"><img class="_2JoosS9F" src="/static/image/3.png" alt="" style="height: 40px; margin-left: -8px" /><img class="_2JoosS9F hover" src="/static/image/3-hover.png" alt="" style="height: 40px; margin-left: -8px" /><span>电竞投注</span></div>
              <div class="_349CzCYy xJQe3jRu _3gi7jqcw"><img class="_2JoosS9F" src="/static/image/4.png" alt="" style="height: 40px; margin-left: -8px" /><img class="_2JoosS9F hover" src="/static/image/4-hover.png" alt="" style="height: 40px; margin-left: -8px" /><span>棋牌游戏</span></div>
              <div class="_349CzCYy xJQe3jRu _3gi7jqcw"><img class="_2JoosS9F" src="/static/image/5.png" alt="" style="height: 40px; margin-left: -8px" /><img class="_2JoosS9F hover" src="/static/image/5-hover.png" alt="" style="height: 40px; margin-left: -8px" /><span>彩票投注</span></div>
              <div class="_349CzCYy xJQe3jRu _3gi7jqcw"><img class="_2JoosS9F" src="/static/image/6.png" alt="" style="height: 40px; margin-left: -8px" /><img class="_2JoosS9F hover" src="/static/image/6-hover.png" alt="" style="height: 40px; margin-left: -8px" /><span>电子游艺</span></div>
            </div>
          </div>
          <div class="_3UXr8okJ">
            <div class="urkqVk0T">
              <div class="h8F0rsYF">
                <div @click="goGamePage('bg', 'videogame', '')">
                  <div class="_3Qb2m-4D"><img class="_20idKi0_" src="/static/image/bbin.png" alt="icon" /><img class="KY5Xi91r" src="/static/image/bbin_hover.png" alt="activeIcon" /></div>
                  <p>BBIN真人</p>
                </div>
                <div @click="goGamePage('ag', '1')">
                  <div class="_3Qb2m-4D">
                    <img
                      class="_20idKi0_"
                      src="data:image/png;base64,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"
                      alt="icon"
                    /><img
                      class="KY5Xi91r"
                      src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEQAAAA0CAMAAAAE725BAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAMAUExURUxpcc17Xf+qqs56Yv9/f/9/f9R/f8V2YcyZZv///9R/ataLasx3Ws14Xc14W8p1Wsp2Wst1XMp2Wc96Xsd4X8t3W8t2Wct2Wct3Wct3Wcp2Wct2Wcx3Wst2Ws55XMp2Wsp2Wst2Wcx4Wct2Wct3Wst3Wsp2W8t2Wct3Wv39/cx5XMh3XMx3Wsx3Wst4W8t3Wct3Wcp3Wct3Wsl4Wcd5WMp2Wcp3W8t2Wst3Wst2Wcl4Xc9/X8t4Wst3Wct3Wst3Wcl0X8x3W8t2Wct4Wd2jjsx4WvnUyPPQxffVyc15Wsh3WP/9/cx2Wsx3Wv3z8d2chvnZzfrh2cx3WvnXy813WcZ/Y/nn4cp3Wfvk3M59YuWqleSplPvk3Pjc0u/DtPrc0vvu6fXFtfrTxsx2WtOFa/jh2fbMvu7BsfPPwuOrme3AsPTMvu+xnvvp4/XSxv35+Mp4W8t2Wct3Wsp2Wf36+ei1pO7Kvv318teTe+e1o89/Y9qdh/rh1vTa0c19YPPAr/HIuvbKvPns59SKcPnf1vXJus18X+Wkj9iSe+u3ptSIbfS4o/vc0f////338+rDt9CDavXc1PXQxPzz8PTVy+Kum/zt6Om1pO/AsNyVffTTx818YvHDtNeNc+SolO2+ruazoPDEtuewntuWfvvo4NSLc+y4puCgiuzIu/bTyPnw8Pv19fz08/r18vzz8/Tl4NWRedicgdOKcd2dhOKql9KGbfzq5OGhjevFt85/ZNSHbPjm4dyZgfjLu9WIb+q7rNmNc/fWzNOIadF9Yf/8+st4XNGFavno5O/Iu/////////zZzv7v6/zd0v/7+v3m3/3n4PrMvf77+v/6+fvRw/ze1P718/7y7vzh2P3u6f3r5vzk2/vUxv3l3fzg1v/39f708PvVyfzb0P///vzi2fvSxf/59/3t6PnBr/nIt/7w7P3p4/vQwvrKuvrFtPrLvPvWyvrPwPm9qfvYzP739PrUyP3q5Pi6pvnDsfrOwP3o4vm/rPrJuP7s5vrHtvvYzHRh8poAAAEAdFJOUwAZAwoCBAYNBQEMB2ccJDAqFZMbECeKj6S0SaBqbzRfc6d9dqw9Q527/iAvQFVRSlqqgC0XRmKEesETEFjFmJoYN6+Hzzn01ucyQv5kh/i68fSW90wS8ZH8xcvR9uza9fDz/cun6Prlx7bS4Oj45+lO2NRh9byu/LqimI744K3r0u7nr/L2n9umz5vy+/jLfH3M+Omvw/vfw87ej8uIuKyy4N/c9rjjwuHxW56tvW+Xk0Nemn6D+6THvMbPbvfRiFjrdIb7wYzp3P/9//////////////////////////////////////////////////////////////////////42EOOBAAAHWklEQVR42u2WZ1SaWRrHh94RkCogIBGIIIqIigVbjLEbe8YY03tM75Pey05vmZ7Zqdt777tfMoolwaAgRlESJfYuGtl7IQK7OW52P+458zvPee977z3+vU/hvs8L3/J/DIGARiORGAwG/++ANSQSTSD8FxpoJB5LQqGIuGcholAkLAbIPFcDg0V9786SfAdFwiOfJ4LGkFDM7y8tspeOI+HRhGe9xwcAJOiUl5cW+SEFqCAJ/9n7JDqCqtzbc6cH2B1gPQDfO7Af0yjlKDzBpwFP/qO8vJ68HmCe0UveoX/cbbwLrLHx0GvHT7766skj5xu93Gt8JZQaS8SiA7wnlv/gLgT+AbDFce+DBxPQjv7mBIedWVDA5lQeLpyAPJj4mYqGwPlECEgsMTH45Yn7fo4Wesf1XeYus9lcUcTlGxiVHA6jRM499rZnbf1BXRAlieQTwaCYwaw3nM72pzQ0HDnS0ABGZ4Vnvuq3PA13x5b1heezT8glGSvgmvMUOSpQBI3FpVF/am5/Ynli8ZId9uGvLBYwvfgEPtYoMorWA6+AE4U7uBmKOgtguwCIMLGERRESkxL0SrurGeJqdrlqTjAY2XB6sQo8qm4peG8dvW92gqOZuwo3a3grHjc3P/4EngTnyw4SRadmvTllXeSlC3w+v8hms1lLrVab9R0975jZaZlqtjU1PbY4K9776naT1er6Sb5Oi8BhnooQ8EQELfc1W1unl9YvNVw+V/M1eH0drN1cw5NUtLusnu02q6vd7Jyydna+FCbKpcWikItxxQJvora0Ge0Qo/1T3s6rqXJudavR+LrRbtzGk7z1yNYJ3jx02lwua6vdWCdNDmfRUWh/SCJC1VXG8fH68fr68TOKz9/O5jBST5eOj28Fa9UafrbNWA82vQAxO5idFarTI8r9yYEh+UXb+ORkx2RHx6U1vBpLRUw8h//OyNaN3d3jx7iGGuNIB+DTK9XVLwKqL3V3jB8WlOVQkrD+uMayVB/bHQOQrX9SXGvubT4pjWFc2LjBYTK5T6cyit0m04BpYI1ewVum0SzLODfgcP88P0QZ7EsOAUNEaHXb3aMtgOHv6j+vMrqN28nieMO2DbOzsyObSyp3mcDW7KVNekWGRiLRnN44OrsxQSSjIYiYxbjicSCudY7B+fn5wSt63qpWx2z3RRFZyinaMDg/PFnE4Hw0C/e2frHt9rp1m/ncF7uHh8+JYVz9yfHEtbRlCLBbz+OWZCYI4qKTRcJ4w5n+oQXTTvCLOQP2+k2drqmpnRzG5WJH//w6oTqLmkjyJyeRmvWHyYW+vr4boCQM7BgpFIkmJ3D+ONTX11L6PpuxeXdf38xgR33pjpiY+F324Zmhw+Sy0AgmEPHVKyv8+Gzf2Nj073iSnTV/XVVXV7eqZst26fXRvrG5IfdZNscgubX7xo3dX/5dKhZntw3MzA39Oi4ksOhBXGmyd+fHpqdv8STXXLbe3ra23l5rU/OHHw2DxbmW1nfZDDlXo+GWFCQI//Zem2NmenrmlyKZFkH0Fz0OodTtmp8bu5IhKaoCFeGAdIwYP7jWMjc2NrcwUnX2fYZBLjdwYqQfr7aODILzbRAnq1iBRZ8EklM8Ov+FRHJhbefkbIuXUXftLlP/wsLCoKP18Z6zO65fv/pJ9lqL1W4a7F+Yvy2MzKIGFn15ROhf2kbOXeZfvthkn3SYvDjcN792eyaT9b1T7U5Aw6MpW6u7Ayx1fCDYB+MaWPTpf7bVXjXITz2ytdp9tNbV3nS73aUrVxbXrl772Z49ez5bu7q2eCWk+DiMK/Nfij78TcvqU1sqzI9cNj9N63gKhV6vWMZnxCeIhRBxQlgmI5XPN7DF0fCWxgfElab6vdnZdX+iywnvVXDDggfgqxUeNHIQUKGATCYLhNKwgkqDwcAJI6vTqbBefSLBWtkb9x4+BPbwwcMA7jVCCuXgIELyQZFIFEcGKvFsNijpZJmSAkPiv5GUskPfLF++PA8CBu/o5Zu8894KjlSr1ZHJonyBWCoW5ifrQqlpOKw/OUlAJFoYX5nK1WQo9CmbDuzfv//AgU0pCvCZSGV4JJLVUTpZrkwXUqaOjI6OjizLDWUFM1EYQoCIVhUpCPNUZQYPhDIlJUUPbw4gkRkmFYgio2Th6aE5OTmh6VnhKlWuKjxUSw1ORGGRfhEQ2Kx9ccKwAg4oSz5XooFIuPISTmaYGEqo0oNoLCqExaJBWBGUWCaKhPF/hrFEOjVHpj4oAPmLic/MZHsoiI9JkArJHgktKyIYkRYbG5uWhoCk0elJOBRsk17wZQdVHswKVZVFRovi8mEeIWRyfpwoOnJfiCpdyaKkJTJxRD8oT6eFhBq+jzkJR6ewgtLDc3UhISFRTwnR6WSq8PQccApEIvi3eEwASE/PRwhszPAkXCIigkrTapXKoKcolVot8J0aQUHQmb6TLw0BCfuqRDrwN9gHwkssPRF4TwIaz+9VMUv2mbDRxHsbzefK+DveZ1teNJT4lv+NfwKgtsJH+Ks7oAAAAABJRU5ErkJggg=="
                      alt="activeIcon"
                    />
                  </div>
                  <p>AG视讯</p>
                </div>
                <div @click="goGamePage('allbet', '1', '')">
                  <div class="_3Qb2m-4D"><img class="_20idKi0_" src="/static/image/allbet.png" alt="icon" /><img class="KY5Xi91r" src="/static/image/allbet_hover.png" alt="activeIcon" /></div>
                  <p>欧博视讯</p>
                </div>

                <div @click="goGamePage('wm', 'videogame', '')">
                  <div class="_3Qb2m-4D"><img class="_20idKi0_" src="/static/image/wm.png" alt="icon" /><img src="/static/image/wm_hover.png" class="KY5Xi91r" alt="activeIcon" /></div>
                  <p>完美视讯</p>
                </div>
              </div>
            </div>
            <div class="_2uoOSzaX" style="pointer-events: auto">
              <div class="I0a57ghh fangda">
                <img class="p8XIrAcI ls-is-cached lazyloaded" src="/static/image/center-3b6e.png" data-src="/static/image/center-3b6e.png" /><img
                  class="MGgN_yFA ls-is-cached lazyloaded"
                  src="data:image/png;base64,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"
                  data-src="404.png,404.png"
                /><img class="_1zN4nger ls-is-cached lazyloaded" src="/static/image/float2-1d79.png" data-src="/static/image/float2-1d79.png" />
              </div>
            </div>
          </div>
          <div class="_3UXr8okJ" style="display: none">
            <div class="urkqVk0T">
              <div class="h8F0rsYF">
                <div @click="goGamePage('hbb', '2', '')">
                  <div class="_3Qb2m-4D"><img class="_20idKi0_" src="/static/image/asia.png" alt="icon" /><img class="KY5Xi91r" src="/static/image/asia_hover.png" alt="activeIcon" /></div>
                  <p>ASIA体育</p>
                </div>
                <div>
                  <div class="_3Qb2m-4D" @click="goGamePage('obgty', '2', '')">
                    <img
                      class="_20idKi0_"
                      src="data:image/png;base64,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"
                      alt="icon"
                    /><img
                      class="KY5Xi91r"
                      src="data:image/png;base64,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"
                      alt="activeIcon"
                    />
                  </div>
                  <p>OB体育</p>
                </div>
                <div @click="goGamePage('oap', '2', '')">
                  <div class="_3Qb2m-4D"><img class="_20idKi0_" src="/static/image/ssty.png" alt="icon" /><img class="KY5Xi91r" src="/static/image/ssty_hover.png" alt="activeIcon" /></div>
                  <p>三昇体育</p>
                </div>
              </div>
            </div>
            <div class="_2uoOSzaX" style="pointer-events: auto">
              <div class="I0a57ghh fangda">
                <img class="p8XIrAcI ls-is-cached lazyloaded" src="/static/image/center-7910.png" data-src="/static/image/center-7910.png" /><img
                  class="MGgN_yFA ls-is-cached lazyloaded"
                  src="data:image/png;base64,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"
                  data-src="404.png,404.png"
                /><img class="_1zN4nger ls-is-cached lazyloaded" src="/static/image/float2-0895.png" data-src="/static/image/float2-0895.png" />
              </div>
            </div>
          </div>
          <div class="_3UXr8okJ" style="display: none">
            <div class="urkqVk0T">
              <div class="h8F0rsYF">
                <div @click="goGamePage('ia', '2', '')">
                  <div class="_3Qb2m-4D"><img class="_20idKi0_" src="/static/image/ia.png" alt="icon" /><img class="KY5Xi91r" src="/static/image/ia-hover.png" alt="activeIcon" /></div>
                  <p>小艾电竞</p>
                </div>
                <div @click="goGamePage('ld', '2', '')">
                  <div class="_3Qb2m-4D"><img class="_20idKi0_" src="/static/image/ld.png" alt="icon" /><img class="KY5Xi91r" src="/static/image/ld-hover.png" alt="activeIcon" /></div>
                  <p>雷火电竞</p>
                </div>
                <div @click="goGamePage('avia', '2', '')">
                  <div class="_3Qb2m-4D"><img class="_20idKi0_" src="/static/image/12.png" alt="icon" /><img class="KY5Xi91r" src="/static/image/12-hover.png" alt="activeIcon" /></div>
                  <p>泛亚电竞</p>
                </div>
              </div>
            </div>
            <div class="_2uoOSzaX" style="pointer-events: auto">
              <div class="I0a57ghh fangda">
                <img class="p8XIrAcI ls-is-cached lazyloaded" src="/static/image/center-439e.png" data-src="/static/image/center-439e.png" /><img
                  class="MGgN_yFA ls-is-cached lazyloaded"
                  src="data:image/png;base64,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"
                  data-src="404.png,404.png"
                /><img class="_1zN4nger ls-is-cached lazyloaded" src="/static/image/float2-500f.png" data-src="/static/image/float2-500f.png" />
              </div>
            </div>
          </div>
          <div class="_3UXr8okJ" style="display: none">
            <div class="urkqVk0T">
              <div class="h8F0rsYF">
                <div @click="goGamePage('bg', 'qpgame', '')">
                  <div class="_3Qb2m-4D"><img class="_20idKi0_" src="/static/image/bg.png" alt="icon" /><img class="KY5Xi91r" src="/static/image/bg_hover.png" alt="activeIcon" /></div>
                  <p>BG棋牌</p>
                </div>
                <div @click="goGamePage('datqp', '2', '')">
                  <div class="_3Qb2m-4D"><img class="_20idKi0_" src="/static/image/dtqp.png" alt="icon" /><img class="KY5Xi91r" src="/static/image/dtqp-hover.png" alt="activeIcon" /></div>
                  <p>大唐棋牌</p>
                </div>
                <div @click="goGamePage('fg', '2', '')">
                  <div class="_3Qb2m-4D"><img class="_20idKi0_" src="/static/image/fg.png" alt="icon" /><img src="/static/image/fg-hover.png" class="KY5Xi91r" alt="activeIcon" /></div>
                  <p>FG棋牌</p>
                </div>
                <div @click="goGamePage('hlgame', '1', '')">
                  <div class="_3Qb2m-4D"><img class="_20idKi0_" src="/static/image/hg.png" alt="icon" /><img src="/static/image/hg-hover.png" class="KY5Xi91r" alt="activeIcon" /></div>
                  <p>欢乐棋牌</p>
                </div>
                <div @click="goGamePage('kx', '1', '')">
                  <div class="_3Qb2m-4D"><img class="_20idKi0_" src="/static/image/kx.png" alt="icon" /><img src="/static/image/kx-hover.png" class="KY5Xi91r" alt="activeIcon" /></div>
                  <p>凯旋棋牌</p>
                </div>
              </div>
            </div>
            <div class="_2uoOSzaX" style="pointer-events: auto">
              <div class="I0a57ghh fangda">
                <img class="p8XIrAcI ls-is-cached lazyloaded" src="/static/image/center-5891.png" data-src="/static/image/center-5891.png" /><img
                  class="MGgN_yFA ls-is-cached lazyloaded"
                  src="data:image/png;base64,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"
                  data-src="404.png,404.png"
                /><img class="_1zN4nger ls-is-cached lazyloaded" src="/static/image/float2-db61.png" data-src="/static/image/float2-db61.png" />
              </div>
            </div>
          </div>
          <div class="_3UXr8okJ" style="display: none">
            <div class="urkqVk0T">
              <div class="h8F0rsYF">
                <div @click="goGamePage('bbin', 'bbinlottery', '')">
                  <div class="_3Qb2m-4D"><img class="_20idKi0_" src="/static/image/bbin.png" alt="icon" /><img class="KY5Xi91r" src="/static/image/bbin_hover.png" alt="activeIcon" /></div>
                  <p>BBIN彩票</p>
                </div>
                <div @click="goGamePage('imone', '3', '')">
                  <div class="_3Qb2m-4D"><img class="_20idKi0_" src="/static/image/17.png" alt="icon" /><img src="/static/image/17-hover.png" class="KY5Xi91r" alt="activeIcon" /></div>
                  <p>双赢彩票</p>
                </div>
                <div @click="goGamePage('vrbet', '3', '')">
                  <div class="_3Qb2m-4D">
                    <img
                      class="_20idKi0_"
                      src="data:image/png;base64,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"
                      alt="icon"
                    /><img
                      class="KY5Xi91r"
                      src="data:image/png;base64,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"
                      alt="activeIcon"
                    />
                  </div>
                  <p>VR彩票</p>
                </div>
                <div @click="goGamePage('tc', '3', '')">
                  <div class="_3Qb2m-4D">
                    <img
                      class="_20idKi0_"
                      src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEQAAAA0CAMAAAAE725BAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAMAUExURUxpcdbW1nOCo5Smyn+OrY2cu5Gay2x7nYWTs4iWuHKBo2h4mmR1l6Oy0XODpnODpW18n32QrV5ukHSDpmBwk3+Rr29/oqGyzJSjwG1+oGd1ml5ukHmFqV9vkWR0lIGSs2FylKq31aWy0Zakw4WTtYqVuXiIqWFwk3+OrmJxlF9ukltrjmJylHGApV1tkGJylF9ukWZ1lqq31Kaz0nqKqqu513qLrp+szJKhwW1+oZGfvltrjmx8npWjwoyau2x8n4GQsJmnxouZuWNzlW9/oVtrjoGQsZCgv5uoxoKQsG18noGPsHqJq2t7nXuKqmJylGZ2mGNzlWl4mml5m3aFpmV0l2V1lmx9n2p5m3eFpneHp19vkWFxll5vkXSDpF5tj15vkVxrjq+92p+ty4GQs3+QsrC+3Gt7nKy515upxqCuzKSz0YeWtn6PsrK+3pCdwK+42KSx0HOCpqq41o2cu52ryZupx3uLrpSiwXeIqmF0lJqoxpyqyIaVtpqox5elxI6dvIWTtIWTs52rynqKq56ryoiXtmZ3mXmJq2t7n4aVtYiWtltrjl9ukXaGqGh3mYCPr5OiwY6cvFxrj3mIqXqJqnyLrHKBoniIqX6Mq1xrjmZ2mHSDpFxrjmR1l11rj2JxlICQtLC82pCfvq+93Ke002+AopOiwaq41aGvzHmJra262XaGqI6cu6282Ka00qe1032NsIeWtneIqoeWtmx8nmV0louYuJ6tzJelxGl5nYeWtY6bvF9vkoSSsn2LqouauZWjwY6dvmNylIGQrWh5mmh3mWt6nHaFp5elxIiXt32LrV1skJKhwHSEpZqox25+n5elxJ2rym59nnqJqniHqGJylHGAoq262Gl4m19ukXeGp36NrW9/ooqZuKa00nmJrKOx0KCuzXaGqXKCpWV0lmV1l5OiwYGPsFtrjWh3mYuZuZGfvmt7nICPr3yMr32Nr6m31Wx8nn2Mraq31Wt6nISTs4GQsICQs6+92pakw2Z2mI6cvGZ1mGh4mYeWth6f1MwAAADOdFJOUwACVAac4wRjgDpDn3FxcbKrCD8rThUcDCEPFeYM9zQn9J0rXC0bkoa7YDn1xjF4j+w9FF7niolYWFj7u7HqjvyGzoroiq/lm3Bxvqzz01X7vqj7b6x+sSCzftZVJNvawy375bd4uXjnfZj/m96CHzA0sV7d+P3H2f2bRvu0Nu+sb4aN4/mJt7mf44HIjqHn68bcemvKYUqqxDa29PPvx25m5LiDt+j9tvG5hNHvo+zso+LsPNT4nq4yg8vug9X6anxGZrlFetvW/vdUQP5x+u6YJwAABB9JREFUeNrt0XVUW3cUB/Cb0T3KkAQCwYIVd2ihpViheJGixa3eUHdvt7q769zd3bf/OjSMBwQIkBEkJehWCOy+l9ey7Y/HY//1nH7Oy/d3373v3JecwBOPKd765S8s/gstfmn5Wvhf1ga+8/s/vLlyJkzVTAe1elOgg3pgQD2gVg84BG4aeG2lOUzJrHeb3lsPYNjEMASYUdb08izgjihr2TADkGELA5fgmg0tZTrAkfnrcon2nYZyiUQukcsluATNkciXcNxCLKmsrNwyB9986EAl48Chz3DHFqx2c9uy6jfKrvh91LE3cuvWyL1UtTt+Fz1YBRw4VjwS9rkF0CziIyseVDzAC7uOHP7bsH2O2/+gnHPUgQnfn6Ob24NeDTOHycQFW0BQcHd3d9x/njWPw2ZwEKwLfhEm4bw5HHP/6Oh5+Orpf/kBzo+O7sfh25udgd18mQXmYdl8CJd1dcm6ZDIMmuw7HH6Kw3Vd4cCK98FHmHvGTxDGelrHx7/UYxA6J8btcLx6NbDaM/Qs5nPf2DlNZxweGjr+sLbQ046HnIDN9OFpCQkJsYngphpWDQ93DHfQVB0qFUYinI2NiIhIVC0FNm4NDf0N/f0/mU3TOttAc2NuxSnauRuwCaimJBFmdnbXLl9yuYg3uUerqw9edfn28jW7bDMiqZoSAGzqa2rqa+qvwul6CpZ5KSKzS3nYpOXBxXq6Bjb3aJkiKm8W8XOFILrHBxDm8otuUj1RJgYCNrW0K8bPTKgtemqC+EotDdhUlZdXlVcJvPFEVI3XxFnuLaDrKmCzYnCwZ7BngajnV92HBD05mAzLBdS8ZwWwOdJJOaOTfkNf62cQjv3Cg0fOjHWOdXamApus9k8MDAyi/Be1M24DpLbfBf9FWUCxxCnOXIGNidQX0zctX+pljAqkXgC2Untf+4W2QBHhJ00qtQU2PGtrHkAJmV1M3gUPPz+yGExtSJK0NgHw8TtlZQlA+JGFwO6k0gPz+vWSW6WmJSEhISfBpDgmROnpQ1xQWlvhKjBRKl2BnZVnDOYFpY+JZ+kdAhh3SpXWylse7vlYxyg9RTCJLNKD/gXutoVkYb4xaBWcsvm6wNTGZif4k6QrTEYc5WW6UIqyLF3tpfY/+poyfbEBtu13ekmjLGFS7hqNRqFRKEZu+1tlHLmhSAOabapCoxnRjIwo3IED/TpKekZOXbKumGeVTX0N3S/qcjLS6YE+cEEI+vr65s0F8I4+Ni85VCAITf74WLQQYG4fCiWAE4Lf+AruQEaNWrVGQNnY2Mg3Bo540W18Ib2kjUEv8ea3ufCAu5TTrTuEuKSVYQS8DzNb39oIUyJ+42Dzttk7mhlHXQKak2abwVQ5r9l2v/d+by8Gdb7PsoKV05plz/+JYpctdYInHlN/A92EOn1l37iFAAAAAElFTkSuQmCC"
                      alt="icon"
                    /><img
                      class="KY5Xi91r"
                      src="data:image/png;base64,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"
                      alt="activeIcon"
                    />
                  </div>
                  <p>TCG彩票</p>
                </div>
              </div>
            </div>
            <div class="_2uoOSzaX" style="pointer-events: auto">
              <div class="I0a57ghh fangda">
                <img class="p8XIrAcI ls-is-cached lazyloaded" src="/static/image/center-8e97.png" data-src="/static/image/center-8e97.png" /><img
                  class="MGgN_yFA ls-is-cached lazyloaded"
                  src="data:image/png;base64,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"
                  data-src="404.png,404.png"
                /><img
                  class="_1zN4nger ls-is-cached lazyloaded"
                  src="https://pbs3img.ggh0807.com/images/new_public/web/bg/fd/cs/d0rhau1dl7hqrafj5e3g_122627.png"
                  data-src="404.png,404.png"
                />
              </div>
            </div>
          </div>
          <div class="_3UXr8okJ" style="display: none">
            <div class="urkqVk0T">
              <div class="h8F0rsYF">
                <div @click="goGamePage('pg', '2', '')">
                  <div class="_3Qb2m-4D"><img class="_20idKi0_" src="/static/image/pg.png" alt="icon" /><img src="/static/image/pg-hover.png" class="KY5Xi91r" alt="activeIcon" /></div>
                  <p>PG电子</p>
                </div>
                <div @click="goGamePage('obgpy', 'obgpy', '')">
                  <div class="_3Qb2m-4D"><img class="_20idKi0_" src="/static/image/ob.png" alt="icon" /><img class="KY5Xi91r" src="/static/image/ob-hover.png" alt="activeIcon" /></div>
                  <p>OB捕鱼</p>
                </div>
                <div @click="goNav('/amusementList?type=pp')">
                  <div class="_3Qb2m-4D">
                    <img
                      class="_20idKi0_"
                      src="data:image/png;base64,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"
                      alt="icon"
                    /><img
                      class="KY5Xi91r"
                      src="data:image/png;base64,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"
                      alt="activeIcon"
                    />
                  </div>
                  <p>PP电子</p>
                </div>
                <div @click="goGamePage('PS', '2', '')">
                  <div class="_3Qb2m-4D"><img class="_20idKi0_" src="/static/image/ps.png" alt="icon" /><img class="KY5Xi91r" src="/static/image/ps-hover.png" alt="activeIcon" /></div>
                  <p>PS电子</p>
                </div>
                <!-- =bg&game_type=egame -->
                <div @click="goGamePage('bg', 'egame', '')">
                  <div class="_3Qb2m-4D"><img src="/static/image/bg.png" class="_20idKi0_" alt="icon" /><img class="KY5Xi91r" src="/static/image/bg_hover.png" alt="activeIcon" /></div>
                  <p>BG捕鱼</p>
                </div>
              </div>
            </div>
            <div class="_2uoOSzaX" style="pointer-events: auto">
              <div class="I0a57ghh fangda">
                <img class="p8XIrAcI ls-is-cached lazyloaded" src="/static/image/center-ec25.png" data-src="/static/image/center-ec25.png" /><img
                  class="MGgN_yFA ls-is-cached lazyloaded"
                  src="data:image/png;base64,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"
                  data-src="404.png,404.png"
                /><img
                  class="_1zN4nger ls-is-cached lazyloaded"
                  src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASgAAADECAMAAAAbKExmAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAMAUExURUxpcZ9nNcKAM4FNLm0zLqFsPeS4dcykZfzmoLyITuS0bOu8c/DRheeebHhCM244OHdEF4VTOvvoofXWf/PSfvDUi+ujbb6AKsaJLXhFM+/Lb3c+PfOcfcCCKvXXk8KDKLt7LPjdi35JMvnkneq5Y7V2JPPOcN+lO/ORcM6UOeq8VffhmvjekbV2JaBhGuStSPTXiu7FX/Gdd9VNLPXWhPagho5TF+J0S9ihPKBgHrJxIeBfOumDVvCgivXWfe7FX+zCXLd2JO/GZNqjPN2nPuu/WNifOfTRcrp3JNabNvXUefKehOOwRu+ijvPPcOCqQeKtQ7VzI+WzSOa0TPfahfbYgHVCFPbYg8xGJ+FgOPTSdnNAEt5cNfHLaeq9VfLObvjbiLJxIuNkPNOYM/HNa+m7Uua4Te+lkvnfk9BJKuVoP9CUMfDJZ82QL+i4UcSEKfrhl8M+I7BuIdxYMshBJcqMLdpVMbAxG9NNLL07IqVkHcaJK+e3T718JqxrH6lnHWsfGfndjb93I5hYGPSokNZRLuZsRedwS6FgG8CAJ3xBE3E3DPOrloRKFZY3Ceh0UJxdGnhEFbg3IfSvm58pFvXCUfvkmo5SFolOFst4IYE+ELE2Iva4p9lRL3ofFvKkjfK8Sn5IFZJVGPjJve6ahmolH3pGF/XHWm8cEuaKHt55F/W1ofSihul5WNJ4HvjPxH8qB5YlFvbQaKQzJGwrJ/a9rvfDtpMvBvLNYootB6ctGuyVfeuHavC0QoQhFeGcNvTZdMV4I5UzKeqCX8+EJ+yWIuyNc/WkiuSlPZQ+DeSuSLFaFI0kF6I/DIk6DclpHLtiF8NvHa1MEOGTMOzAW9eLK/fegPrjjIc5Mv7roPaWdO6+VHY4D7tsHfnZ0uucLNaSMOrFVNxTIKFOEu6qOOKOJ9xqKXIoCeR+NNmBJfGhk+ylT+eXQvnUzP/wqNI/GsA3E9WfNJRKEr9RGvO6eOeJRtlqEtNOC+VtM/CraPW/jvfOkvjOoPjWqPrh3KQ+HB/ZkmEAAAD9dFJOUwBDaYH+Ix0H/hEvPlFT0/3gYubiimyLqtm7uPPOypTpi++nym/a2OrwmNCsxL7uoKrvs9rJ6enA2sTqpuL//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////v73ZXvvAAAblUlEQVR42u3cZ1RVZ74GcFAR0WQmsSQmk5ieTDLJJJmZO+0uOHTOQYTDORTpIEXKoUqRHsUgCCggKBALWAC7EI1ERXBEReyCEKNGRUUs0dg18c69z/vuHpgP9+OG/SRG16z5kt96/v+zz35fYqREiRIlSpQoUaJEiRIlSpQoUaJEiZL/f8yem/LO+PFvWbz/7tgpn018brSpkZJBmf4wfvyYMYEOdeXvvzM+bvw7H0+ZNG60kRJpTMF0+/aZcMem8jq3M2eWLIlbsmRJ+FsfT3xOsRJn9JTxt8+MGeMWUlfdGDcmLpxNXFzcWx9PUayEOr1DmOIsmsrLvceMYZXm0PT09KBX48yMlKBOY26PgY83nNzHLAmPE5gCaXoC3/pMqZURU6cxc5zryuvmkLGTMrm5eXq64be/TBxrOqw/7CaNJ3Va4tlYV10XN2YgE5xoAt0mTBw9nMcOdYKTe1NddZPYKZBx8qRO7u7uFhae7qpPh22nxr2DOmGNO8KpcckYoU7iNkEJcXe0u/LB2OG6njB2S+DjTZywxhHJ1AlMiGX7/gsjjEZPmjJuuPXKdNL4M+S5cg4extGnuMHq5M47Gdr377/w6bg/hFtMmDhuWG2n56c8W716C/I/z3554Ig+9fRIP+wkUCEdF/bvv2J4K9zR2dtxwsRhM4NjX3ptw+off/jhxy1bVq9e/c0332zf/uxZHKwCB2wnxNHCOQNOF8pbeywCnJ0DHBzenzQ8PgGff23estU/ECcobV+2bMPixYWLF2/Y8OxZeGC3G4moTY6OFt7+LXCqbnRzcw5AQkIcnF99znQYOP3XvA3f/Mg6AYo4Fc5buXLljcLFG36ZE9jdzTPBCVFhQe1vrrMI9Gac/Pz8Gp0xf0PfabHEaQNxmjdv5cGNU6earyzc8AuowMQ7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"
                  data-src="404.png,404.png"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="skeleton-placeholder" style="min-height: 578px">
        <div class="advantagePage KJ0eMOoY">
          <div>
            <div class="_29gnuiyG _3Sj6nVcu">
              <div class="_35_vygsc">
                <h1 style="margin-top: -23px">服务优势</h1>
                <h2 style="font-size: 20px">SERVICE ADVANTAGES</h2>
              </div>
              <div class="_2zJiZW9W"></div>
            </div>
            <div class="B-6PNow1" style="padding: 0px 15px">
              <div class="_1a5O2riZ _2SwC5iLM lazyloaded" data-bg="/static/image/home_advantage_box-e6dd.png" style="background-image: url(/static/image/home_advantage_box-e6dd.png); background-size: 100%">
                <img
                  src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAARoAAAAqCAMAAABbYGSRAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAABgUExURUxpcbTA0rC3x6+3xq+2x7C5yK+2xq+3ydLS7LC4yq+3xq+2xrC3x7C2x7C3x6+3x6+2x6+3xrC5ya+3x7C4yLC3x7i6zbG4ya+3x7C3yK+3x6+2x6+2xrC3x7O5ya+2xiGqTo4AAAAfdFJOUwANqcvuN/xHBBzi9m/AVo3WtTOEQHkWLZVQnWfqYCbl/coXAAADnElEQVR42rWZ3ZKyOhBFGwIYEBAU8Q8n7/+W34VaW04d3d2VuG5ZE7e09HSIqKnv59EtxTZ8pHmaXSBUxXDdy5ND4DRGU8RRc9uMNy8JmLpAyR+q3wYFVY8bScmNpvgqaGhOEs2tCpz24e6DisFwI1ubKVIGHcsskdyDhv1DboOKreFG7mGaMnAOEsmg+q7+IedBRYEvoVu5tWfgOIljEzR0T7sxPVC5euU8ZQYUKI6r5bc5hyeVFwDqdcNsNCvbTHxGmOR/gbFN9DwNm2/UD/lCfqv9qmHW4cWFrKw38RlVJvI9xSIx4Hdw1ti7l737fr1cRQyDEGDqMzhqdIlaTa+xO2K7VcM8v+yrELgJHKpDjKvEgCm0Fo7ffrMxjHXriOEuBJiKDKyWWfU0bhJFhyGcUwbY367v1hHDH1mXm6CktZxexkkiQA1yjd0G2N+uXxCRtUOlCVpay+PTKLzEsMcQriCH/fX6vIoYRiFwE+S0liMWi6HFEM7B9FF+vd6sI4ajELgJGlrLIs0+IccQTrAPfAVmMwI1QU1r+fcyNhJFox0B7APfidxIwE3Qo5Zsu5xJBKjBIdXAh4LeXrarPzIbTT7OYeczpNpbVp9YhutkHfgQkZAbTRFHazmkGfjuQUXuTQMfIjJuRlN8xRrJjL9g8O6hDVYq5R0iMk4Wc5Vhpg/CSaLIiqBitLxdm9R3vfA2ExkGuvMpvMSx0d0bZ3i71qBfMjqjiQxXuvMZJZa5HZtK96tpLG9ksWPcFh85Gk1kuNOdz0GS4LMPFGgfUgcVziMie+aVJqjpNnSPgS8FfBbr1S3b1eiX7Jm3mhj4Cr7zyeSXYBarVS1hcfmjVj/bW+6omqNP/5QrOiv62+I/sYpIdowWEziqNujTP2XAKIqWMIqGBf/Kk5nIMNFmdJOfMr+/nilRXA62v1UWbYKSqr26pSealffv/W0y7UBcvAla9WFCIb9l9/4CIEfFAD8iOMebIFcfJozyWzqMouhvznaQ3seboFEfJhwlFXywrE1HeVl4UacykeH3hwn1hnDDYCnob3fTe6Ci/MjJaCIDp0lzOMeZ3we+v1Rrj0YTGThtkk7CGd7725Js7aPNRAbOkkV2EkMJYI/J1p70pjVxL1Hsg5IiUwx89rUrbzKRgXOWONqgY7tZ2VOqtZ3eNCY+e4kjVzaacmVXWaq1d3rTlLjpJZYmMIqhO5f/sV3k2uBiMXVutbjzxYuGf4PjM093FU/QAAAAAElFTkSuQmCC"
                  alt=""
                />
                <h1><span class="_1YRvcgEZ">60</span><span>秒</span></h1>
                <p>存款平均时间</p>
                <p>DEPOSIT SPEED</p>
              </div>
              <div class="_1a5O2riZ TwIdcvBW lazyloaded" data-bg="/static/image/home_advantage_box-e6dd.png" style="background-image: url(/static/image/home_advantage_box-e6dd.png); background-size: 100%">
                <img
                  src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAARoAAAAqCAMAAABbYGSRAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAABgUExURUxpcbTA0rC3x6+3xq+2x7C5yK+2xq+3ydLS7LC4yq+3xq+2xrC3x7C2x7C3x6+3x6+2x6+3xrC5ya+3x7C4yLC3x7i6zbG4ya+3x7C3yK+3x6+2x6+2xrC3x7O5ya+2xiGqTo4AAAAfdFJOUwANqcvuN/xHBBzi9m/AVo3WtTOEQHkWLZVQnWfqYCbl/coXAAADnElEQVR42rWZ3ZKyOhBFGwIYEBAU8Q8n7/+W34VaW04d3d2VuG5ZE7e09HSIqKnv59EtxTZ8pHmaXSBUxXDdy5ND4DRGU8RRc9uMNy8JmLpAyR+q3wYFVY8bScmNpvgqaGhOEs2tCpz24e6DisFwI1ubKVIGHcsskdyDhv1DboOKreFG7mGaMnAOEsmg+q7+IedBRYEvoVu5tWfgOIljEzR0T7sxPVC5euU8ZQYUKI6r5bc5hyeVFwDqdcNsNCvbTHxGmOR/gbFN9DwNm2/UD/lCfqv9qmHW4cWFrKw38RlVJvI9xSIx4Hdw1ti7l737fr1cRQyDEGDqMzhqdIlaTa+xO2K7VcM8v+yrELgJHKpDjKvEgCm0Fo7ffrMxjHXriOEuBJiKDKyWWfU0bhJFhyGcUwbY367v1hHDH1mXm6CktZxexkkiQA1yjd0G2N+uXxCRtUOlCVpay+PTKLzEsMcQriCH/fX6vIoYRiFwE+S0liMWi6HFEM7B9FF+vd6sI4ajELgJGlrLIs0+IccQTrAPfAVmMwI1QU1r+fcyNhJFox0B7APfidxIwE3Qo5Zsu5xJBKjBIdXAh4LeXrarPzIbTT7OYeczpNpbVp9YhutkHfgQkZAbTRFHazmkGfjuQUXuTQMfIjJuRlN8xRrJjL9g8O6hDVYq5R0iMk4Wc5Vhpg/CSaLIiqBitLxdm9R3vfA2ExkGuvMpvMSx0d0bZ3i71qBfMjqjiQxXuvMZJZa5HZtK96tpLG9ksWPcFh85Gk1kuNOdz0GS4LMPFGgfUgcVziMie+aVJqjpNnSPgS8FfBbr1S3b1eiX7Jm3mhj4Cr7zyeSXYBarVS1hcfmjVj/bW+6omqNP/5QrOiv62+I/sYpIdowWEziqNujTP2XAKIqWMIqGBf/Kk5nIMNFmdJOfMr+/nilRXA62v1UWbYKSqr26pSealffv/W0y7UBcvAla9WFCIb9l9/4CIEfFAD8iOMebIFcfJozyWzqMouhvznaQ3seboFEfJhwlFXywrE1HeVl4UacykeH3hwn1hnDDYCnob3fTe6Ci/MjJaCIDp0lzOMeZ3we+v1Rrj0YTGThtkk7CGd7725Js7aPNRAbOkkV2EkMJYI/J1p70pjVxL1Hsg5IiUwx89rUrbzKRgXOWONqgY7tZ2VOqtZ3eNCY+e4kjVzaacmVXWaq1d3rTlLjpJZYmMIqhO5f/sV3k2uBiMXVutbjzxYuGf4PjM093FU/QAAAAAElFTkSuQmCC"
                  alt=""
                />
                <h1><span class="_1YRvcgEZ">90</span><span>秒</span></h1>
                <p>取款平均时间</p>
                <p>WITHDRAWAL SPEED</p>
              </div>
              <div class="_1a5O2riZ _4sDo9RtW lazyloaded" data-bg="/static/image/home_advantage_box-e6dd.png" style="background-image: url(/static/image/home_advantage_box-e6dd.png); background-size: 100%">
                <img
                  src="data:image/png;base64,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"
                  alt=""
                />
                <h1><span class="_1YRvcgEZ">80</span><span>家</span></h1>
                <p>合作支付平台</p>
                <p>PAYMENT COOPERATION</p>
              </div>
              <div class="_1a5O2riZ _1cf_9o-U lazyloaded" data-bg="/static/image/home_advantage_box-e6dd.png" style="background-image: url(/static/image/home_advantage_box-e6dd.png); background-size: 100%">
                <img
                  src="data:image/png;base64,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"
                  alt=""
                />
                <h1><span class="_1YRvcgEZ">25</span><span>家</span></h1>
                <p>合作游戏平台</p>
                <p>PLATFORM COOPERATION</p>
              </div>
            </div>
            <div class="B-6PNow1">
              <div class="hdnLOoDP _2xCRM67j">
                <div class="_33NN0NSW">信誉资金托管</div>
                <div class="_2hih7WDp">MORE WAYS TO PROTECT</div>
                <div class="_2O8GBgtF">独立开发，128位加密技术和严格的安全管理体系，让客户资金得到最完善的保障。</div>
              </div>
              <div class="hdnLOoDP _1Qp455Ad">
                <div class="_33NN0NSW">90秒极速出款</div>
                <div class="_2hih7WDp">MORE WAYS TO WIN</div>
                <div class="_2O8GBgtF">最新技术自主研发的财务处理系统，极速存、取、转。独家网络优化技术，为您提供一流的游戏体验。</div>
              </div>
              <div class="hdnLOoDP _2jxpwUqK">
                <div class="_33NN0NSW">三端数据互通</div>
                <div class="_2hih7WDp">MORE DEVICES ACCOUNT</div>
                <div class="_2O8GBgtF">支持各种终端设备，完美兼容PC、移动端。原生态App让您随时随地轻松投注。</div>
              </div>
              <div class="hdnLOoDP _12RnAAxb">
                <div class="_33NN0NSW">赛事覆盖全面</div>
                <div class="_2hih7WDp">MORE EVENTS TO PLAY</div>
                <div class="_2O8GBgtF">每天提供超过500场不同类别的精彩赛事，涵盖世界范围内主要体育运动，让客户拥有最完美的游戏体验。</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- 公告展示 -->
    <div class="office-modal-container" v-if="gaoShow">
      <div class="_1euN-aP1">
        <div class="_2v39xVwk animated animated-3 fadeIn"></div>
        <div class="_3Pc_iCss animated animated-3 zoomIn" style="width: 717px">
          <div class="_3DZ99c6r">
            <span></span>
            <div class="_3x7x8GsG">最新公告</div>
            <img
              @click="changGshow"
              class="_8iC2lrZe"
              src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAMAAACdt4HsAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAC0UExURUxpcf/////Uqv+2tv//qv///+u3o/////W8qv/Gxv/9/emwoOWunO+zouiyovC0peexneeyn+qxouWvnOWvneWwnOWunOWvnee5ouWxneaxoeSunOSunOWxpOSvneSvnPC4m+SvneWwn+SwnfXf1+avnPTe1fvw7eSunOewnuSum+mynuSunPXg2vLVzeSum//9/eSunOSunPPa0uStnfbm3/HWzfjr5vnh1vzz8f359////2ASjEAAAAA7dFJOUwD9BgcDAg0BCQT9G0cPFREkHxg6Pi5RYAsoNkxaE1VkEkIdMJAzlWpoK4AidYm6jPSWbZ9xf651HmONntaUtAAABAdJREFUeNrtlsly4kgQhgdJCMlaKe37ZmFAYDDgrXn/95qsqqRlRxSaufSlw3khQsn/qZSV2z8/9mN/ny3QJn0TNp/PFTD4wT9+UY+++6+fK7ougem6rgDim1xBH7iUxR29okuypsVxrGmyRBFf9Lp+c2ngEhPmuqTFquXUzoetavJIWABaRpdlf1CXUK/ommoVNjF+XY+flqoxAupBXoPHIJ/H6y84w1wUAF2OrYK0Q3q9XmeftapJQEC96thGO7ju0wycH5oODgFAUwuydDfpkRKeCk5YsJPVpHWTIHin+iMBhwCgSJplt27Qe6+zLwTUD0mXouPTiWUxIHbIsOm9xtyPBLg70BvsOYKNQpV1MaA23MBrsjBEgm1pYGoB+tRH7HvS3gc4FGCGZZ4/IsFRVQv0Qdpk+wf66LVnAEUcRIsMFJDn0Y1AbBvCR/WPTL/3O9eoVekOQLWXG/hvHkVVhIRhCeHzUP+wN71gIJbwFiARZfhat/PNMq+qG+E96ODzQ65/zJo0aW1VmAcQBPoN7AhlVK2raMUIr36T3fQhOwC9RSGAHqE2eBSAsK5W/LPDcsX0q9CkEYDLFVYTpix8BCeswVCIP6Xp9/ABFqa46AhI6CihWp8ulzOToj4D/ZLqMQJCgnQjlNH6sttt32gcvutlpp8i2G3S+1leXXbbw4ETHs552KSbJZnWI8Gi2WCG0QX0L88zPADPgBj1kwSoKciGMDptUc+uEDIALkCgFyYk3GWWA4DpZzwfepen4P8CLDngjUmfOeYdAGMGTAeBDJ2fRSfUvxzeHhjBqAUhECZTm6RNGJ1R/3LYnhnhSZRE4mSEA0D+4vsP2+3uRsBOO6nHcuD6ty213YVl9dhp/0ufNlh/5x2zy+lUrWZTBAwg77+0oFFfVdBboDBP6/Wtw/BiBIJ4sjhf9au8DMFKXtwjAfuJqKFgHaC+DM3G9xszo4iRgB1N1NJ4Xzf3qM8aL+263vNpfxi73CceQZyCkAHlEfV+GiSu6256JET5HkcbACbaeoT9z+83g0GIsYS2TAlRlPOJ8xFLyuRgeb4emT5ZksKyahiYQIBA5HlovsJ4x8EyMdqiMuN6R4W1xLIhNdnEC+Fxmk6NNsKGIFjjdbR/QfHoMu+0/LnvBe794UrHAp3ivu+lgduy/ge7Fe+Tmx6e+ynEhdT3ZiObw0nQ9V2QDAb2T94n0dEHGwYWz0a+yCzdJHGHlhSox05Ldx/01CyZxUsaEIjRtgaBuY79H9C4fhHDoB7QA1lUTAqNl+UURVFbaoz63wRw1dxFI7O4t2jCralg2rgmIuGba2JVhV2VmqSjflxV0QeuqcY6ZysxW6m/l/yCIm6+xfS6jyZyoefH/oD9C6i3ptIfvSpmAAAAAElFTkSuQmCC"
              alt=""
            />
          </div>
          <ul class="_1Gbns6cE">
            <li v-for="(item, index) in homenoticelis" :key="index">
              <!-- <p><span>高登棋牌场馆临时维护公告</span><span>(2022-05-11 17:59:39)</span></p> -->
              <p><span></span><span></span></p>
              <p>{{ item }}</p>
            </li>
          </ul>
          <div class="Qe8HWKXx">
            <div class="_349CzCYy xJQe3jRu _2ihhyR4S" @click="changGshow">
              <span><div>我已了解</div></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: 'index',
  data() {
    return {
      bannerList: [],
      homenoticedeatil: [],
      dogameLis: [],
      homenoticelis: [],
      gaoShow: false,
      scrolling: null,
      jumpUrl: null,
      hongbashow: true,
      tanshow: true,

    };
  },
  created() {
    let that = this;

    that.getInit();
  },
  methods: {
        changtanshow() {
      this.tanshow = !this.tanshow;
    },
    changhongbashow() {
      this.hongbashow = false;
    },
    goGamePage(name, type, code) {
      let that = this;
      let token = sessionStorage.getItem('token') ? sessionStorage.getItem('token') : '';
      if (!token) {
        that.$parent.openShow();
        return;
      }
      that.showTost('跳转前往中...');
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
    getInit() {
      let that = this;
      that.getBanList(); //获取轮播
      // that.getdogame(); //获取游戏名称
      that.homenotice(); //获取公告
    },
    getBanList() {
      let that = this;
      // 模拟真实数据
      that.bannerList = [
        { src: 'https://p3static.qwevo7g2g.com/images/new_public/web/bg/fd/cs/d4lvso06h9rghgf7eo4g_258196.jpg' },
        { src: 'https://p3static.qwevo7g2g.com/images/new_public/web/bg/fd/cs/d4865hgi2sccru47d730_207494.png' }
      ];
      // 如果需要保留API调用，可以注释掉下面这行，或者在API失败时使用默认值
      /*
      that.$apiFun.post('/api/bannerList', { type: 1 }).then(res => {
        console.log(res);
        if (res.code != 200) {
          that.showTost(res.message);
        }
        if (res.code == 200) {
          that.bannerList = res.data;
        }
      });
      */
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
        }
      });
    },
    homenotice() {
      let that = this;
      // 模拟真实数据
      that.homenoticelis = [
        "九游娱乐杜绝洗钱 (非法/不良资金) 行为。我司将严厉打击洗钱资金，一经发现洗钱资金一律冻结处理。",
        "为了您的资金以及隐私安全，请您尽快卸载【国家反诈中心】App！若您被该App监控到支付流水，会导致您的银行卡或支付宝等被冻结！",
        "尊敬的客户：我司双赢彩票场馆于2025年12月17日（星期三）06:00-07:10进行系统维护，维护期间场馆将无法转账及游戏，请维护前将场馆内的余额转出，给您带来不便，我们深感抱歉，谢谢。"
      ];
      /*
      that.$apiFun.post('/api/homenotice', {}).then(res => {
        console.log(res);
        if (res.code != 200) {
          that.showTost(res.message);
        }
        if (res.code == 200) {
          that.homenoticelis = res.data;
          //公告滚动
        }
      });
      */
    },
    getHomenoticedeatil() {
      let that = this;
      that.$apiFun.post('/api/homenoticedeatil', {}).then(res => {
        console.log(res);
        if (res.code != 200) {
          that.showTost(res.message);
        }
        if (res.code == 200) {
          that.homenoticedeatil = res.data;
        }
      });
    },
    changGshow() {
      this.gaoShow = !this.gaoShow;
    },
    openKefu() {
      let that = this;
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
    goNav(url) {
      let that = this;

      if (url == '/userredpacket') {
        if (!that.$store.state.token) {
          that.$parent.showTost('请登录！');

          return;
        }

        let routerData = this.$router.resolve({
          path: `/userredpacket`,
        });
        window.open(routerData.href, '_blank');

        return;
      }
      if (url == this.$route.fullPath) {
        that.$parent.showTost('您就在当前页');
        return;
      }
      this.url = url;
      this.$router.push({ path: url });
    },
  },
  mounted() {
    let that = this;
    //场馆切换
    $('.venueBettingPage ._2zJiZW9W ._349CzCYy').click(function () {
      var index = $(this).index();
      $(this).addClass('_12ZkQT2g').siblings().removeClass('_12ZkQT2g');
      $('.venueBettingPage ._3UXr8okJ').eq(index).show().siblings('.venueBettingPage ._3UXr8okJ').hide();
      $('.venueBettingPage ._3UXr8okJ').eq(index).find('.urkqVk0T').addClass('animated fadeInLeft');
    });

    $('#clientPage ._2zJiZW9W ._349CzCYy').click(function () {
      var index = $(this).index();
      $(this).addClass('_12ZkQT2g').siblings().removeClass('_12ZkQT2g');
      $('#clientPage .clientPage').eq(index).show().siblings('#clientPage .clientPage').hide();
      $('#clientPage .clientPage').eq(index).find('._2EhulCr4').addClass('animated fadeInLeft');
      $('#clientPage .clientPage').eq(index).find('._21tMkZGL').addClass('animated fadeInRight');
    });
    jQuery.fn.extend({
      pic_scroll: function () {
        $(this).each(function () {
          var _this = $(this); //存储对象
          var ul = _this.find('._16eN5goK'); //获取ul对象
          var li = ul.find('a'); //获取所有图片所有的li
          var w = li.size() * li.outerWidth(); //统计图片的长度
          li.clone().prependTo(ul); //克隆图片一份放入ul里
          ul.width(2 * w); //设置ul的长度，使所有图片排成一排
          var i = 1,
            l;
          _this.hover(
            function () {
              i = 0;
            },
            function () {
              i = 1;
            },
          ); //鼠标经过时设置i=0达到鼠标经过停止效果
          function autoScroll() {
            l = _this.scrollLeft();
            if (l >= w) {
              _this.scrollLeft(0);
            } else {
              _this.scrollLeft(l + i);
            }
          }
          if (that.scrolling == null) {
            that.scrolling = setInterval(() => {
              autoScroll();
            }, 20);
          }
        });
      },
    });
  },
  updated() {
    let that = this;
    // 轮播图 轮播指示图
    var swiper = new Swiper('.slick-slider', {
      loop: true,
      speed: 800,
      effect: 'fade',
      autoplay: {
        delay: 2500,
        disableOnInteraction: false,
      },
      navigation: {
        nextEl: '.WBPgrnx-',
        prevEl: '._3NjvkxEd',
      },
      thumbs: {
        swiper: {
          el: '._1rdiSS19',
          spaceBetween: 0,
          slidesPerView: that.bannerList.length,
          watchSlidesVisibility: true,
          /*避免出现bug*/
        },
        slideThumbActiveClass: '_18z76Yss',
      },
    });
    // 公告开始滚动
    if (that.homenoticelis.length > 0) {
      $('._20-URCGF').pic_scroll();
    }
  },
  beforeDestroy() {
    let that = this;
    clearInterval(that.scrolling);
    that.scrolling = null;
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
