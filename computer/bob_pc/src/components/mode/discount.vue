<template>
  <div class="_35lz77bA">
    <div class="_24vddGqv">
      <div class="_1k4qh4Cm">
        <div class="XA3_YiOo">
          <div class="_1C1nxzWV" style="background-image: url(/static/image/5425846f687976b55e953f3bd89015ad.jpg)"></div>
        </div>
        <div class="Wob4TE1W">
          <div class="LCSIsCd5">
            <div class="_3_Y_edd7" style="">
              <div class="JGFWIP4b">优惠活动</div>
              <ul class="_11pizRgA" v-if="activitytypeList.length > 0">
                <li :class="actType == '' ? '_1ULluqc7' : ''" @click="changActType('')">
                  <div class="_2Tzua2bn" :style="imgLis[0]"></div>
                  <span> 全部优惠</span>
                </li>

                <li :class="actType == item.id ? '_1ULluqc7' : ''" @click="changActType(item.id)" v-for="(item, index) in activitytypeList" :key="index">
                  <div class="_2Tzua2bn" :style="imgLis[index + 1]"></div>
                  <span>{{ item.name }}</span>
                </li>
              </ul>
            </div>
          </div>
          <div class="_2h4XDiSq">
            <ul class="_2rTkfNkl _3r--lIuq" v-if="activitylistList.length > 0">
              <li class="_3d3FoD7X" v-for="(item, index) in activitylistList" :key="index" @click="goNav(`/discountInfo?id=${item.id}`)">
                <img alt="" class="_34VqJndp lazyloaded" :src="item.banner" />
                <div class="O334_H_f">
                  <p>{{ item.title }}</p>
                  <div class="ant-statistic">
                    <div class="ant-statistic-content"><span class="ant-statistic-content-value"></span></div>
                  </div>
                </div>
                <div class="_1KqIwCSx">限时</div>
              </li>
              <!-- <li class="_3d3FoD7X">
                <img alt="" class="_34VqJndp lazyloaded" src="/static/image/ef23992af1f6472e11b5f2108479b410.png" data-src="/static/image/ef23992af1f6472e11b5f2108479b410.png" />
                <div class="O334_H_f">
                  <p>距活动结束：</p>
                  <div class="ant-statistic">
                    <div class="ant-statistic-content"><span class="ant-statistic-content-value">01 天 03 时 55 分</span></div>
                  </div>
                </div>
                <div class="_1KqIwCSx">限时</div>
              </li> -->
            </ul>
          </div>
        </div>
        <div style="height: 20px"></div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: 'discount',
  data() {
    return {
      activitytypeList: [],
      activitylistList: [],
      imgLis: [
        'background-image: url(data:image/png;base64,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);',
        'background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADwAAAA8CAMAAAANIilAAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAFcUExURUxpcf///////9Dg/9Dk/9/3//////j//9jr/9Lj/9Dg/9Dg/9Hh/9jo/9Hh/9Hg/////9Lj/9Dg/9Dh/9fi/9Hg/9Dg/9Ll/9Pk/9Dg/9rm/9Xk/9Hg/9Hh/9Hh/9Li/9Lo/9Hi/9Hg/8/f/tDg/9Dg/9Xm/9Lg/9Dg/9Dg/9Dh/9Hh/9Hi/7vM687f/tHh/9Li/9Hh/9Dh/8na+tDg/9Hh/9Hi/5ix34Wh1aG448nb+9Ti/9Hi/8ja+s7b7tDa8MXQ5r/J4bfF4LTA2cDP7Zav3pWv3YOg07fG4Zyy3Z603pau2qS54JOs2ZGq2I6o16a74b3M6r/O63uZz7zI38LQ7Ky/46m94oCd0n2a0M/a7qG237rK6cXR5oul1oah1IOf0neWzpiw27nJ6H+c0bK/17O/16G334ij1Zmw27XG53iXzqm84q/B5LLD5qu/45mw3Imk1cbR58bR5oVsME0AAABJdFJOUwAEAckxCAIFDRye1mQLTbgDSX7NGUyRJy/AFBGWsztGFmmM69ttHmulbqwhLOfjXkB1msE2hVfq8PnfJFLT3pndnP7fqNHH+OFAOAsIAAADRklEQVR42u2WaVPaUBSGm0AWMMQAgYREEkIxIDsqiPveTvdiW5cqtSIqLq3b/5/puYl1zKb5rs+cmfvmJm9OlrnnnlcvvPAswHGS5DAMoxzAJEeSOO5tBSNFEJEI7UIkQhAU3AD38mJUhF9c+OnBwiIfoTBwu3opgg4tdRE33Zub25vb2+5t9yFLIZqgXN0kRtDS8vdHWZZoAiNdEnMEnSmtHhscHR9BmCNwr1dLGZrgcGdiKiKVlJXOj0forCglKUKRLonl0GRlw4vORgdiozIZkiG1M3FGWOs8yZqQgdTOxHqwsmfhcO/QAASEOVaCuiM1jkFi5QyoBOJDrsQDlTO4kwKpMdz21HRIVJE5FQjE4wEHaC6FzqtiiLY9N0nIpUn2L5BCDDswptF5drIkE1YzR0iC0voDVCbSxUIhbKNQKKYnKuh8SxEkgrOY4ZXL9dqmlcvNSwibrtXL8NI2M19WmYstg4utCwgQBrY5Ri3zNjMsJzHKfPUBExVhcVnN8LET2kcfaAn43A5zMKGd7N5zsnsCYY4A0ua8lgi6mvPvfZD3Mr/zgYeZHT016Z32ele9K4geSPMYMOdGWQ/zBx94mcc++WDMy/zZB57mLz7wfOxfFqZfG0z/V9VpNOtpHlxfD64HBiCq1VxuKJebGQxmkACFzuUTHuZ9CzNmTZjf3583RHwezXr+598WpiaG0+n0xBRSIIZBAZqrWUzk29sW+tt9CKtua1ERzM4lqa3v3NPf6RuAsPDGXJIuxSDb/vYE7ZhLMUCVt16LFabeHpyfH5wfQJijyd1xez3ZaNVR7bUXwFml1UgWU/FcFcgNBVLpQnhkZDxcAMLjSIXDyWZ+Tpm1F0ASbRhRJjZSHE6ZNTqVLoLF9IAwSDYbNRVtGaS96POCMqfFkuFCEf5LsQjZkslsNpsEQCCasQbDKgIPRd++3ci6WJ9jGrGmcT1c2oxZaDTGtBpbL+uyfbvBOYqWSqISbdUYbRTI5zWNeUiNqbXmVKVckmiKw12aCl0IKnU1mmBZNgFETe5GVa0rQUE3Ggu3dkbm9VmhLIpBF0SxLMzqvGy0NK6NFC1LGZ4PucLzGUmmjWbKfwvnbOP8N4/OBvJ58w8DG45bY4KWDQAAAABJRU5ErkJggg==);',
        'background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADwAAAA8CAMAAAANIilAAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAIcUExURUxpcfHZ/+/a//Ha//////Xa///////r//////////////7e//bd//Db//Pd//Dc//La/+jS+e/a//Xh///f///m///p/+/Z//Lj//Lc//Hb//La//Hb/v/a/+/Z/9e66f/i//HZ//Da//Di//Dc//Da///a/+/Z//Da//Da//HZ/+/a//Dd/+/a/9m86vDZ//DZ//Da/+/a/+/Z//Da/+/Y/+/a/+/a/+/Z/9nC5vXf/+/Y//Pc/+/Z//Db/+/Z//Db/8Kq4u/Z//Da/+7Z/vDa/9vD6s605u/Z/9K46e/a/+/a//Da/9S66+/a/+/Z/+3W/tm96tvF7bSg3ta66a6d3Max5+/a/9rD8NzG7+TM+NrE6Lij3tjA6bqm4My26c2w3aya29C46M2268Wv5s636d7G8+DJ9NzF8rml4LSh3sSx6Lil376q4rum4dzH6dq/7MSv5O3X/d7J6uHL7bup5NO35bmn4cq16tS+7sGs5da+8aSU18605NrF6KWU19vG6KyZ2c+05qiW2NO358eu482y5cqw5K+b2rGd29K25qqY2cGp4bSf3NrE58Ws4qeV17ei3b+o4MOq4cqw5bqj3syx5KST16KS1q6a2ryl36mX2Lag3cCp4c+05cmv482x3cSs4smr2rKd28Sr4cuu28+z3tO64q6b2r2m4KeW2NC139K34NjB5dW949e/5M2y5NzH6bul38mu4ElvG2kAAACedFJOUwBuMU0EGwENBQIGDx1QFjQvf5EZCAoMsRQoSTwkB3XsCV5rETJXDuGM3UtDImTqzM6tyqB/Z6iU2P8fjyyjQLJG/MXAcXmv/Lv7g7eI95nmOOXk/N/46VPY0NXy+7716vHz19/RjfPk99rKaK5ziPtx9b19Z+PP0YhbY0v99v/////////////////////////////////////////9EsxRUAAABHdJREFUeNrtlvlTGmcYx6vcpxuXY5cr3EUOBbkiCN63sWq8zX3fve8ZixpMahGjDipqVKpNY1rU8Bf2cdcisrD81ukP+cwz7PN+Zz/7DjPw7vPJRz7yn8Jm8wAmk8k9DySQs9n0KpOr1kplMk4+MqlWwocHFNVB5WsFX49/HsnyIfIBirgOtqukaibYxVy1zNA+FZk6k2ExFZ+KxyPxSCQ+iXC03CI2uBzsG+JmChAC18QCLexdcF+JWWxvp4p18Tqok+skLjarQS7sftE+NDQ0MFBNcDFL9cAgPACwBTApl1fQZV2bP+HF/AsCaM6oTqfr0nWietTMp8rwfcX3yPtm5mdmtme2t+e353OYTAO6CrtBwqNszJdh9tszACnmAgHU5fRR+sirxMVSJmVjrUGIdBwfzx3PEUBD9lm6joBWWz0qy5d5XJkYV67Oza3OrRJAA5V77To6PDrUKBAWh5svqwVCRPGSjo5D4ALDyDJTZC1m7x+N7hBEd6JQXQ8fdu3kQMoio1DAz5OZUjEe1kVzuP8ZcD8n6PgTuCCqKCSj9Y2OxTO6qi4BVZcXo/8mNLIMRRT6/VRqP7UPlUo9cDa3tDTXPEhls5dFZS6HhVj1KySxlVhsotPl87l6Jlay7PwNFJPLGWWxWGw5tgwVi42H/BaLPzQeI4EoWkJeztJ0x9LW2trWe7spG0X/Amjkg1OWx1xBjcNkcmgsvrGm03CxhLxBkhns6fM4RDYbQ9fW1zCxkdnIQKXeAjRyJkHQ1OLr1YuURqNSpO8NtXyZSWSgmkrIiaWlxFIicUPub9OFEZUKCZs0fvkNyKDe7L7dpZOXSEZC3V5rhR1F7UaFo9s9QqZvdgEaeWGL4GpfmymMszCMhSth6+tbC1tQB6XkU+6WifpVqMGAqvpF+run4cEfAI28t7Cwt7AHPPrhx2fPMOz58yf3HhEZVKaE/GsuT1isn3LXiRLyq1x+xvH+3PXV3wEaOZlMvku+g0oCj58+fTw9nZwms+l3S+DeLGMYi8nTdFwB+Ts9oxyOoYLyb3SAfNPiVSAop7C8OTu7ObsJlb0CRA9cuTjm9uhsOBy9VBlhlN16neX96/e5wPJ6s8uvMSlVmJSXL8tOTpLvf6HhTo8bfrXGALxuCh2A3uCttfW1dag1KsOdIUurSYmjHD5VFuM2ncf97fB6QYZHvvIFNTobIjRImWzqoa+CP0Glq8V56dMTqqrg7IUPcuGs7QmBqzDaMZmaR5HVhoDR6vD0uTqba51OZ01NLUFNDfS1zZ1ytwXcCpXYLGHyKOMIn4PiylG9p9Ltc8nlDQ1yArJz+dz+7lZdY4UKFYDLpr7bpYYAEh51aDy9lmCwModg0NLr0XhNNmNhF2QeDAZ2RGk16bz6svPo9Q6dyapE7GLSpUKMMwHcqLQ1Whl5KBrDynJciJmLuLA1V8LB0IAKr0eQ8nMgSD2uEqIGmYR2/JNyDJgYRVl5oKgYE3C0fMItZsPkKdFKC8ysMLSqQeXRz7w00zIxLv9v+AdNv5LMBlC1sQAAAABJRU5ErkJggg==);',
        'background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADwAAAA8CAMAAAANIilAAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAIuUExURUxpcf/n//Pc///p///////////////////////h//Di///a//Pd//Lh/+/c/vHe//Hg//Lb//Da//Lb///l/7eh3fXh//Db//DZ//Db///d//bb//Da//DY//Db//Dd/+/c//Db//La/+/Z/+/a//Da/+/a//Tf//Pc/+/a//be/+/a//Da//DZ//Hb/+/a//Da//Da//DZ//HZ//HZ//DZ//Da/+/Z//DZ/+/Z//Tg//Hb///r//Da//Ha/9e/7tG25/XZ///a/+/a//Hb/9K87fDa/+/a/9G67PDa/+/Z/+/Z/+/a/+/a/7Sf3di+7cCr5bKe3O/Z/+/a//DZ/+7Y/u/b/8yx5c+159S56q2b29K77e/a//DZ/9K77O/a/9G566iX2fHb/66b29O77NO769e97c+05tK26MKt5cKu5bii3tG67Mq06NK87fDa//DZ/8Kp4tfA8MWx5sCt5b+s5cKu5t7H9MGt5dm+7tW76ti/7tq+7tS359W46dK259C36sSt49fB8MWs47im4u/Z/8au5NvG8+vV+6mZ2u/Z/7ul37ei3tC569i97dW768ux5eXL9dzC697H8r+p4eTO+NvE8N3G89C15ujS+8q058eu48Ss4qaV18Co4L6n4KqY2byl37Cc27Wg3bKe3MGp4b2m36yZ2qWU17Sf3KOS1qeV2K+b2sat4qmW2K2a2s6z5cOq4auY2cKq4cqw5NO359G25syx5K6a2r2m4D3YNoQAAACbdFJOUwALLgwDBQQBAggSBxYUISYQPWkpCv4aR1ojDxyNTFA0Qlc/w2OtpxgrhR61n2xcYESAqjZeZ97bzcYZSQ2bb67ZGw7JOPV4k+aJdaKXM/aQv+2x1b5UcvLhrO/z0XzvweL6Tfq/lIjz0Li07OrB2rx7+5rB3tzUnMhUgJxe6rTleOjK+9Wl87my9bny+7pwm/dKQoj0vXst95SukqsrywAABV1JREFUeNrtlud3ElkYxgVmYIZhqCO9h04gEEDTSNckpJlImhqN6fZe19511Vi2nUOym41lg5pIDAH97/adYdkkx4HdT3v2gw/vmXuf99wfd2bu3HveLd/0Tf+xBAIBxkgg2Gih/RcohqAogRMEiiIYBo6PEgQOjo9g/4DTKM65dO3q4NALDo7ygaTE3fVXpy+T4IAuyvIJSjqTWcusra1Najk4TtW8uJ6hVf8zD0eL0gKE4EgvZzJT1679kslcIaVSoRjY6aF6uIgai9HAohyh52rmusFq7ZtKDYqVSt1EKtUts1qHMqkrZA3OLwLzcWnVcxg9ajQaulOppxJJ51RqutpoHDWmUjM6koNiBWEM5YnEV1LZl+qwX20ZSNWHQhPZ1KTFH/ZbplJDEqUURwpOjeBSneJ5Ojsekctt4aFs9ifDQHbQb4vIIy+z6W6umOQUvG8BTKzpDEyn0+OxWp/c9yxd/106fTriq629MJB+pm5WKLUEJmBFBfTElyZnnqTT6YHxurq6wURiIJGoY3pp+KOJpxqSYl9sAQIT30gklhJLjKADYjxErj2m0xJstABDcaHn5tLS7NIsRK4FQbMhd0nEQxEWGMEblYrZlZXZlVmIXHvrwb2VvJj8DY+QQjGWZeKQmhAMWl1ZhWAG3/Z6R/Isk1+9rKhqJJCvYULb4DK/yWn1zSrEm9vxeGsukc9PmsQky2eG4EJxyPjrJp0qKWndnJmQKeCpv4YpUiJT/7ZJNLw5M6PiNjR+DfM5IoW57Ie3G3UqHh9hOl/efoGATvdop07LBjtdAduT3zfqntd7fFPiZu1op0dbaObg/eOt+/fu2LFj7/6jrSM/OhwPjo8czSdGbunl7DMjlAieeWeL/UDF7u3btm3fV3nC3h7tKHV4S/IJbzRoY39mBCfhbcvd0d54ZUVFRdOBR/bSlrY2fdSRT3jb9TG1VeGEt82yzjpuwB+78P3WvB4fGz6Zs8mtyeTWx+PDNgOsM8UXsB0EkuZR25lXoOSrJK2u/v4zTB8uEEd8FqurQUsgrEeQh2u2HHq9rq5a35nk62TeHglXmzSsRxHsqhonTH14E1x7ceH1AtOH5ghMrGM9iWBqihSbDIcX1tUVi13cYHv6ZApnDYqxwfB10/CHhQ95dQWDF8EuQNC2xyKTiAqcYhgNGw99/vgZ4iPE5zG9/vzHnGjfo2bgLewwKW7uO/THusaiHec32J6wWVEE1sgsuz79pflP82PtpeeW55fnaYHtsQVczsKwRObfBaPzGit3nM3D0OyJqLhVvMKwNbyLpuaW5yCWD9rLz0Kb8+/n9sirucriMIzKi4bf0x4uEMVh5rYX1wXwucV3i+8gFiH2yFXFYfVpGJnXQYfjbxh0J6JyVRV5282W2LGHi3Pwo+N8e+n9h0BBH27jjruMXiqEHSak8JH49I54BWz+3U0n7KUdLVGHt3LfdjgKSno7dsJHQlLssACFHa0qG24pf1TSBHu/PKpvc+s77vaeqGyqjPdG3T5jCE7tQjDPKZH1yYMtpQ67/W60xX0y1r8zqI+2l9vL2zvc/WozVyclMHaYTwlhR/dFYsE2vd4djPlsYX+ZvH/Y3Qa3cNKnVpk0Il6hwgIhakRirtVgKaMrgzK10aAKqEYtfpscrNoYMEFdUbCkwVBcKxK7TDKzqrpaZZY1m7jczpDMHFBVqwLWEFfTIOTAbi5YSeGNZINYouCCFBKN2OPxgHOBcyk0OpGUQyAFaxKa5miFpLNKqaxyikghFHEkKQKnBCeFEhDqz6JVK4FTHF4Nj8ehcEbgaEvhRPHalcExBOEzQhitO6aI/p/oT/gSZXHObzyQAAAAAElFTkSuQmCC);',
        'background-image: url(data:image/png;base64,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);',
        'background-image: url(data:image/png;base64,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);',
        'background-image: url(data:image/png;base64,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);',
      ],
      actType: '',
    };
  },
  created() {
    let that = this;
    that.activitytype();
    that.activitylist();
  },
  methods: {
    activitytype() {
      let that = this;
      that.$apiFun.post('/api/activitytype', {}).then(res => {
        console.log(res);
        if (res.code !== 200) {
          that.showTost(res.message);
        }
        if (res.code === 200) {
          that.activitytypeList = res.data;
        }
      });
    },
    activitylist() {
      let that = this;
      let info = that.actType == '' ? {} : { type: that.actType };

      that.$apiFun.post('/api/activitylist', info).then(res => {
        console.log(res);
        if (res.code !== 200) {
          that.showTost(res.message);
        }
        if (res.code === 200) {
          that.activitylistList = res.data.data;
        }
      });
    },
    changActType(val) {
      let that = this;
      if (val == that.actType) {
        return;
      }
      that.actType = val;
      that.activitylist();
    },
    goNav(url) {
      let that = this;
      // let urlStr = url.split('?')[0];
      if (url == this.$route.fullPath) {
        that.$parent.showTost('您就在当前页');
        return;
      }
      this.url = url;
      this.$router.push({ path: url });
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
</style>
