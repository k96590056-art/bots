<template>
  <div class="_35lz77bA">
    <div class="_24vddGqv">
      <div class="_3sPrtvE6">
        <div class="RV_EdpYv">
          <!-- 左侧菜单栏目 -->
          <ul class="_2Um8ahM7">
            <li class="_14jeTvc1">
              <div class="pLcbtmrb"><span>财务中心</span></div>
              <ul class="_3gfI0X_B">
                <li class="_1nOGoZ4H" @click="goNav('/mine/deposit')">
                  <a href="javascript:;" :class="url == '/mine/deposit' ? '_1XA16vNq' : ''"
                    ><img
                      src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADwAAAA8CAMAAAANIilAAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAJhUExURUxpcf////Ha//HZ//////ba///////////r/+/a///////h//Pb/+/a///b///l///n/+/Z//DZ//DZ//Le//Te//La///a/+/Z//Pa///p//Dh//Hd//Da//Ll//Xh/+/g//Tc//Hb/+/Z//////Db//XZ//Ha//Da//Ha//Dc/9a95fDb/+/a/+/a//Da/9vD6NW75drC6OnU+/Lc/9i/5t3H693H6ujT+/DZ/+/Z/+/Z/+/Y//Da/9nB59S54/Da/82v3O/Z//Db/+zV/dCz3/DZ/9a85c+y3t3H6u7Y/+/Z/+/a/9C67Pbe/9i96e7Z/dG04drC59rC6NC26NW75NK34s2v3fDZ/+/Y//Da/+/a/9O67O/a/8+77e/a//DZ/9C039O44sqs2+HM89zE8suw4OrU/NzH8cy058Kr48Wu5OHM+OTM+MCp4tbA8OHK9t/D8NO35tK14NG24e/Z/+/Z/+fS++vU+82w3ePO8NW+7cyu3bWh3sy05+/Z/8ay6dC36fDa/+XM+My06Mq16dC77dvD8sCp4r+p4tS45uvU++/Z/+nT/OPN9quZ2cyz5+bQ88yw3MSw57Wh39K66ubP+NfA7tnC8bCd2+bQ+beh3ce06NjC8Lym37ul4L2m4M6z5cyx5Meu46iW2NK25rOe3KqY2K+b29S356yZ2qKS1rii3a6a2qWT18Ws4sGp4Lqj3tO358iv47Cc28Or4bSf3KeV18mv49C05ruk38uw5KWU16OS1r2m4Mat4quY2bWg3bah3b6n37yl38Co4LKe26qX2cKp4amX2Kya2rjd3e8AAAChdFJOUwADTW4BHAQFDTECCBWRDgoLss5YJxc+B+IqDBElZxMZIC1I5QZEG0yuODTwVlCFnOfu8s488unuzo6Axawi5e5h2HdqXeNt5t/xiNiWlh9CQefr7vvj4t3vuKBTtKehy77c6tOw+cbI1e/485h07YGFNfTq7dvSnfef3Pvh7fZz0M17aOjij7ro5b+n4ML19fvPb93b+uvq8fTf/LPO+vj4sEW2AQAABLBJREFUeNrtlvdXWncUwIs+HlMwRbTsoUwVonEgYBxYU7dV615JjFsz2iRN0uyd7r2HiaNaImpwhGANuIh/Ve97gAp+ob+1v+Rz7jn3fu95n/M4nO/7fu8br3nNfwyGYUwKBcdxWijQoVCYGBbNBZOWwuLGC+nhCOO5rBQa+JFdCi0pvubRuemFaYgFiOk9MtrPcpNwChbZZXFqGiYmFiYWSKDYz7mzHBYtgo0xaSwR/+bzyLTzOSycGeHFLA4/oQEeGns+BkFmYK8eyOdzktCvZtLi2fm1Y9FgyKVcGlpO4qgV6Y/HHkOMkQTqvZwokHFSkL+bwpLK9SUvoqHRy0UsCkrGueyExNsrAV6s+J+HAiKQeVliNhclYzS6TKEcWXm2AvEshN1eoUrAj8dRe4slkutjiteerBFAekICBUQgS5QKmTBchh2Np9BrLvU2mR1rDoi1tYYPT0FF1Feg8vccNqVCLaQh9pbwq5Mni5rKHYsOiMXFK83Np4i8+G1z82eQyH6phqGm0w7uLU4N4X6U5wMWffDwd8nJP4DUkJyc/AVkaPp8sTEMarjMxGFvXSoqanrn7Yu+AHOOnyoqvp+7VlFRcW0O8M2hZYySImTLewn33Y83dxk0WSz9fRbLwF4LJeMsEVVRdBzc962b65sQ6+ubQ3fuaq1Wq/bXO0PrAVAykyZki3Wk+0HL3wEGWjqMlZVxlZXGjkODwSZCJjd17XHCLfh0w7VBMqQ15hnMt8yGPKN10LUBbZfLhZBhe1QzlI2NJ04UFPTNB/lj9MHDM7aqhw9Gf3PNuyCgh5Sl+br0xkZwM0zz+7Cf5lXZgXn7PARklMyVinVtjccKMlJTj9i9dpLf7w+fGeGll4ycGb4PS2h7vXaEDJ+TOCvtPb/sDXDXaIgtSdekl8QaWke9Ho/XA02UHO+XM1JB9gBLnqWln2+2d1aVxNyu6my/sbTk73nQckIij5Szj0xuTUJsbRF58nTbvWBN5ihyXWr2rkzihD9sy+mXnZNO51ZE+djRuvrsTJNzP/cknSHriPLRw3X1mZmmP/fTef2XkPW/yU93nkLsQEC+2vvjDklgHUWur88sM80E2JnZgZgJJYqckwvyywBTL6dItqe2IaZgCc2I8mGQc8tMr7Zf7QeW2yRkP+Im6c/JyS3LNY0Dy+PLEAfzeKTt2dZDyJf73MtuiGUknxMHIPKrsvVczvmypd896w4C5SwJ0Vt1r65+gzh6yeNeWXjdUNmq/Xp1djUIlLMQ/gy4hxGHPpwkVEVtm+RW+cUbq39FYvlqjxlx3TBT6HyxXpUmKTbEtWq7uy6c/+StcM5fsGjjihEXHYZzRVSBTpVWGGuGE6ul29L1Zhhdlm6t0SxBXLEYJYnOrhboa2N4xMuNHVbtoTC0Ha1x5tI0xOVO3jZsqlihU6WX2IrN5Xl5cWHklZuLJWkqxFhB3nN0Eb86gQE6r1BiK40NpdQmKeRpEhmogQbDKHgSlyOVVScodIkqpUYTE4pGqVRl6QVy5CiFEXMjofOp+QkCBeMACoVALJdJg0McWqeLpGyZTE0NQ62W8dkiTpTxEXQcMbUiB1fk25mIcRkxMv+//APaliMJa87lZQAAAABJRU5ErkJggg=="
                      alt=""
                    /><span>存款</span></a
                  >
                </li>
                <li class="_1nOGoZ4H" @click="goNav('/mine/withdrawal')">
                  <a href="javascript:;" :class="url == '/mine/withdrawal' ? '_1XA16vNq' : ''"
                    ><img
                      src="data:image/png;base64,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"
                      alt=""
                    /><span>取款</span></a
                  >
                </li>
                <li class="_1nOGoZ4H" @click="goNav('/mine/transfer')">
                  <a href="javascript:;" :class="url == '/mine/transfer' ? '_1XA16vNq' : ''"
                    ><img
                      src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADwAAAA8CAMAAAANIilAAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAFQUExURUxpcf////////3f8v/h8f/j9f/e8v/r///////f9P/////h//3e8f3e8v/////o//3e8f/l8v/i9P/g9P/i9f3e8f/g8f3f8v/g8//h//3e8f/l9v/g8v/i9f/e8v3d8f3e8v/f8v3e8f/f8/3e8fzc8P3d8f3e8v3e8f/e8//e9P3e8v3e8Negxfzc8O231+Guz//f9//f8sB7q//e8f/f8cOCr+y92u+62ue21e652O672fHG4eex09KZwP/e8e/C3tKWvsiIs/HK4+Gv0O652O642OWsz8J9rMR/rtaYwNGRuumx0uu01L54qLtzpcWCr8eEsd+lyd6ix8qHs+Gny7x1prduodSVvtKTvOy21rlxo+eu0MB6qtibwtygxs+Puc2Mt8uJteOqzeOpzMF7quev0dWWvrhwotmdw+y11dqdxL12p+GnytOTvNOUvexGlGoAAABGdFJOUwACBJFNHG4NBTEBCM6yBgvjFC0mF6lJjGsR4B46Gn6Gn2S/QJjG19uvVUbKusLq1OQgUvpecuv1ku3bivH631/p7PCwpNaxy4MBAAACzklEQVR42u2W6VPaQBTAS6LGJJCQk4SEQLhvEATv2mvUnrZarQqtbUVE8fj/v3UNaSLZbGGmH/U3O7Nv385vlmEm771nTzzxCKCoAADD5n3BsACAovxV4DEMzbIEApalGQYDvo8LVJpbXt36B6vLHA10yselWbG2NYGayNKwTWE0wa2dWFydXFmAwMbNr3EEjVHehxmWW6h9nEhtgWOZAOV9WNX4jQ8T2eA11ft0gCFEQe/2+91+16JvxfDe1QWRYAIeWdVIeXsKZFJTvTLNCXqh1+ud9c7AsnaAE7t7QRc4elzGWFFILR6Msb1eXb85uBkdQDCKF1OCyGIeOcYXzb2HLIUBN3tezCIf85FlZd9lI5rLZrMv9iEUGZLniRgpK6d/GS7lgqUkoBTMRsPV6tKpgyKTMWLeI8+SM3PD4fByeAnWMFtKhiRAqJwJZnPh6n3eYjg3Q876yj8cVpJSAsfxdGKkr7g3SPndFCDlI5eLowuwjmCQ8t3t7fHtsQM4WOe74zuw7CRSfj8FSPmnQz2fwCNxQOT+TyvX3Ruk/MshE5LSeAQwkjPuDVL+7VAvSwnHlkJ19wYpf4Wo3P/w1y8fZJDyFwjDMOKVsQxS/gxRMd68Gs8g5bdTgJTPd5Cc75yDBQKk/H0KkHLz00SatgwXg/ahw/XhNVjO7tC2iwFchiq7Y3R2O2CN5yp2GYILYLzdGXQGFiCAAMl23C6AcOk1Es+bg29IBs3nCcMuvXDRb+FSMpiLhm2iDtYpF0xKeMsu+nC7MY00+IJKQV9KmbKUNky73cCNrqEYeELK50M+5POgJBpKw250cItNNcyWAT4jXyJxo2U2UnaLhZs7r8uFTVNR5nxQFHOzIOu83dzhsUITSD1VlGd8kYspnRQ0e6yABxpV1ASB50lfeF4QNFF1BhpolCJUTozFYrM+gLTIqQQ0Sv3/EDf9+Pi4+QN1nIw6yXQYGAAAAABJRU5ErkJggg=="
                      alt=""
                    /><span>转账</span></a
                  >
                </li>
                <li class="_1nOGoZ4H" @click="goNav('/mine/transRecord')">
                  <a href="javascript:;" :class="url == '/mine/transRecord' ? '_1XA16vNq' : ''"
                    ><img
                      src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADwAAAA8CAMAAAANIilAAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAGYUExURUxpcf/g4P/d3f/g4P/k4f/e3P/////////s7P/////f3//////o6P/e3v/e3P/d3P////S1tf/e2//f3POysv/d2/S0s//e2/Ovr//e3f/i3v/g4P/g4P/d3f/e2//l5f/e3P/e3f/f3P/d2/7d3f/c2//c2v/e3P/d2//d3P/i3P/e3P/g3P/d3P/f2P/e3v/f3//e3f/g3P/d2v/e3PGqqfOurvSzs//e3v/e3P/e3P/e2/Ksq/Oxsf7Z1/zT0P/e3fjMyfbHxfOxsf7Y1v/f3OeIffGpqPKwruyakfXDv/bLyfW3tu+ro/zRzvCtp/rNyfO3sf3X1f3W1PS7t/S/vPGqqvGqqvW5t/3V0va9veyZkeiMgfS4tvTAvOiRiOiPheeNg+mTiuqVjeqXj/O+uvK7t+2knfCxq/TEwfXIxeaIfuWCd+aHfO+tp/bKyOeLgeWAde+vqeWEeeyim+qZkeuclOyeluygmPTCv/TGw+2mn/K6te6pou6qpPG3svCzrueKgPPCvvXGw+aFeuyimvG1sPC1sGlSkKwAAABedFJOUwAITRAcbgIBDQUwBAsvkc8G4UdXzOPXssBbFhkgY2YTLUtg1xtrg62duSV+QtsoPik6M8Kkq7vVRYjIy7PFmbV2rfLLfFL7mb/v7Ojb1MXilt3l3+DccHOesbvX9OAxvsL0AAADUUlEQVR42u2W6VPaQBTAm8ZgIBGQeJQAIWAgyCHIYQU80HrUs169O/S0LbVa6320Kp7/dh9rTIGF5IMz7Rd/84ZdlvnN21lm3nv37rjjH9LYaDAYGIYxVgFH8ENjo5YKopUgWJbGYFmCsDLg13VBZbuGpn7UZGqoiyWMqo65RoIWh7/VZVgkWStT+/IGhiD5obOzg7ODg8JBAXFWuP4OH8DT8WcSJAcbT2yleedkoYL9wj4CNhD5VGpcYq1gYzLDup2m02v2T/chsH1fKvWchNyYDIkdsehyPr+cX4bIAzd7de3pS43zNMEYMJkgnXHPsib9YDvdpYtjsjvYzX3WpAXsmEQSTLXMsHws7P2FGG6NRDoUIpHW4V8KDx897otDaqMBkx2iTThGLEQ6LJZsNpPJZi2WjsjCsUIbpO4O8qy1WjayUpPHd3V5eXV5tWjJJDoVEhnLYukM4nL6YX9PNOagcZmWTB7qBDGZaJeTyQCQTMrtickThWa4d1iUyBpyg+k+9VWTktwrNpBEbXlto4K1jTUIdQX5QW9TfRmxFEjnKMEFCFQuHVhaU2hua3lgM9WVjxCD5hAleO0cZ/cKVMg8eKSgI/9GlGQXuGC7SvJvBR35EDE/UC4PzB8q6MhfNNGRtyq52LooAQva68h7iCc317b7ZvbK0JF3EaUHu35s3wg62NndgdjVkXcQL9Fr2+GPys3tlKEjbyPQtcF1Uf6Z7TJ05E+a6MgfNdGRP2iiI7/VREd+p4mO/F4THbm4vl5cLyJgUw0Ugx6NYrDyl+JKEWKlHJBfqGUIL4BvVlfPV88hVmsAmfsFtQDipff1JuJ88xwBmzImpl+NcGrpxYv+3Nj3uozNJtO+UbXo4+0mNDQx9rMmYxOzsnnEa1PbDd7ocmY5YYm0YkD/ScgBPyRWGx3eYgV/QO7MZC1VZKH9JAf8FBc2qS0Wb+6cz28OyHJ7FbKcDKRDPq43HlSbOz5WhDkhF0qbMdL+Eco7GjUFHepYgQ80pqiH8wo+qgqf4LKP9naLTp5UBxp8lHLG4t1hm8dzvwKPxxaOxsVgg5tGo1SdIc7tcAZjYpOpiiYxFnRKfOUQh4+PNOnmHZLUUIEkOXjeTSvj4y0G11uPzP+fPy++5TKtNz7fAAAAAElFTkSuQmCC"
                      alt=""
                    /><span>交易记录</span></a
                  >
                </li>
                <li class="_1nOGoZ4H" @click="goNav('/mine/betRecord')">
                  <a href="javascript:;" :class="url == '/mine/betRecord' ? '_1XA16vNq' : ''"
                    ><img
                      src="data:image/png;base64,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"
                      alt=""
                    /><span>投注记录</span></a
                  >
                </li>
                <li class="_1nOGoZ4H" @click="goNav('/mine/bankCard')">
                  <a href="javascript:;" :class="url == '/mine/bankCard' ? '_1XA16vNq' : ''"
                    ><img
                      src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADwAAAA8CAMAAAANIilAAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAFTUExURUxpcd/3/////9Dg/9Hk/////////9jr/////9Lj/9Hg/9Hg/9Dg/9jo/9Hh/9Lj/////9T//9Xn/9Lh/9Dh/9fi/9Hj/9Hg/9Xk/9Pl/9Dh/8/g/9Lh/9Hh/9Hh/9Pi/9Hh/9Xm/9Dg/9Hh/9Li/9Hi/9Dh/9Dg/9Df/9Hg/9Hg/9Dg/9Hh/9Hh/9Dh/9Dg/9Hh/9Hh/7nL6tHg/9jl/9Pj/9Hh/9Dh/8/g/tLi/8/f/7nM78rW6sjV74ai1rrO8rnN8b/J4bfF4LTA2YOf05av35ew3pav3pmw3Jyy3Zau2p603pGq2KS54LfI6Ka74YCd0nuZz4ul1r/O68bR58LQ7I6o13iWzpOs2c/a7r3M6oah1IOf0rTF5n2a0KG237rK6Yij1bzI3r/N6rK/17O/17TG54mk1bzI36G337DC5Y6n17nJ6H6b0ZSs2qm94qy/45GHbcIAAABIdFJOUwAIAeQwAgQNBRy3S58LzkkDBhZmTRksbREoxb85sY9EYB5urT1qhIjK6djUIaJo8VJ25qcUJJx/4FmX796h8PbynP7f997MyoFKWf0AAAMPSURBVHja7dZpU9pQFAbgJmYhQEwIhAQIECAIKlBW2XHvvttaa4u7ILj+/089udbMkEXzvT5zZ+4h48sRHc69L549+y/gOEnyFEV5LOAhT5I47hyFYADDWJa2wbIYFoA3wJ2yVIAV+71fDnp9kQ1QkLbNejCa6X1/RI+hMY9tmqQwWli/uDi5ODHAC1hoR9YFGqNIm8Y8ZAub58jZ+RkstOuMerMAaR63Nvaw9YKysf/jEfsbSqHOekibxjKjVE93TndmwANYxl5VGBlaWxsLkf7+k/oRAVpbG6eI6tGMq6MrBApY93uVSFla4xQ01j65oEFrajZMBmiG4Iaj0XA0REaotu5DjmDoADkbxuSCUp5Op8Nua85BqzsFZaUgY7NhHhMaWnsK5pfBvAV6OgVtrSFg/ExY/8hJ9Q7k89FYzGsRi0Xz+TugJvUPbQqL4aR6C6oxb6ZW9JsUaxlvrHoL1GRYNIU9rEhwwc8uBDlCZD2zYZqB8EcXIMzQ1rCvNDk0TA4nsNAOUI1MSj6H8HsXnMLZty5kncJvXHAKS+9ckOzDIWnv3s3eDaw9WzdSyCH8wQWncPpyF7ncvYSFdp1Roz3tFP7mgmP4eDw+Hh8jY6M2vXb8tX+brL4Eqw/VYlevHP9gf0zWFsHaQzXX1SvJ6f88+PKkQRaFrV/J7KsDw/XBNQLFzLPXJfSVtA6DYG7w9QmDBWMYmMdQ07+99fMRW9udShvNXtMArDeUciWRic0vtdCobC0twzTTRfOo8HrjtZVcuqw06hhvHr0pGCXNTsYbzc/r0ByMZzLxuBfEoaoVO7mKyulHBmke+mJEK2ebCX8tEwfoh/0rwF8EUHU6iYVKMKRERBj65uMGWmvlYKWZS/yTyy0guZxeNZuVSlYNaeGUbD5ucD4ARzuhcW01mJXS6bQkSdlS8F4JFaraLieVMBzvAR63uVSkIoSSTHK+EPDpON1DkdQUIpJCFwu764wsphqRMOEgHGmkRBldaWwvUrRcF0SRsSWKQl2m0WXK/RXOeo1zf3m0XiD/b38BQ4qXMqi9UlUAAAAASUVORK5CYII="
                      alt=""
                    /><span>卡片管理</span></a
                  >
                </li>
              </ul>
            </li>
            <li class="_14jeTvc1">
              <div class="pLcbtmrb"><span>个人中心</span></div>
              <ul class="_3gfI0X_B">
                <li class="_1nOGoZ4H" @click="goNav('/mine/myVip')">
                  <a href="javascript:;" :class="url == '/mine/myVip' ? '_1XA16vNq' : ''"
                    ><img
                      src="data:image/png;base64,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"
                      alt=""
                    /><span>账户中心</span></a
                  >
                </li>
                <li class="_1nOGoZ4H" @click="goNav('/mine/boonCenter')">
                  <a href="javascript:;" :class="url == '/mine/boonCenter' ? '_1XA16vNq' : ''"
                    ><img
                      src="data:image/png;base64,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"
                      alt=""
                    /><span>返水中心</span></a
                  >
                </li>
                <li class="_1nOGoZ4H" @click="goNav('/mine/mail')">
                  <a href="javascript:;" :class="url == '/mine/mail' ? '_1XA16vNq' : ''"
                    ><img
                      src="data:image/png;base64,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"
                      alt=""
                    /><span
                      >消息公告
                      <em class="_1zgTeUNO" v-if="$store.state.messageNum">{{ $store.state.messageNum }}</em>
                    </span></a
                  >
                </li>
                <li class="_1nOGoZ4H" @click="goNav('/mine/applyList')">
                  <a href="javascript:;" :class="url == '/mine/applyList' ? '_1XA16vNq' : ''"
                    ><img
                      src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADwAAAA8CAMAAAANIilAAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAGYUExURUxpcf/////////////h8f/e8v/f9P/r///////j9f/o///h///g8/3e8v/g9P/////g9//g8v3f8f3e8v/o8//h9f/g8f3f8f3e8f/f8//f8v/l8v3f8f/e8v3f8v/m///e9P/f8f3e8v/f8v3f8f3f8f/e8v/h8v/g8/3f8v/f8fvU6f/j8f/h9f3e8v3e8f3f8eu41/3e8f3f8f/g8tOVvuq62OKv0O652P3e8s6Puem01PnY7uy82vTK5P/f8v3e8em52P3f8fTQ59+pzNedw9GSu+zB3PPL4714qMyOuPTP5bx1psB7qu7D3uCny/rZ7M6Puf3e8ee31uW01Oi21fPI5diexPfS6dacwtecw+642Oiw0ueu0OKny+SrztKSvOqy0712p795qbpypM6NuLduodSVvt6jyNGQutygxu241+221tuexdmcw9iawbhwotaYwOOqzeu01bx1psF7q8qItOClyc2Lt8J9rMR/rsmGs8eEscyKtuu01OWszrt0prlwo9OUveClysWCr753qMaCsM+PuVGqdcoAAABbdFJOUwACBAFNbjENBRsLCGuNLwYgKqezFhlKwaxWdhO6Zo8QR2HGf5mCPjxCoHEqJTPXzdKw4JNS+oSj7LbW7Mr18lut2oeT393vjMb656r59N367/muv6qTbNBsxfJcKP3sAAADf0lEQVR42u2W2XPSUBSHJZAGkpCGJSuELQlbVwTa2tp9sYvauuvUKoqoFXerrWu1pe2/7c0CQZPcPjijL35zZi73B9/cF+acc+Y///mLeL0ejwdBEL8NEIKvvF53FYi9BIHjmAM4ThC9CPBdXKDifaWxzWZzs7lpZ6zUhwPd6+z6CaxvzCaCAJR+jvVhhN/R9iBEMlpqNp83n9sAoU4pmiQQj9PDvViUnnj3C9/efdMAh/F5go5ivQ5PexE8RlMPToGiYzhil8HDTCh715mtu1ugwIdsiAFP22UiSQ+wWwb7W/ugzEt3xg7QScJJjvXnhPu/sn9/H1TXXcj1xxxkBI+G8um3p5DOh6I44iAzVEq6dwpSimIcZD8eoFhy9/Bw93DXZHJqY2Nq8tDM9JNkqQDut8tYgPKhTy12p87qTD3tAvVRAcxR7vGhzywmB4eHMpmh4cHJrhD19bjLLzqsD2fiEZ6PxDPD61YKlV92mOCuFsrBYLlwlZuwUqj8qsPsjDInFovinDIza6VQ+U2HWUUtjgCKqjJrpVD5SYeFoHhDO2+IwQUrhcq1g4PaQU2jOk/erB7UqjfJ+WoNhDo1qLxtsUgKI0tLIwK52BVC5ZMubt2u+HyV27dOtrdPts0MKu81GnuNPVANwNKd0dE7S43uDCp/PQWo/KHNlYVrpeujgOulawtXOjFU/mxSPR8pJFQRoCYKkfPVdg6Vv5hc5nglKGv/MDmo8Nzldg6VW8fHreNWq6U9LBdJSSKLsvY0yI6176DyJ5PlcEJG09OCMJ1G5UR4uZ1D5Y8mi4qKTlfYVIqtTKOqstjOofL7NuMX0pVUNpfLpirpC+OdGCrX6/Wj+hGoujNQ+aHF0cMjUNZdz9xl0AAv7ex83/kOyjoNjPslowG6tN7xR1DGjdbr0vTnL/54/eO1DRBqXJw3mr7LuJHXVlceu7CyuiYb48Zl0Illnhsa1Do2F4+fiwDOxeOc1r0Hhzi+LOqDzm3ESqrCgx9nONM1bS2J84oqGSPWZbgLpFouhPkZng93wYMgXCirpGAMd5e1Ii9IojwXTCQSQQv9OieLkpA31gqXhYbKskJaIlEbpJQW2CxlLDQuqxQdGsjlU6zPBpvK5wZCtL5KuS1xMYbuD1EU1fMbIAr100xMX+Jc10csGYsyTMAGw0RjSUxfH/9kcf3Tlfnf8xMlltyZwRghkAAAAABJRU5ErkJggg=="
                      alt=""
                    /><span>活动申请记录</span></a
                  >
                </li>
                <li class="_1nOGoZ4H" @click="goNav('/mine/apply')" v-if="$store.state.userInfo.isagent == 0">
                  <a href="javascript:;" :class="url == '/mine/apply' ? '_1XA16vNq' : ''"
                    ><img
                      src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADwAAAA8CAMAAAANIilAAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAELUExURUxpcf/////r6//e3P/j4//e3P/d3f/////r6//g3//k4P/d2//d2//////o6P/d2//e2//f3P/g4P/h4f/f3P/e3v/e3v/e3P/g4P/d2//d3P/g3P/e2//d3P/e3P/e2//e3P7V0/+wsP+vr/+0tP+8vP28vPWNjP/e2/3JyPSMjPN9ffu2tv/a2vednfegoP/GxvJ3d/+9vf/KyvJ6ev/Ozv+4uP/BwfFzc/N+fvOBgfioqPSIiPekpPOFhfFwcPeamv/Y2PiqqvWWlv/T0/+vr/Btbfmysv/h4fmvr/ejo/WPj/WTk/+zs//d3fSMjPitrfenp/m1tf/m5v7S0vu/v/vDw/u6uv+0tCPhdiAAAAAtdFJOUwABB5Ebbk0EDTEVzigCC+OySCAZYy49ahCCrEJX3sRVdaWs6O+x6+e7ldf09XFnSf4AAALRSURBVHja7dZbc5pAGIDhKkaBbGgFRMFzzodZwNj0EEIbqS0xpy5EJP//l/QjtCoDu+lMZtqbvOOF8zEPKxey++a11/5hpdLW1laNElwqlegUYLlcliS+IEmCSzXwFAtUQts73yntbCMJeIlmebR7l/R49/gUfFlvF/EUDbYl7n1gtie2QBctXOZFef+U2b4s8uWCpUs1SZSF04/MTgVZlGp5DAsrSIttZrGGFFi6ALdkoRraY0Z2WBXkViEWkdbx4zNGcdjRkFiA4ZFRWw1n0XSt+XQOnz/fIxKqbQQPXYCVRr0ZzrzFhNLCIWGz3lAKcSXBPglifF8QjgPiJ7hShPmKUN0A7LhkfJVrTFxn5ocbVaHC0/HMc1zLse8f1rq3Hct1vL/AxAtcyzRJdIavHh6u8FlETNO6DjzyHPYBEydwr4Gbl0+ZCXUDL8E+G89gZfjhoIFDIK3EBg7gGRsTktgggLX9qQ13cO2pn1qPQEzsQSl2FxjPCZljHLluANrx4AZMHABMKOSAm0zgDp4LBRBcZGIXuk6zgjGGxoH1e+BCTGwti2DRtEm0mjKxuWyOl81XUya+XOZEi4UNcLGInNWUib9lsjCOLzMTJr5dFq+eOV5Nmfhm2fozr6ZM/HOZFUdRhOFvEcXWasrEF5luMfazEyb+kukGcHbCxOeZLiY4yE6Y+HM2k5xnB0z8/pmY+GTE7CTFlFfv8Sdmx8mrl/rSPxp9ZTQ6Sl/6lO1GHx6MflAaHQz1dLuhbHQDzuhtdrtvc3W7mz2DGyQbHXWLVXXOOOxtFtQ7NDhdTbdYyubeb+rc0DDe5TKMIac3++nmTjlWtPvqQNe5gnR9oPbb6bGCcqARtGpHVZsbuZqq2qlqQnqgoRylZCRo7Xq9mqteb2sCktOjFOUQJyoyQo2GkKvRQEhWRJ51BJT4ligqSiWXoohii5cS+5KD60uPzP+/X9AROi2dPEaVAAAAAElFTkSuQmCC"
                      alt=""
                    />
                    <div class="_2WD_Lzxu"><span>申请代理</span></div>
                  </a>
                </li>
                            <li class="_1nOGoZ4H" @click="getAgentLoginUrl" v-if="$store.state.userInfo.isagent == 1">
                  <a href="javascript:;" :class="url == '/mine/apply' ? '_1XA16vNq' : ''"
                    ><img
                      src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADwAAAA8CAMAAAANIilAAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAELUExURUxpcf/////r6//e3P/j4//e3P/d3f/////r6//g3//k4P/d2//d2//////o6P/d2//e2//f3P/g4P/h4f/f3P/e3v/e3v/e3P/g4P/d2//d3P/g3P/e2//d3P/e3P/e2//e3P7V0/+wsP+vr/+0tP+8vP28vPWNjP/e2/3JyPSMjPN9ffu2tv/a2vednfegoP/GxvJ3d/+9vf/KyvJ6ev/Ozv+4uP/BwfFzc/N+fvOBgfioqPSIiPekpPOFhfFwcPeamv/Y2PiqqvWWlv/T0/+vr/Btbfmysv/h4fmvr/ejo/WPj/WTk/+zs//d3fSMjPitrfenp/m1tf/m5v7S0vu/v/vDw/u6uv+0tCPhdiAAAAAtdFJOUwABB5Ebbk0EDTEVzigCC+OySCAZYy49ahCCrEJX3sRVdaWs6O+x6+e7ldf09XFnSf4AAALRSURBVHja7dZbc5pAGIDhKkaBbGgFRMFzzodZwNj0EEIbqS0xpy5EJP//l/QjtCoDu+lMZtqbvOOF8zEPKxey++a11/5hpdLW1laNElwqlegUYLlcliS+IEmCSzXwFAtUQts73yntbCMJeIlmebR7l/R49/gUfFlvF/EUDbYl7n1gtie2QBctXOZFef+U2b4s8uWCpUs1SZSF04/MTgVZlGp5DAsrSIttZrGGFFi6ALdkoRraY0Z2WBXkViEWkdbx4zNGcdjRkFiA4ZFRWw1n0XSt+XQOnz/fIxKqbQQPXYCVRr0ZzrzFhNLCIWGz3lAKcSXBPglifF8QjgPiJ7hShPmKUN0A7LhkfJVrTFxn5ocbVaHC0/HMc1zLse8f1rq3Hct1vL/AxAtcyzRJdIavHh6u8FlETNO6DjzyHPYBEydwr4Gbl0+ZCXUDL8E+G89gZfjhoIFDIK3EBg7gGRsTktgggLX9qQ13cO2pn1qPQEzsQSl2FxjPCZljHLluANrx4AZMHABMKOSAm0zgDp4LBRBcZGIXuk6zgjGGxoH1e+BCTGwti2DRtEm0mjKxuWyOl81XUya+XOZEi4UNcLGInNWUib9lsjCOLzMTJr5dFq+eOV5Nmfhm2fozr6ZM/HOZFUdRhOFvEcXWasrEF5luMfazEyb+kukGcHbCxOeZLiY4yE6Y+HM2k5xnB0z8/pmY+GTE7CTFlFfv8Sdmx8mrl/rSPxp9ZTQ6Sl/6lO1GHx6MflAaHQz1dLuhbHQDzuhtdrtvc3W7mz2DGyQbHXWLVXXOOOxtFtQ7NDhdTbdYyubeb+rc0DDe5TKMIac3++nmTjlWtPvqQNe5gnR9oPbb6bGCcqARtGpHVZsbuZqq2qlqQnqgoRylZCRo7Xq9mqteb2sCktOjFOUQJyoyQo2GkKvRQEhWRJ51BJT4ligqSiWXoohii5cS+5KD60uPzP+/X9AROi2dPEaVAAAAAElFTkSuQmCC"
                      alt=""
                    />
                    <div class="_2WD_Lzxu"><span>代理登录</span></div>
                  </a>
                </li>
                <li class="_1nOGoZ4H" @click="goNav('/mine/password')">
                  <a href="javascript:;" :class="url == '/mine/password' ? '_1XA16vNq' : ''"
                    ><img
                      src="data:image/png;base64,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"
                      alt=""
                    /><span>密码修改</span></a
                  >
                </li>
                <li class="_1nOGoZ4H" @click="goNav('/mine/contacts')">
                  <a href="javascript:;" :class="url == '/mine/contacts' ? '_1XA16vNq' : ''"
                    ><img
                      src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADwAAAA8CAMAAAANIilAAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAEjUExURUxpcf///7bl47Lk5L///7Pl5bXk4////8T947fw5r7//7Tl4r/p6bXm5r3v77fp6bLk48z//7///7Lk4rPj47fp5rTk5LLk4rPk5LTl5bTk5Lbm5rLk47jn57Dl4a/k5Lbm47Pj47Lj4rPj47Pk47Lj44bPz7Pk4qLZ2JXT07Lk4rPj4rLj4oLMzHC1tbLj43G2tWavr37Ly33Lyl+pqW2zsm+1tGqxsXK3tnW5uGevr2WtrYzR0JbV1GKrq12np4nHxni6unq8vH7KylqmpX2+vqTb24PNzIDAwJHS0oLCwajd3YfOzq7f3o3KyYjPzprW1p/Z2bfj47Lh4ZfR0JPOzoXExLvl5J/Y2JrX1sLo6JDMy5HT0oXDw4LMzI7S0YXLyjg2Q68AAAA0dFJOUwABLXIEHUECCREGWQwpDximBQi9jRtP0WE7VhRsIDYxJHGzlH9JsoWT69DGzPDenNTz6enVL8bLAAACsUlEQVR42u2WWVebQBSAGzYBWQwKBcISzOoabdO9aa1tY1M1LiUaq/H//4zeQZBlwHBO3tp+Z87J5N7zZeYhc+999p///P1UgKUQKkMUrwC5KnKqPK8obC6KwvNVKvgBXEUmKwiSJHG5QEIQWPAxHVykSlxNVlWVzgHCco2TkA521lUEqea2X359ghdttyYJSsauIJeTnZ17xNH9UQBssuw4MofsStKleHDt9tnZydnJI/AFVvCJCPZtG2yeAjuWeVaSbWLj41w2CFuWWD4tCzVadHx/hLgb3cEa5exHvu+IdE1IyksUHFx3mYnvD57En0wYtw5HU0uxXIWDCUObAIObm/Ob8wDYwIo/ByivGQQcXY1ldGvbZcxbxGAacTG9gDWNGARpk3FtuHdShls7LX0c4A9z8R+yesuBe6dlVTQ0/eCB2+ExxvA2TOqaIaopWQlk6yBkfHya4Xgc5axAVmKZUjiVYEzraja7ml2hNfyVYngQxFHeMhlC5RQqllmOBtn7GTO9TDBNJDyQaY7NysvejwT+9SN+Mu4t58vk9yTj698B1+NUmCySD1PMLpF7OUtHC+UvaQ7901P/MBMslN+VoFB+W4JC+XUJCuVXJSiU35SgSPbel8DLl03vQwmivyf2MPY/zWU/ehjYk9zrz2UvfJJ4Mej2P8+h3w2LAV6GyO5u/9sT9He7ZFiG8AJoNRsr66tb25vPMTa3t1bXVxpNKyyAeOnVyU6jB3oeoPYaHVKPSi9W9MFurjV6vZUcer3GWhPcqOhj7QZsi2x2Oms5dDpN0gI3bDd4owPb1HXL8kgMz7J03QQ3anRYixVdg2lpmmkuY5imprUYwxWjFos1d7ouuo5hMLkYhuOKdTpq7vhYIdN2XRSJXESxbtNyNFYsMtAsNEotMMQtMj7+0/wBhqFEdTwq5HEAAAAASUVORK5CYII="
                      alt=""
                    /><span>手机邮箱</span></a
                  >
                </li>
                <!-- <li class="_1nOGoZ4H" @click="goNav('/mine/perfunds')">
                  <a href="javascript:;" :class="url == '/mine/perfunds' ? '_1XA16vNq' : ''"
                    ><img
                      src="data:image/png;base64,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"
                      alt=""
                    /><span>个人资金明细</span></a
                  >
                </li> -->
                <li class="_1nOGoZ4H" @click="goNav('/mine/welfare')">
                  <a
                    ><img
                      src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADwAAAA8CAMAAAANIilAAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAELUExURUxpcf/////r6//e3P/j4//e3P/d3f/////r6//g3//k4P/d2//d2//////o6P/d2//e2//f3P/g4P/h4f/f3P/e3v/e3v/e3P/g4P/d2//d3P/g3P/e2//d3P/e3P/e2//e3P7V0/+wsP+vr/+0tP+8vP28vPWNjP/e2/3JyPSMjPN9ffu2tv/a2vednfegoP/GxvJ3d/+9vf/KyvJ6ev/Ozv+4uP/BwfFzc/N+fvOBgfioqPSIiPekpPOFhfFwcPeamv/Y2PiqqvWWlv/T0/+vr/Btbfmysv/h4fmvr/ejo/WPj/WTk/+zs//d3fSMjPitrfenp/m1tf/m5v7S0vu/v/vDw/u6uv+0tCPhdiAAAAAtdFJOUwABB5Ebbk0EDTEVzigCC+OySCAZYy49ahCCrEJX3sRVdaWs6O+x6+e7ldf09XFnSf4AAALRSURBVHja7dZbc5pAGIDhKkaBbGgFRMFzzodZwNj0EEIbqS0xpy5EJP//l/QjtCoDu+lMZtqbvOOF8zEPKxey++a11/5hpdLW1laNElwqlegUYLlcliS+IEmCSzXwFAtUQts73yntbCMJeIlmebR7l/R49/gUfFlvF/EUDbYl7n1gtie2QBctXOZFef+U2b4s8uWCpUs1SZSF04/MTgVZlGp5DAsrSIttZrGGFFi6ALdkoRraY0Z2WBXkViEWkdbx4zNGcdjRkFiA4ZFRWw1n0XSt+XQOnz/fIxKqbQQPXYCVRr0ZzrzFhNLCIWGz3lAKcSXBPglifF8QjgPiJ7hShPmKUN0A7LhkfJVrTFxn5ocbVaHC0/HMc1zLse8f1rq3Hct1vL/AxAtcyzRJdIavHh6u8FlETNO6DjzyHPYBEydwr4Gbl0+ZCXUDL8E+G89gZfjhoIFDIK3EBg7gGRsTktgggLX9qQ13cO2pn1qPQEzsQSl2FxjPCZljHLluANrx4AZMHABMKOSAm0zgDp4LBRBcZGIXuk6zgjGGxoH1e+BCTGwti2DRtEm0mjKxuWyOl81XUya+XOZEi4UNcLGInNWUib9lsjCOLzMTJr5dFq+eOV5Nmfhm2fozr6ZM/HOZFUdRhOFvEcXWasrEF5luMfazEyb+kukGcHbCxOeZLiY4yE6Y+HM2k5xnB0z8/pmY+GTE7CTFlFfv8Sdmx8mrl/rSPxp9ZTQ6Sl/6lO1GHx6MflAaHQz1dLuhbHQDzuhtdrtvc3W7mz2DGyQbHXWLVXXOOOxtFtQ7NDhdTbdYyubeb+rc0DDe5TKMIac3++nmTjlWtPvqQNe5gnR9oPbb6bGCcqARtGpHVZsbuZqq2qlqQnqgoRylZCRo7Xq9mqteb2sCktOjFOUQJyoyQo2GkKvRQEhWRJ51BJT4ligqSiWXoohii5cS+5KD60uPzP+/X9AROi2dPEaVAAAAAElFTkSuQmCC"
                      alt=""
                    />
                    <div class="_2WD_Lzxu"><span>红包</span></div>
                  </a>
                </li>
              </ul>
            </li>
          </ul>
          <!-- 右侧盒子 -->
          <div class="_2i9-Qvs8">
            <!-- 右侧头部 用户信息 -->
            <div class="_22uUZgTU">
              <div class="changImg">
                <input class="inputsw" type="file" @change="onchangemd" single accept="image/gif,image/png" />
                <div class="_3itQTA2z" style="background-image: url(image/my_vip0_box-b9b4.png)"><img class="_1qnyPlzh" :src="$store.state.userInfo.avatar ? $store.state.userInfo.avatar : '/static/image/CristianoRonaldo.jpg'" alt="" /><span class="_30Ip3J8d">更改头像</span></div>
              </div>
              <div class="ikNg-YzI">
                <div class="_3iwIA9K0">{{ $store.state.userInfo.username }}</div>
                <div class="jUXly5u7">
                  <span>账户余额：</span><strong>¥{{ $store.state.userInfo.balance }}</strong>
                </div>
              </div>
              <ul class="_1m15LZBk">
                <!-- <li>
                  <img
                    src="data:image/png;base64,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"
                    alt=""
                  /><span>基本资料:</span><i class="_3KIzgCFY" @click="goNav('/mine/userInfo')">未完善</i>
                </li> -->
                <li>
                  <img
                    src="data:image/png;base64,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"
                    alt=""
                  /><span>账户安全等级:</span><i class="RA6Dovxh">{{ level[$store.state.userInfo.level] }}</i>
                </li>
                <li>
                  <img
                    src="data:image/png;base64,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"
                    alt=""
                  /><span>密码修改:</span><i class="_3KIzgCFY" @click="goNav('/mine/password')">去修改</i>
                </li>
                <li>
                  <img
                    src="data:image/png;base64,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"
                    alt=""
                  /><span>银行卡:</span>
                  <i class="_3KIzgCFY" v-if="cardLis.length == 0" @click="goNav('/mine/bankCard')">未绑定</i>
                  <i class="_3KIzgCFY" v-else @click="goNav('/mine/bankCard')">去查看</i>
                </li>
                <li>
                  <img
                    src="data:image/png;base64,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"
                    alt=""
                  /><span>手机号:</span><i class="_3KIzgCFY" v-if="!$store.state.userInfo.mobile" @click="goNav(`/mine/contacts`)">去绑定</i>
                  <i class="RA6Dovxh" v-else>{{ $store.state.userInfo.mobile }}</i>
                </li>
                <li>
                  <img
                    src="data:image/png;base64,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"
                    alt=""
                  /><span>邮箱:</span><i class="_3KIzgCFY" v-if="!$store.state.userInfo.email" @click="goNav(`/mine/contacts`)">未绑定</i>
                  <i class="RA6Dovxh" v-else>{{ $store.state.userInfo.email }}</i>
                </li>
              </ul>
            </div>
            <!-- 模板内容 -->
            <router-view />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
