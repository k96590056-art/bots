<template>
  <div class="office-modal-container">
    <div class="_1euN-aP1">
      <div class="_2v39xVwk animated animated-3 fadeIn"></div>
      <div class="_3Pc_iCss animated animated-3 zoomIn" style="width: 370px">
        <div class="_3DZ99c6r">
          <span></span>
          <div class="_3x7x8GsG">温馨提示</div>
          <img
            @click="hide"
            class="_8iC2lrZe"
            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAMAAACdt4HsAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAC0UExURUxpcf/////Uqv+2tv//qv///+u3o/////W8qv/Gxv/9/emwoOWunO+zouiyovC0peexneeyn+qxouWvnOWvneWwnOWunOWvnee5ouWxneaxoeSunOSunOWxpOSvneSvnPC4m+SvneWwn+SwnfXf1+avnPTe1fvw7eSunOewnuSum+mynuSunPXg2vLVzeSum//9/eSunOSunPPa0uStnfbm3/HWzfjr5vnh1vzz8f359////2ASjEAAAAA7dFJOUwD9BgcDAg0BCQT9G0cPFREkHxg6Pi5RYAsoNkxaE1VkEkIdMJAzlWpoK4AidYm6jPSWbZ9xf651HmONntaUtAAABAdJREFUeNrtlsly4kgQhgdJCMlaKe37ZmFAYDDgrXn/95qsqqRlRxSaufSlw3khQsn/qZSV2z8/9mN/ny3QJn0TNp/PFTD4wT9+UY+++6+fK7ougem6rgDim1xBH7iUxR29okuypsVxrGmyRBFf9Lp+c2ngEhPmuqTFquXUzoetavJIWABaRpdlf1CXUK/ommoVNjF+XY+flqoxAupBXoPHIJ/H6y84w1wUAF2OrYK0Q3q9XmeftapJQEC96thGO7ju0wycH5oODgFAUwuydDfpkRKeCk5YsJPVpHWTIHin+iMBhwCgSJplt27Qe6+zLwTUD0mXouPTiWUxIHbIsOm9xtyPBLg70BvsOYKNQpV1MaA23MBrsjBEgm1pYGoB+tRH7HvS3gc4FGCGZZ4/IsFRVQv0Qdpk+wf66LVnAEUcRIsMFJDn0Y1AbBvCR/WPTL/3O9eoVekOQLWXG/hvHkVVhIRhCeHzUP+wN71gIJbwFiARZfhat/PNMq+qG+E96ODzQ65/zJo0aW1VmAcQBPoN7AhlVK2raMUIr36T3fQhOwC9RSGAHqE2eBSAsK5W/LPDcsX0q9CkEYDLFVYTpix8BCeswVCIP6Xp9/ABFqa46AhI6CihWp8ulzOToj4D/ZLqMQJCgnQjlNH6sttt32gcvutlpp8i2G3S+1leXXbbw4ETHs552KSbJZnWI8Gi2WCG0QX0L88zPADPgBj1kwSoKciGMDptUc+uEDIALkCgFyYk3GWWA4DpZzwfepen4P8CLDngjUmfOeYdAGMGTAeBDJ2fRSfUvxzeHhjBqAUhECZTm6RNGJ1R/3LYnhnhSZRE4mSEA0D+4vsP2+3uRsBOO6nHcuD6ty213YVl9dhp/0ufNlh/5x2zy+lUrWZTBAwg77+0oFFfVdBboDBP6/Wtw/BiBIJ4sjhf9au8DMFKXtwjAfuJqKFgHaC+DM3G9xszo4iRgB1N1NJ4Xzf3qM8aL+263vNpfxi73CceQZyCkAHlEfV+GiSu6256JET5HkcbACbaeoT9z+83g0GIsYS2TAlRlPOJ8xFLyuRgeb4emT5ZksKyahiYQIBA5HlovsJ4x8EyMdqiMuN6R4W1xLIhNdnEC+Fxmk6NNsKGIFjjdbR/QfHoMu+0/LnvBe794UrHAp3ivu+lgduy/ge7Fe+Tmx6e+ynEhdT3ZiObw0nQ9V2QDAb2T94n0dEHGwYWz0a+yCzdJHGHlhSox05Ldx/01CyZxUsaEIjRtgaBuY79H9C4fhHDoB7QA1lUTAqNl+UURVFbaoz63wRw1dxFI7O4t2jCralg2rgmIuGba2JVhV2VmqSjflxV0QeuqcY6ZysxW6m/l/yCIm6+xfS6jyZyoefH/oD9C6i3ptIfvSpmAAAAAElFTkSuQmCC"
            alt=""
          />
        </div>
        <div style="font-size: 16px; padding: 50px 0px 44px; color: rgb(63, 80, 117); text-align: center">{{title}}</div>
        <div class="Qe8HWKXx">
          <div @click="hide" v-if="id" class="_349CzCYy _1s6FyNM2 _2ihhyR4S">
            <span><div>取消</div></span>
          </div>
          <div @click="isOk" class="_349CzCYy xJQe3jRu _2ihhyR4S">
            <span><div>确定</div></span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: 'ShowAfter',
  data() {
    return {};
  },
   props: {
    title: "",//接收参数
    id: 0,//接收参数
  },
  created() {
    let that = this;
  },
  methods: {
    hide() {
      let that = this;
      that.$parent.showAfterHide();
    },
    isOk() {
      let that = this;
      that.$parent.showAfterOk(that.id);
    },
  },
  mounted() {},
};
</script>
<style lang="scss" scoped>
</style>
