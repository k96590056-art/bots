<template>
  <div>
    <form class="ant-form ant-form-horizontal _2Xr-CMUB">
      <div class="_4ICMeQUV" style="margin-bottom: 24px">
        <div class="T5pPAuRQ">个人资料</div>
      </div>
      <div class="_1pDMxc1H">
        <div class="ant-row ant-form-item">
          <div class="ant-col ant-form-item-label">
            <label for="real_name" class="ant-form-item-required" title="姓名">姓名</label>
          </div>
          <div class="ant-col ant-form-item-control">
            <div class="ant-form-item-control-input">
              <div class="ant-form-item-control-input-content">
                <input autocomplete="off" class="ant-input _3ON7kyGT" type="text" placeholder="请输入真实姓名" id="real_name" value="" style="width: 184px" />
              </div>
            </div>
          </div>
        </div>
        <div class="_1-1n0N1N">取款人姓名必须与注册姓名保持一致，绑定后无法修改</div>
      </div>
      <div class="_1pDMxc1H">
        <div class="ant-row ant-form-item">
          <div class="ant-col ant-form-item-label">
            <label for="gender" class="ant-form-item-required" title="性别">性别</label>
          </div>
          <div class="ant-col ant-form-item-control">
            <div class="ant-form-item-control-input">
              <div class="ant-form-item-control-input-content">
                <div class="ant-spin-nested-loading">
                  <div class="ant-spin-container">
                    <ul class="_2tZRPt8E">
                      <li class="">男</li>
                      <li class="">女</li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="_1pDMxc1H">
        <div class="ant-row ant-form-item">
          <div class="ant-col ant-form-item-label">
            <label for="birth" class="ant-form-item-required" title="出生日期">出生日期</label>
          </div>
          <div class="ant-col ant-form-item-control">
            <div class="ant-form-item-control-input">
              <div class="ant-form-item-control-input-content">
                <div class="ant-picker _1F2h_OVm" style="color: #777">
                  <div class="ant-picker-input">
                    <input readonly="" placeholder="请选择出生日期" size="12" value="2004-04-01" class="datepicker" />
                    <span class="ant-picker-suffix"
                      ><span role="img" aria-label="calendar" class="anticon anticon-calendar">
                        <svg viewbox="64 64 896 896" focusable="false" data-icon="calendar" width="1em" height="1em" fill="currentColor" aria-hidden="true">
                          <path
                            d="M880 184H712v-64c0-4.4-3.6-8-8-8h-56c-4.4 0-8 3.6-8 8v64H384v-64c0-4.4-3.6-8-8-8h-56c-4.4 0-8 3.6-8 8v64H144c-17.7 0-32 14.3-32 32v664c0 17.7 14.3 32 32 32h736c17.7 0 32-14.3 32-32V216c0-17.7-14.3-32-32-32zm-40 656H184V460h656v380zM184 392V256h128v48c0 4.4 3.6 8 8 8h56c4.4 0 8-3.6 8-8v-48h256v48c0 4.4 3.6 8 8 8h56c4.4 0 8-3.6 8-8v-48h128v136H184z"
                          ></path>
                        </svg> </span></span
                    ><span class="ant-picker-clear"
                      ><span role="img" aria-label="close-circle" class="anticon anticon-close-circle">
                        <svg viewbox="64 64 896 896" focusable="false" data-icon="close-circle" width="1em" height="1em" fill="currentColor" aria-hidden="true">
                          <path
                            d="M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448 448-200.6 448-448S759.4 64 512 64zm165.4 618.2l-66-.3L512 563.4l-99.3 118.4-66.1.3c-4.4 0-8-3.5-8-8 0-1.9.7-3.7 1.9-5.2l130.1-155L340.5 359a8.32 8.32 0 01-1.9-5.2c0-4.4 3.6-8 8-8l66.1.3L512 464.6l99.3-118.4 66-.3c4.4 0 8 3.5 8 8 0 1.9-.7 3.7-1.9 5.2L553.5 514l130 155c1.2 1.5 1.9 3.3 1.9 5.2 0 4.4-3.6 8-8 8z"
                          ></path>
                        </svg> </span
                    ></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="_1pDMxc1H">
        <div class="ant-row ant-form-item">
          <div class="ant-col ant-form-item-label">
            <label for="address" class="" title="收货地址">收货地址</label>
          </div>
          <div class="ant-col ant-form-item-control">
            <div class="ant-form-item-control-input">
              <div class="ant-form-item-control-input-content">
                <div id="sjld" style="position: relative; z-index: 999">
                  <div class="m_zlxg" id="shenfen">
                    <p title="">选择省份</p>
                    <div class="m_zlxg2">
                      <ul></ul>
                    </div>
                  </div>
                  <div class="m_zlxg" id="chengshi">
                    <p title="">选择城市</p>
                    <div class="m_zlxg2">
                      <ul></ul>
                    </div>
                  </div>
                  <div class="m_zlxg" id="quyu">
                    <p title="">选择区域</p>
                    <div class="m_zlxg2">
                      <ul></ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="_1pDMxc1H">
        <div class="ant-row ant-form-item">
          <div class="ant-col ant-form-item-label">
            <label for="street" class="" title="街道">街道</label>
          </div>
          <div class="ant-col ant-form-item-control">
            <div class="ant-form-item-control-input">
              <div class="ant-form-item-control-input-content">
                <input autocomplete="off" class="ant-input _3ON7kyGT" type="text" placeholder="请输入详细地址" id="street" value="" style="width: 584px" />
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="_349CzCYy xJQe3jRu _1pqrWIkU"><span>保存</span></div>
    </form>
  </div>
</template>
<script>
export default {
  name: 'transRecord',
  data() {
    return {};
  },
  methods: {},
  mounted() {
    var mylaydate = laydate.render({
      elem: '.ant-picker-input',
      eventElem: '.ant-picker-input .datepicker',
      theme: 'type-ym',
      trigger: 'click',
      btns: [],
      type: 'date',
      value: '2004-04-01',
    });
    $('._2tZRPt8E li').click(function () {
      $(this).addClass('d1qCTAjZ').siblings().removeClass('d1qCTAjZ');
    });
    $(function () {
      $('#sjld').sjld('#shenfen', '#chengshi', '#quyu');
    });
  },
};
</script>
<style lang="scss" scoped>
.layui-laydate-footer {
  display: none;
}
/* m_zlxg */
.m_zlxg {
  width: 93px;
  height: 40px;
  line-height: 40px;
  cursor: pointer;
  float: left;
  margin: 0 10px 0 0;
  display: inline;
  background: #f9fafc !important;
  box-shadow: inset 0 2px 4px 0 #d8e1f0 !important;
  border-radius: 6px;
}
.m_zlxg:hover {
  border: 1px solid #d7967f;
}
.m_zlxg p {
  padding-left: 10px;
  overflow: hidden;
  line-height: 40px;
  color: #666;
  font-size: 12px;
  font-family: '微软雅黑';
  text-overflow: ellipsis;
  white-space: nowrap;
}
.m_zlxg2 {
  position: absolute;
  top: 40px;
  border: 1px solid #ded3c1;
  background: #fff;
  width: 91px;
  display: none;
  max-height: 224px;
  -height: 224px;
  overflow-x: hidden;
  overflow-y: auto;
  white-space: nowrap;
}
.m_zlxg2 li {
  line-height: 28px;
  white-space: nowrap;
  padding-left: 10px;
  font-family: '微软雅黑';
  color: #333333;
  font-size: 12px;
}
.m_zlxg2 li:hover {
  color: #7a5a21;
}
</style>