// api_token: "9sg60db108o1zouMZFBWwLzzgbbm4tb35N2H3GFBSVTjbx3u0AwV48bPatLk"  //token
// avatar: ""       //头像
// balance: "0.00"  //余额
// birthday: null   //生日
// email: null      //邮箱
// fanshui: 0       //返水？？
// gameblance: 0    //游戏 金币 钱 ？
// joinday: 5       //加入天数 ？？
// level: 0         //等级 ？？
// mobile: null     //电话
// realname: "132456789"  //真实姓名
// transferstatus: 0      //类型 0 转账 1免转
// usdtrate: "6.42"       //存款usdt汇率
// username: "xinghe123456"  //用户名称
// vip: 0                     //vip等级
// vipname: "/static/style/vip0.png"  //vip等级图片?
// withdrawcashfee: "1"       //提款手续费（ERC20）
// withdrawfeeusdttrc: "10"   //提款手续费 （TRC20）
// withdrawusdtrate: "6.56"   //提款usdt汇率
export default {
  name: 'transRecord',
  data() {
    return {
      url: '',
      userInfo: {},
      cardLis: [],
      level: ['低', '一般', '高'],jumpUrl:null
    };
  },
  created() {
    let that = this;
    //  console.log(this.$store)

    that.url = this.$route.path;
    that.getcard();
    that.getUserInfo();
    that.getDatalist();
  },
  methods: {
        getAgentLoginUrl() {
      let that = this;
      that.$apiFun.get('/api/getAgentLoginUrl', {}).then(res => {
        if (res.code != 200) {
          that.showTost(res.message);
        }
        if (res.code == 200) {
          that.jumpUrl = res.data.url;
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
    onchangemd(e) {
      let that = this;

      console.log(e.target.files); //这个就是选中文件信息
      let formdata = new FormData();
      Array.from(e.target.files).map(item => {
        console.log(item);
        formdata.append('file', item); //将每一个文件图片都加进formdata
      });
      //  axios.post("接口地址", formdata).then(res => { console.log(res) })
      that.$apiFun.post('/api/uploadimg', formdata).then(res => {
        console.log(res);
        let userInfo = JSON.parse(localStorage.getItem('userInfo'));
        userInfo.avatar = res;
        localStorage.setItem('userInfo', JSON.stringify(userInfo));
        that.$store.commit('changUserInfo');
      });
    },
    goNav(url) {
      let that = this;
      // let urlStr = url.split('?')[0];
      if (url == this.$route.path) {
        return;
      }
      this.url = url;
      this.$router.push({ path: url });
    },
    getcard() {
      let that = this;
      that.$apiFun.post('/api/getcard', { type: 1 }).then(res => {
        if (res.code != 200) {
          that.showTost(res.message);
        }
        if (res.code == 200) {
          that.cardLis = res.data;
        }
      });
    },
    getUserInfo() {
      let that = this;
      that.$apiFun.post('/api/user', {}).then(res => {
        console.log(res);
        if (res.code !== 200) {
          that.showTost(res.message);
        }
        if (res.code === 200) {
                    let userInfo = res.data;
          let str =userInfo.current_vip ;
          let index = str.indexOf("P");
          let vip = str.substr(index + 1,str.length);   //04
          userInfo.vip = vip;
          localStorage.setItem('userInfo', JSON.stringify(userInfo));
          that.$store.commit('changUserInfo');
        }
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
    this.url = this.$route.path;
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
// 

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
.ant-tabs-nav .ant-tabs-tab {
  height: 46px;
}
.changImg {
  position: relative;
}
.inputsw {
  width: 100%;
  height: 100%;
  position: absolute;
  top: 0;
  left: 0;
  opacity: 0;
  z-index: 999;
}
</style>
