<template>
  <div>
    <div class="ant-spin-nested-loading">
      <div class="loading" v-if="lodingShow">
        <div class="ant-spin ant-spin-spinning _2PSsJSST">
          <span class="ant-spin-dot ant-spin-dot-spin"><i class="ant-spin-dot-item"></i><i class="ant-spin-dot-item"></i><i class="ant-spin-dot-item"></i><i class="ant-spin-dot-item"></i></span>
        </div>
      </div>
      <div :class="lodingShow ? 'ant-spin-container ant-spin-blur' : 'ant-spin-container'">
        <div class="_2hXp1MkX" style="height: auto; min-height: auto; padding-bottom: 0">
          <div class="_4ICMeQUV" style="border-bottom: none">
            <div class="T5pPAuRQ">卡片管理</div>
            <!-- <a class="xAmazytl" target="_self" href="javascript:;">取款教程</a> -->
          </div>

          <div class="ant-tabs ant-tabs-top CxUrt0Fb _3J-cD19q ant-tabs-line">
            <div role="tablist" tabindex="-1" class="ant-tabs-bar ant-tabs-top-bar">
              <div class="ant-tabs-nav-container">
                <span unselectable="unselectable" class="ant-tabs-tab-prev ant-tabs-tab-btn-disabled"
                  ><span class="ant-tabs-tab-prev-icon"
                    ><span role="img" aria-label="left" class="anticon anticon-left ant-tabs-tab-prev-icon-target">
                      <svg viewbox="64 64 896 896" focusable="false" data-icon="left" width="1em" height="1em" fill="currentColor" aria-hidden="true">
                        <path d="M724 218.3V141c0-6.7-7.7-10.4-12.9-6.3L260.3 486.8a31.86 31.86 0 000 50.3l450.8 352.1c5.3 4.1 12.9.4 12.9-6.3v-77.3c0-4.9-2.3-9.6-6.1-12.6l-360-281 360-281.1c3.8-3 6.1-7.7 6.1-12.6z"></path>
                      </svg> </span></span></span
                ><span unselectable="unselectable" class="ant-tabs-tab-next ant-tabs-tab-btn-disabled"
                  ><span class="ant-tabs-tab-next-icon"
                    ><span role="img" aria-label="right" class="anticon anticon-right ant-tabs-tab-next-icon-target">
                      <svg viewbox="64 64 896 896" focusable="false" data-icon="right" width="1em" height="1em" fill="currentColor" aria-hidden="true">
                        <path d="M765.7 486.8L314.9 134.7A7.97 7.97 0 00302 141v77.3c0 4.9 2.3 9.6 6.1 12.6l360 281.1-360 281.1c-3.9 3-6.1 7.7-6.1 12.6V883c0 6.7 7.7 10.4 12.9 6.3l450.8-352.1a31.96 31.96 0 000-50.4z"></path>
                      </svg> </span></span
                ></span>
                <div class="ant-tabs-nav-wrap">
                  <div class="ant-tabs-nav-scroll">
                    <div class="ant-tabs-nav ant-tabs-nav-animated">
                      <div>
                        <div role="tab" @click="changType(0)" aria-disabled="false" aria-selected="true" tabindex="0" :class="type == 0 ? 'ant-tabs-tab-active ant-tabs-tab' : ' ant-tabs-tab'" id="tab-0" aria-controls="tabpane-0">
                          <div class="_2CqeV2cs">银行卡管理</div>
                        </div>
                        <div role="tab" @click="changType(1)" aria-disabled="false" aria-selected="false" tabindex="-1" :class="type == 1 ? 'ant-tabs-tab-active ant-tabs-tab' : ' ant-tabs-tab'" id="tab-1" aria-controls="tabpane-1">
                          <div class="_2CqeV2cs">USDT管理 <img src="/static/image/f7e370f156029035d421b94fc86edd92.png" alt="" /></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="_25v_mA9X" v-if="type == 0">
          <div class="_3EZH4oNG" v-if="cardLis.length > 0">
            <div class="_1lgxzaTd vgY3MnTO" v-for="(item, index) in cardLis" :key="index">
              <div class="_2nk86HnM">
                <div class="_1YeYP-8D">
                  <div class="_2jKHJAb6">
                    <div class="_3zJ5EeYL _2i6zOyWR">
                      <img :src="item.ico" alt="" />
                    </div>
                    <div class="_1lfcA5kI">{{ item.bank }}</div>
                  </div>
                </div>
                <div class="_2kHgqbKY">
                  <!-- <div class="_2LongFGR">
                    <img
                      src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACQAAAAkCAMAAADW3miqAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAADzUExURUxpcRISEgAAAAQEBAwMDAEBAf39/SUlJQAAAKSkpP///wsLC7m5uQEBAQICAtHR0Q0NDezs7BcXFwEBAfLy8gQEBAEBAQICAgICAigoKAEBAQEBAf///wAAAAICAvr6+ry8vAEBAQAAAP39/QICAv////f39/39/ff39wAAAAQEBAAAANTU1EhISAAAAAAAAKqqqgICAqOjo/39/cnJyf39/f////Dw8AQEBOHh4f///5mZmaysrKysrDo6OrGxsfT09Onp6cDAwNnZ2b+/v/z8/Hp6ere3t5eXl4GBgdHR0SUlJf////T09N7e3klJSf////gW6UkAAABQdFJOUwAEWw0MNoEBXZbfBrA3G8QJ4AJB6x1GPSNnSlOAVyZhrjMRoRTw5tExYhggYHEoHjAsfZG2UBFVO9ign6aOShfHnZS6QMGFWWw/nHUgpslvMGEYUgAAAWtJREFUeNqF0olygjAUBdCAaLARC1FQoVSlWkVb3Lvv+973/1/TBFNrGSKXGSYZDpcHA5KkADsoI7gAwFSmsZjKMtthabPiRvf9llBSo1YmhidXODa1sjbI867mJkMwGdT8OUBfYvSKTdialK8sgLGSZk51Z2jGu+sewOWQJFETwGo4dRPHdzBz7o4SCAujUb6jewAXXjug6T0rU/LaHSXNiB4kM9k9C27cdeMbSdPvQrXhRtryvc6YUU8GKebQjXLLeWbM8K++yRSEwf8MfVwzON1gDeApwyD6AMAM/n1WS63ZSYOUA7DygejhpjIykwaZt3C/S1Z/ZapB2g3c2ZT3yA0KuvDSoehjMZMbOgZ4++x1ASRGzC1SLckMIs/s8te8+K2Gvswgc9J4D0Nd9T3XsJlJR69WlWWfZyuR3tHfTPIcUzHTaFqUZVomAtUdVU+P6gwFUjpRnsXgh1jEJ3ZuR4GChDJzspix+QEDxlJKw5WccQAAAABJRU5ErkJggg=="
                      alt=""
                    />
                  </div> -->
                </div>
              </div>
              <div class="J5X-nZnR">{{ item.bank_no }}</div>
              <div class="_2hLYjBpM">
                <div class="_1GrKjNGn _3BJNJEUQ" @click="delShow(item.id, item.bank_no)">解绑</div>
                <!-- <div class="_1GrKjNGn">禁用</div> -->
              </div>
            </div>
            <div class="_2EJsOuqN" @click="changAddShow">
              <span role="img" aria-label="plus" class="anticon anticon-plus"
                ><svg viewBox="64 64 896 896" focusable="false" data-icon="plus" width="1em" height="1em" fill="currentColor" aria-hidden="true">
                  <path d="M482 152h60q8 0 8 8v704q0 8-8 8h-60q-8 0-8-8V160q0-8 8-8z"></path>
                  <path d="M176 474h672q8 0 8 8v60q0 8-8 8H176q-8 0-8-8v-60q0-8 8-8z"></path></svg
              ></span>
              <p>
                <span class="B1Y9hxs9"
                  >绑定银行卡<span class="_2QjkbEbY">可绑定银行卡({{ 5 - cardLis.length }}/5)</span></span
                >
              </p>
            </div>
          </div>

          <div class="_21o37iEs" v-if="cardLis.length == 0">
            <img src="/static/image/ill_norecord_day-b111.png" alt="" />
            <div class="HzjbFc_d">您还没绑定银行卡，为了您的资金安全，绑定银行卡时，需要填写您的个人信息</div>
            <div class="_349CzCYy xJQe3jRu" style="width: 150px" @click="changAddShow"><span>去绑定</span></div>
          </div>
        </div>
        <div class="_25v_mA9X" v-if="type == 1">
          <div class="_3EZH4oNG" v-if="usdssLis.length > 0">
            <div class="_1lgxzaTd vgY3MnTO" v-for="(item, index) in usdssLis" :key="index">
              <div class="_2nk86HnM">
                <div class="_1YeYP-8D">
                  <div class="_2jKHJAb6">
                    <div class="_3zJ5EeYL _2i6zOyWR">
                      <img src="/static/image/ic_deposit_xunihb.png" alt="" />
                    </div>
                    <div class="_1lfcA5kI">
                      {{ item.bank }}
                      <br />
                      钱包协议：{{ item.bank_owner }}
                    </div>
                  </div>
                </div>
                <div class="_2kHgqbKY">
                  <!-- <div class="_2LongFGR">
                    <img
                      src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACQAAAAkCAMAAADW3miqAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAADzUExURUxpcRISEgAAAAQEBAwMDAEBAf39/SUlJQAAAKSkpP///wsLC7m5uQEBAQICAtHR0Q0NDezs7BcXFwEBAfLy8gQEBAEBAQICAgICAigoKAEBAQEBAf///wAAAAICAvr6+ry8vAEBAQAAAP39/QICAv////f39/39/ff39wAAAAQEBAAAANTU1EhISAAAAAAAAKqqqgICAqOjo/39/cnJyf39/f////Dw8AQEBOHh4f///5mZmaysrKysrDo6OrGxsfT09Onp6cDAwNnZ2b+/v/z8/Hp6ere3t5eXl4GBgdHR0SUlJf////T09N7e3klJSf////gW6UkAAABQdFJOUwAEWw0MNoEBXZbfBrA3G8QJ4AJB6x1GPSNnSlOAVyZhrjMRoRTw5tExYhggYHEoHjAsfZG2UBFVO9ign6aOShfHnZS6QMGFWWw/nHUgpslvMGEYUgAAAWtJREFUeNqF0olygjAUBdCAaLARC1FQoVSlWkVb3Lvv+973/1/TBFNrGSKXGSYZDpcHA5KkADsoI7gAwFSmsZjKMtthabPiRvf9llBSo1YmhidXODa1sjbI867mJkMwGdT8OUBfYvSKTdialK8sgLGSZk51Z2jGu+sewOWQJFETwGo4dRPHdzBz7o4SCAujUb6jewAXXjug6T0rU/LaHSXNiB4kM9k9C27cdeMbSdPvQrXhRtryvc6YUU8GKebQjXLLeWbM8K++yRSEwf8MfVwzON1gDeApwyD6AMAM/n1WS63ZSYOUA7DygejhpjIykwaZt3C/S1Z/ZapB2g3c2ZT3yA0KuvDSoehjMZMbOgZ4++x1ASRGzC1SLckMIs/s8te8+K2Gvswgc9J4D0Nd9T3XsJlJR69WlWWfZyuR3tHfTPIcUzHTaFqUZVomAtUdVU+P6gwFUjpRnsXgh1jEJ3ZuR4GChDJzspix+QEDxlJKw5WccQAAAABJRU5ErkJggg=="
                      alt=""
                    />
                  </div> -->
                </div>
              </div>
              <div class="J5X-nZnR">{{ item.bank_no }}</div>
              <div class="_2hLYjBpM">
                <div class="_1GrKjNGn _3BJNJEUQ" @click="delShow(item.id, item.bank_no)">解绑</div>
                <!-- <div class="_1GrKjNGn">禁用</div> -->
              </div>
            </div>
            <div class="_2EJsOuqN" @click="addShow1 = true">
              <span role="img" aria-label="plus" class="anticon anticon-plus"
                ><svg viewBox="64 64 896 896" focusable="false" data-icon="plus" width="1em" height="1em" fill="currentColor" aria-hidden="true">
                  <path d="M482 152h60q8 0 8 8v704q0 8-8 8h-60q-8 0-8-8V160q0-8 8-8z"></path>
                  <path d="M176 474h672q8 0 8 8v60q0 8-8 8H176q-8 0-8-8v-60q0-8 8-8z"></path></svg
              ></span>
              <p>
                <span class="B1Y9hxs9"
                  >绑定USDT<span class="_2QjkbEbY">可绑定USDT({{ 5 - usdssLis.length }}/5)</span></span
                >
              </p>
            </div>
          </div>

          <div class="_21o37iEs" v-if="cardLis.length == 0">
            <img src="/static/image/ill_norecord_day-b111.png" alt="" />
            <div class="HzjbFc_d">您还没绑定USDT，为了您的资金安全，绑定USDT时</div>
            <div class="_349CzCYy xJQe3jRu" style="width: 150px" @click="addShow1 = true"><span>去绑定</span></div>
          </div>
        </div>
        <div class="_1euN-aP1" v-if="addShow">
          <div class="_2v39xVwk animated animated-3 fadeIn"></div>
          <div class="_3Pc_iCss animated animated-3 zoomIn" style="width: 700px">
            <div class="_3DZ99c6r">
              <span></span>
              <div class="_3x7x8GsG">绑定银行卡</div>
              <img
                @click="addShow = false"
                class="_8iC2lrZe"
                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAMAAACdt4HsAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAC0UExURUxpcf/////Uqv+2tv//qv///+u3o/////W8qv/Gxv/9/emwoOWunO+zouiyovC0peexneeyn+qxouWvnOWvneWwnOWunOWvnee5ouWxneaxoeSunOSunOWxpOSvneSvnPC4m+SvneWwn+SwnfXf1+avnPTe1fvw7eSunOewnuSum+mynuSunPXg2vLVzeSum//9/eSunOSunPPa0uStnfbm3/HWzfjr5vnh1vzz8f359////2ASjEAAAAA7dFJOUwD9BgcDAg0BCQT9G0cPFREkHxg6Pi5RYAsoNkxaE1VkEkIdMJAzlWpoK4AidYm6jPSWbZ9xf651HmONntaUtAAABAdJREFUeNrtlsly4kgQhgdJCMlaKe37ZmFAYDDgrXn/95qsqqRlRxSaufSlw3khQsn/qZSV2z8/9mN/ny3QJn0TNp/PFTD4wT9+UY+++6+fK7ougem6rgDim1xBH7iUxR29okuypsVxrGmyRBFf9Lp+c2ngEhPmuqTFquXUzoetavJIWABaRpdlf1CXUK/ommoVNjF+XY+flqoxAupBXoPHIJ/H6y84w1wUAF2OrYK0Q3q9XmeftapJQEC96thGO7ju0wycH5oODgFAUwuydDfpkRKeCk5YsJPVpHWTIHin+iMBhwCgSJplt27Qe6+zLwTUD0mXouPTiWUxIHbIsOm9xtyPBLg70BvsOYKNQpV1MaA23MBrsjBEgm1pYGoB+tRH7HvS3gc4FGCGZZ4/IsFRVQv0Qdpk+wf66LVnAEUcRIsMFJDn0Y1AbBvCR/WPTL/3O9eoVekOQLWXG/hvHkVVhIRhCeHzUP+wN71gIJbwFiARZfhat/PNMq+qG+E96ODzQ65/zJo0aW1VmAcQBPoN7AhlVK2raMUIr36T3fQhOwC9RSGAHqE2eBSAsK5W/LPDcsX0q9CkEYDLFVYTpix8BCeswVCIP6Xp9/ABFqa46AhI6CihWp8ulzOToj4D/ZLqMQJCgnQjlNH6sttt32gcvutlpp8i2G3S+1leXXbbw4ETHs552KSbJZnWI8Gi2WCG0QX0L88zPADPgBj1kwSoKciGMDptUc+uEDIALkCgFyYk3GWWA4DpZzwfepen4P8CLDngjUmfOeYdAGMGTAeBDJ2fRSfUvxzeHhjBqAUhECZTm6RNGJ1R/3LYnhnhSZRE4mSEA0D+4vsP2+3uRsBOO6nHcuD6ty213YVl9dhp/0ufNlh/5x2zy+lUrWZTBAwg77+0oFFfVdBboDBP6/Wtw/BiBIJ4sjhf9au8DMFKXtwjAfuJqKFgHaC+DM3G9xszo4iRgB1N1NJ4Xzf3qM8aL+263vNpfxi73CceQZyCkAHlEfV+GiSu6256JET5HkcbACbaeoT9z+83g0GIsYS2TAlRlPOJ8xFLyuRgeb4emT5ZksKyahiYQIBA5HlovsJ4x8EyMdqiMuN6R4W1xLIhNdnEC+Fxmk6NNsKGIFjjdbR/QfHoMu+0/LnvBe794UrHAp3ivu+lgduy/ge7Fe+Tmx6e+ynEhdT3ZiObw0nQ9V2QDAb2T94n0dEHGwYWz0a+yCzdJHGHlhSox05Ldx/01CyZxUsaEIjRtgaBuY79H9C4fhHDoB7QA1lUTAqNl+UURVFbaoz63wRw1dxFI7O4t2jCralg2rgmIuGba2JVhV2VmqSjflxV0QeuqcY6ZysxW6m/l/yCIm6+xfS6jyZyoefH/oD9C6i3ptIfvSpmAAAAAElFTkSuQmCC"
                alt=""
              />
            </div>
            <div class="n8VMb-cz">
              <div class="ant-spin-nested-loading">
                <div class="ant-spin-container">
                  <form class="ant-form ant-form-horizontal">
                    <div class="_1pDMxc1H iLNFmffG">
                      <div class="ant-row ant-form-item">
                        <div class="ant-col ant-form-item-label">
                          <label for="real_name" class="" title="姓名">姓名</label>
                        </div>
                        <div class="ant-col ant-form-item-control">
                          <div class="ant-form-item-control-input">
                            <div class="ant-form-item-control-input-content">
                              <input autocomplete="off" class="ant-input _3ON7kyGT" type="text" placeholder="请输入姓名" id="real_name" v-model="cardInfo.bank_owner" style="width: 220px" />
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="_3RKaxxFo">为了您的资金能迅速到账，请确保填写的姓名和银行卡的开户姓名一致；目前仅支持中文、英文和“·”</div>
                    </div>
                    <div class="_1pDMxc1H iLNFmffG">
                      <div class="ant-row ant-form-item">
                        <div class="ant-col ant-form-item-label">
                          <label for="bank_name" class="" title="银行类型">银行类型</label>
                        </div>
                        <div class="ant-col ant-form-item-control">
                          <div class="ant-form-item-control-input">
                            <div class="ant-form-item-control-input-content">
                              <div class="ant-select _32SoV0oI ant-select-single ant-select-show-arrow ant-select-show-search" style="width: 220px; position: relative">
                                <div class="ant-select-selector">
                                  <span class="ant-select-selection-search">
                                    <input
                                      id="bank_name"
                                      autocomplete="off"
                                      class="ant-select-selection-search-input"
                                      role="combobox"
                                      aria-haspopup="listbox"
                                      aria-owns="bank_name_list"
                                      aria-autocomplete="list"
                                      aria-controls="bank_name_list"
                                      aria-activedescendant="bank_name_list_0"
                                      readonly=""
                                      unselectable="on"
                                      value=""
                                      style="opacity: 0"
                                    /> </span
                                  ><span class="ant-select-selection-placeholder">请选择银行类型</span>
                                </div>
                                <span class="ant-select-arrow" unselectable="on" aria-hidden="true" style="user-select: none"
                                  ><span role="img" aria-label="down" class="anticon anticon-down">
                                    <svg viewBox="64 64 896 896" focusable="false" data-icon="down" width="1em" height="1em" fill="currentColor" aria-hidden="true">
                                      <path d="M884 256h-75c-5.1 0-9.9 2.5-12.9 6.6L512 654.2 227.9 262.6c-3-4.1-7.8-6.6-12.9-6.6h-75c-6.5 0-10.3 7.4-6.5 12.7l352.6 486.1c12.8 17.6 39 17.6 51.7 0l352.6-486.1c3.9-5.3.1-12.7-6.4-12.7z"></path>
                                    </svg> </span
                                ></span>
                                <div class="ant-select-dropdown ant-select-dropdown-placement-bottomLeft ant-select-dropdown-hidden" style="min-width: 220px; width: 220px; left: 0; top: 42px">
                                  <div>
                                    <div class="" style="max-height: 256px; overflow-y: auto; overflow-anchor: none">
                                      <div>
                                        <div class="list" style="display: flex; flex-direction: column">
                                          <!-- ant-select-item-option-active -->
                                          <div class="ant-select-item ant-select-item-option" v-for="(item, index) in banklist" :key="index">
                                            <div class="ant-select-item-option-content">{{ item.bank_name }}</div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="_1pDMxc1H iLNFmffG">
                      <div class="ant-row ant-form-item">
                        <div class="ant-col ant-form-item-label">
                          <label for="bank_name" class="" title="开户行">开户行</label>
                        </div>
                        <div class="ant-col ant-form-item-control">
                          <div class="ant-form-item-control-input">
                            <div class="ant-form-item-control-input-content">
                              <input autocomplete="off" class="ant-input _3ON7kyGT" type="text" placeholder="请输入开户行" id="real_name" v-model="cardInfo.bank_address" style="width: 220px" />
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="_1pDMxc1H iLNFmffG">
                      <div class="ant-row ant-form-item">
                        <div class="ant-col ant-form-item-label">
                          <label for="bank_card" class="" title="卡号">卡号</label>
                        </div>
                        <div class="ant-col ant-form-item-control">
                          <div class="ant-form-item-control-input">
                            <div class="ant-form-item-control-input-content">
                              <input autocomplete="off" class="ant-input _3ON7kyGT" type="text" placeholder="请输入银行卡号" id="bank_card" v-model="cardInfo.bank_no" style="width: 220px" />
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="_1pDMxc1H iLNFmffG">
                      <div class="ant-row ant-form-item">
                        <div class="ant-col ant-form-item-label">
                          <label for="bank_card" class="" title="支付密码">支付密码</label>
                        </div>
                        <div class="ant-col ant-form-item-control">
                          <div class="ant-form-item-control-input">
                            <div class="ant-form-item-control-input-content">
                              <input autocomplete="new-password" class="ant-input _3ON7kyGT" type="password" placeholder="请输入支付密码" id="bank_card"  v-model="cardInfo.pay_pass" style="width: 220px" />
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="_1QgODINo">请认真校对银行卡号，卡号错误将导致资金无法到账。经过云加密的银行卡系统，全面保障您的用卡安全</div>
                    <div class="_1pDMxc1H">
                      <div class="ant-row ant-form-item">
                        <div class="ant-col ant-form-item-control">
                          <div class="ant-form-item-control-input">
                            <div class="ant-form-item-control-input-content">
                              <div class="_349CzCYy xJQe3jRu _3jxa2p2I" @click="bindCard"><span>绑定银行卡</span></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="_1euN-aP1" v-if="addShow1">
          <div class="_2v39xVwk animated animated-3 fadeIn"></div>
          <div class="_3Pc_iCss animated animated-3 zoomIn" style="width: 700px">
            <div class="_3DZ99c6r">
              <span></span>
              <div class="_3x7x8GsG">绑定USDT地址</div>
              <img
                @click="addShow1 = false"
                class="_8iC2lrZe"
                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAMAAACdt4HsAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAC0UExURUxpcf/////Uqv+2tv//qv///+u3o/////W8qv/Gxv/9/emwoOWunO+zouiyovC0peexneeyn+qxouWvnOWvneWwnOWunOWvnee5ouWxneaxoeSunOSunOWxpOSvneSvnPC4m+SvneWwn+SwnfXf1+avnPTe1fvw7eSunOewnuSum+mynuSunPXg2vLVzeSum//9/eSunOSunPPa0uStnfbm3/HWzfjr5vnh1vzz8f359////2ASjEAAAAA7dFJOUwD9BgcDAg0BCQT9G0cPFREkHxg6Pi5RYAsoNkxaE1VkEkIdMJAzlWpoK4AidYm6jPSWbZ9xf651HmONntaUtAAABAdJREFUeNrtlsly4kgQhgdJCMlaKe37ZmFAYDDgrXn/95qsqqRlRxSaufSlw3khQsn/qZSV2z8/9mN/ny3QJn0TNp/PFTD4wT9+UY+++6+fK7ougem6rgDim1xBH7iUxR29okuypsVxrGmyRBFf9Lp+c2ngEhPmuqTFquXUzoetavJIWABaRpdlf1CXUK/ommoVNjF+XY+flqoxAupBXoPHIJ/H6y84w1wUAF2OrYK0Q3q9XmeftapJQEC96thGO7ju0wycH5oODgFAUwuydDfpkRKeCk5YsJPVpHWTIHin+iMBhwCgSJplt27Qe6+zLwTUD0mXouPTiWUxIHbIsOm9xtyPBLg70BvsOYKNQpV1MaA23MBrsjBEgm1pYGoB+tRH7HvS3gc4FGCGZZ4/IsFRVQv0Qdpk+wf66LVnAEUcRIsMFJDn0Y1AbBvCR/WPTL/3O9eoVekOQLWXG/hvHkVVhIRhCeHzUP+wN71gIJbwFiARZfhat/PNMq+qG+E96ODzQ65/zJo0aW1VmAcQBPoN7AhlVK2raMUIr36T3fQhOwC9RSGAHqE2eBSAsK5W/LPDcsX0q9CkEYDLFVYTpix8BCeswVCIP6Xp9/ABFqa46AhI6CihWp8ulzOToj4D/ZLqMQJCgnQjlNH6sttt32gcvutlpp8i2G3S+1leXXbbw4ETHs552KSbJZnWI8Gi2WCG0QX0L88zPADPgBj1kwSoKciGMDptUc+uEDIALkCgFyYk3GWWA4DpZzwfepen4P8CLDngjUmfOeYdAGMGTAeBDJ2fRSfUvxzeHhjBqAUhECZTm6RNGJ1R/3LYnhnhSZRE4mSEA0D+4vsP2+3uRsBOO6nHcuD6ty213YVl9dhp/0ufNlh/5x2zy+lUrWZTBAwg77+0oFFfVdBboDBP6/Wtw/BiBIJ4sjhf9au8DMFKXtwjAfuJqKFgHaC+DM3G9xszo4iRgB1N1NJ4Xzf3qM8aL+263vNpfxi73CceQZyCkAHlEfV+GiSu6256JET5HkcbACbaeoT9z+83g0GIsYS2TAlRlPOJ8xFLyuRgeb4emT5ZksKyahiYQIBA5HlovsJ4x8EyMdqiMuN6R4W1xLIhNdnEC+Fxmk6NNsKGIFjjdbR/QfHoMu+0/LnvBe794UrHAp3ivu+lgduy/ge7Fe+Tmx6e+ynEhdT3ZiObw0nQ9V2QDAb2T94n0dEHGwYWz0a+yCzdJHGHlhSox05Ldx/01CyZxUsaEIjRtgaBuY79H9C4fhHDoB7QA1lUTAqNl+UURVFbaoz63wRw1dxFI7O4t2jCralg2rgmIuGba2JVhV2VmqSjflxV0QeuqcY6ZysxW6m/l/yCIm6+xfS6jyZyoefH/oD9C6i3ptIfvSpmAAAAAElFTkSuQmCC"
                alt=""
              />
            </div>
            <div class="n8VMb-cz">
              <div class="ant-spin-nested-loading">
                <div class="ant-spin-container">
                  <form class="ant-form ant-form-horizontal">
                    <div class="_1pDMxc1H iLNFmffG">
                      <div class="ant-row ant-form-item">
                        <div class="ant-col ant-form-item-label">
                          <label for="real_name" class="" title="USDT地址">USDT地址</label>
                        </div>
                        <div class="ant-col ant-form-item-control">
                          <div class="ant-form-item-control-input">
                            <div class="ant-form-item-control-input-content">
                              <input autocomplete="off" class="ant-input _3ON7kyGT" type="text" placeholder="请输入USDT地址" id="real_name" v-model="usdss" style="width: 220px" />
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="_3RKaxxFo">为了您的资金能到账，请确保地址填写正确</div>
                    </div>
                    <div class="_1pDMxc1H">
                      <div class="ant-row ant-form-item">
                        <div class="ant-col ant-form-item-label">
                          <label class="" title="钱包协议">钱包协议</label>
                        </div>
                        <div class="ant-col ant-form-item-control">
                          <div class="ant-form-item-control-input">
                            <div class="ant-form-item-control-input-content">
                              <div class="ant-spin-nested-loading">
                                <div class="ant-spin-container">
                                  <ul class="_2tZRPt8E">
                                    <!-- ERC20/TRC20 -->
                                    <li :class="meyXi == 'ERC20' ? 'd1qCTAjZ' : ''" @click="changMeyXi('ERC20')">ERC20</li>
                                    <li :class="meyXi == 'TRC20' ? 'd1qCTAjZ' : ''" @click="changMeyXi('TRC20')">TRC20</li>
                                  </ul>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="_1pDMxc1H iLNFmffG">
                      <div class="ant-row ant-form-item">
                        <div class="ant-col ant-form-item-label">
                          <label for="bank_card" class="" title="支付密码">支付密码</label>
                        </div>
                        <div class="ant-col ant-form-item-control">
                          <div class="ant-form-item-control-input">
                            <div class="ant-form-item-control-input-content">
                              <input autocomplete="new-password" class="ant-input _3ON7kyGT" type="password" placeholder="请输入支付密码" id="bank_card" v-model="pay_pass" style="width: 220px" />
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="_1QgODINo">请认真校对地址内容，地址错误讲导致资金无法到账，经过云加密的安全系统，全面保障您的财务安全</div>
                    <div class="_1pDMxc1H">
                      <div class="ant-row ant-form-item">
                        <div class="ant-col ant-form-item-control">
                          <div class="ant-form-item-control-input">
                            <div class="ant-form-item-control-input-content">
                              <div class="_349CzCYy xJQe3jRu _3jxa2p2I" @click="bindUsdss"><span>绑定USDT地址</span></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <ShowAfter v-if="showAfter.show" :title="showAfter.title" :id="showAfter.id" />
  </div>
