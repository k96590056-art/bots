<template>
  <div class="ant-spin-nested-loading">
    <div class="ant-spin-container">
      <div class="D52anbYD">
        <div class="_4ICMeQUV"><div class="T5pPAuRQ">个人资金明细</div></div>
        <div class="_3AGTzt_i">
          <div>时间筛选</div>
          <ul class="tab">
            <li class="_1gXLAECT">今天</li>
            <li>三天内</li>
            <li>一周内</li>
            <li>一个月</li>
          </ul>
        </div>
        <div class="_45A4Fg5h">
          <table>
            <thead>
              <tr>
                <td>总存款</td>
                <td>总取款</td>
                <td>总投注</td>
                <td>总输赢</td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00</td>
                <td class="_2HJLZvCa">0.00</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
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
    	
	// 个人资金明细  ------------------------------------------
	$(".tab li").click(function () {
		$(this).addClass("_1gXLAECT").siblings().removeClass("_1gXLAECT");
	});
  },
};
</script>
<style lang="scss" scoped>
</style>
