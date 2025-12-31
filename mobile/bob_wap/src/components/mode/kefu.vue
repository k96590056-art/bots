<template>
  <div>

    <div v-if="url" style="height: calc(100vh - 50px); overflow-y: scroll; -webkit-overflow-scrolling: touch">
      <!-- <iframe style="height: 100%; width: 100%"  ref="iframe" scrolling="auto" frameborder="0"  id="iframe"></iframe> -->
      <iframe style="height: calc(100% - 1.5rem); width: 100%"  ref="iframe" scrolling="auto" frameborder="0"  id="iframe"></iframe>
    </div>
  </div>
</template>
<script>
export default {
  name: 'kefu',
  data() {
    return {
      url: null,
    };
  },
  created() {
    let that = this;
    
      that.getservicerurl();
  
  },
  methods: {
    // 打开客服
    getservicerurl() {
      let that = this;
      that.$apiFun.post('/api/getservicerurl', {}).then(res => {
        if (res.code != 200) {
          that.showTost(0, res.message);
        }
        if (res.code == 200) {
          that.url = res.data.url;
        }
      });
    },
   
   
  },
  mounted() {
    let that = this;
  },
  updated() {
    let that = this;
    that.$refs.iframe.contentWindow.location.replace(that.url);
  },
};
</script>

<style lang="scss" scoped>
// @import '../../../static/css/chunk-099d4415.690b75b1.css';
</style>