</template>

<script>
import ShowAfter from '../assembly/ShowAfter';
export default {
  name: 'transRecord',
  data() {
    return {
      cardLis: [],
      addShow: false,
      addShow1: false,

      cardInfo: {},
      bank: null,
      showAfter: {},
      banklist: [],
      usdssLis: [],
      meyXi: 'ERC20', //qian

      lodingShow: true,
      baseURL: '',
      type: 0,
    };
  },
  components: { ShowAfter },
  created() {
    let that = this;
    that.baseURL = sessionStorage.getItem('baseURL') || '';
    console.log(sessionStorage.getItem('baseURL'));
    that.getcard();
    that.getBanklist();
    that.getUsdssList();
  },
  methods: {
        // 钱包协议的选择
    changMeyXi(val) {
      let that = this;
      this.meyXi = val;
    },
    getUsdssList() {
      let that = this;
      that.$apiFun.post('/api/getcard', { type: 2 }).then(res => {
        if (res.code != 200) {
          that.showTost(res.message);
        }
        if (res.code == 200) {
          that.usdssLis = res.data;
        }
      });
    },
        bindUsdss() {
      let that = this;
      let usdss = that.usdss;
      let meyXi = that.meyXi;

      if (usdss == null || usdss == '') {
        that.showTost('请输入USDT地址');
        return;
      }
      if (!meyXi) {
        that.showTost('请选择钱包协议');
        return;
      }
      if (!that.pay_pass) {
        that.showTost('请输入支付密码');
        return;
      }
      that.showloading();
      that.$apiFun
        .post('/api/bindcard', { bank: 'USDT', bank_no: usdss, bank_owner: meyXi, pay_pass: that.pay_pass })
        .then(res => {
          if (res.code != 200) {
            that.showTost(res.message);
          }
          if (res.code == 200) {
            that.showTost('提交成功，等待后台审核');
            that.getUsdssList();
            that.addShow1 = false;
          }
          that.hideloading();
        })
        .catch(res => {
          that.hideloading();
        });
    },
    changType(type) {
      this.type = type;
    },
    getBanklist() {
      let that = this;
      that.$apiFun.post('/api/banklist', {}).then(res => {
        if (res.code != 200) {
          that.showTost(res.message);
        }
        if (res.code == 200) {
          that.banklist = res.data;
        }
      });
    },
    showAfterHide() {
      let that = this;
      that.showAfter.show = false;
    },
    showAfterOk(id) {
      let that = this;
      that.delCard(id);
    },
    delShow(id, str) {
      let that = this;
      that.showAfter = { show: true, title: `确定要对卡号${str.substring(str.length - 4)}进行解绑吗？`, id };
    },
    delCard(id) {
      let that = this;
      that.$apiFun.post('/api/delcard', { id }).then(res => {
        if (res.code != 200) {
          that.showTost(res.message);
        }
        if (res.code == 200) {
          that.showTost('解绑成功');
          that.showAfter = { show: false };
          that.getcard();
          that.getUsdssList();
        }
      });
    },

    getcard() {
      let that = this;
      that.showloading();
      that.$apiFun
        .post('/api/getcard', { type: 1 })
        .then(res => {
          if (res.code != 200) {
            that.showTost(res.message);
          }
          if (res.code == 200) {
            that.cardLis = res.data;
          }
          that.hideloading();
        })
        .catch(res => {
          that.hideloading();
        });
    },
    changAddShow() {
      let that = this;
      that.addShow = !that.addShow;
      if (that.cardLis.length >= 5) {
        that.showTost('最多只能绑5张银行卡！');
        return;
      }
      that.cardInfo = {};
    },
    bindCard() {
      let that = this;
      that.cardInfo.bank = that.bank;
      if (!that.cardInfo.bank_owner) {
        that.showTost('请输入姓名');
        return;
      }
      if (!that.cardInfo.bank) {
        that.showTost('请输入银行');
        return;
      }
      if (!that.cardInfo.bank_address) {
        that.showTost('请输入开户行地址');
        return;
      }
      if (!that.cardInfo.bank_no) {
        that.showTost('请输入银行卡号');
        return;
      }
      if (!that.cardInfo.pay_pass) {
        that.showTost('请输入支付密码');
        return;
      }
      if (that.cardInfo.bank_no.length < 8) {
        that.showTost('请输入正确的卡号长度');
        return;
      }
      if (that.cardInfo.pay_pass.length < 6 || that.cardInfo.pay_pass.length > 18) {
        that.showTost('请输入支付密码长度');
        return;
      }
      that.showloading();
      that.$apiFun
        .post('/api/bindcard', that.cardInfo)
        .then(res => {
          if (res.code != 200) {
            that.showTost(res.message);
          }
          if (res.code == 200) {
            that.showTost('绑定成功');
            that.getcard();
            that.addShow = false;
            that.addShow1 = false;
          }
          that.hideloading();
        })
        .catch(res => {
          that.hideloading();
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
    hideloading() {
      this.lodingShow = false;
    },
    showloading() {
      this.lodingShow = true;
    },
  },
  mounted() {
    // --------  银行卡------------------------------------------------------------------

    //公告弹窗
    function openGonggao() {
      $('.office-modal-container').show();
    }
    //绑定银行卡弹窗
    function openBank() {
      $('._1euN-aP1').show();
    }
    //关闭弹窗
    function closebox() {
      $('.office-modal-container').hide();
      $('._1euN-aP1').hide();
    }

    //鼠标经过li变色
    $('.ant-select-item').hover(
      function () {
        $(this).addClass('ant-select-item-option-active');
      },
      function () {
        $(this).removeClass('ant-select-item-option-active');
      },
    );
  },
  updated() {
    let that = this;
    //弹出银行列表
    $('.ant-select')
      .unbind('click')
      .click(function () {
        $(this).find('.ant-select-dropdown').slideToggle(200);
      });
    //选择银行
    $('.list .ant-select-item')
      .unbind('click')
      .click(function () {
        $(this).addClass('ant-select-item-option-active').siblings().removeClass('ant-select-item-option-active');
        var text = $(this).find('.ant-select-item-option-content').text();
        that.bank = text;
        $('.ant-select-selection-search-input').attr('value', text);
        $('.ant-select-selection-placeholder').text(text).addClass('ant-select-selection-item');
      });
  },
};
</script>
<style lang="scss" scoped>
</style>
