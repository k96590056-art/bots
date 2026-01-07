<template>
  <div class="_24vddGqv" v-if="dataInfo.title">
    <div class="_3QmkAyzZ">
      <div class="_3BGm9Gkr" style="max-height: 580px; overflow: hidden"><img class="_1fsZpeYT" alt="" :src="dataInfo.banner" /></div>

      <div class="_15bQ4htP">
        <div class="gLQ8yoBz">
          <h1 class="MsoNormal">活动简介</h1>
          <p class="MsoNormal">{{ dataInfo.title }}</p>
        </div>
        <div class="gLQ8yoBz" v-html="dataInfo.content"></div>
        <div class="gLQ8yoBz">
          <h1 class="MsoNormal">活动规则</h1>

          <p class="MsoNormal" v-html="dataInfo.memo"></p>
          <!-- _3SkQZ6Gu -->
          <div  @click="doactivityapply" class="_349CzCYy xJQe3jRu _2HG_3opa " style="margin:30px auto"><span>点我申请活动</span></div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: 'discountInfo',
  data() {
    return {
      dataInfo: {},
    };
  },
  created() {
    let that = this;
    let query = that.$route.query;
    if (query.id) {
      that.getInfo(query.id);
    }
  },
  methods: {
    getInfo(id) {
      let that = this;
      that.$apiFun.post('/api/activitydeatil', { id }).then(res => {
        console.log(res);
        if (res.code !== 200) {
          that.showTost(res.message);
        }
        if (res.code === 200) {
          that.dataInfo = res.data;
        }
      });
    },
    doactivityapply() {
      let that = this;
      that.$apiFun.post('/api/doactivityapply', { activityid: that.dataInfo.id }).then(res => {
     
          that.showTost(res.message);
      
      });
    },
    openKefu() {
      let that = this;
      that.$parent.openKefu();
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
  },
  updated() {
    let that = this;
    // 左侧菜单的显示与隐藏
    $(window).on('load scroll', function () {
      var top = $(document).scrollTop(),
        wHeight = $('._2jLZUYlV').height() + $('.XA3_YiOo').height();
      if (top > wHeight) {
        $('._3_Y_edd7').css({ position: 'fixed', top: '100px' });
      } else {
        $('._3_Y_edd7').css({ position: '', top: '' });
      }
    });
  },
  beforeDestroy() {
    let that = this;
  },
  //   watch: {
  //   //监听路由地址的改变
  //   $route: {
  //     immediate: true,
  //     handler() {
  //       let that = this;
  //       console.log(this.$route.query)
  //       if (this.$route.query.topType) {
  //           let query = that.$route.query;
  //         //需要监听的参数
  //         that.topType = query.topType * 1 - 1;
  //         that.sumType = query.sumType;
  //         console.log(that.topType)
  //         console.log(that.sumType)
  //       }
  //     },
  //   },
  // },
};
</script>
<style lang="scss" scoped>
._2rTkfNkl ._3d3FoD7X {
  background: none;
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
._15bQ4htP {
  padding-bottom: 0;
}
</style>
