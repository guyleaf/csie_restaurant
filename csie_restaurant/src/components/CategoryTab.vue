<template>
<div>
    <b-tabs content-class="mt-3">
        <b-tab v-for="item in tabList" :key="item.id" title=item.name></b-tab>
    </b-tabs>
    <div class="item-content">
    <div>11111111</div>
    </div>
    <div class="item-content">
    <div>22222</div>
    </div>
    <div class="item-content">
    <div>33333</div>
    </div>
    <div class="item-content">
    <div>44444</div>
    </div>
    <div class="item-content">
    <div>555555</div>
    </div>
</div>
</template>

<script>
  export default {
    data() {
      return {
        tabList:[{
            id:1,
            name:'详情'
            },{
            id:2,
            name:'评论'
            },{
            id:3,
            name:'新闻'
            },{
            id:4,
            name:'关于'
            },{
            id:5,
            name:'相关'
            }],
        }
    },
    handleScroll(){  
        let scrollTop = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop;  
        this.headerFixed = scrollTop > this.offsetTop;  
        for (let i = 0; i < this.arrDom.length; i++) {  
        //因为下面使用到了i+1，所以需要把最后一个分离出来判断  
        if(this.arrDom[this.arrDom.length-1].offsetTop-scrollTop>80){  
        if(this.arrDom[i].offsetTop-scrollTop<=80&&this.arrDom[i+1].offsetTop-scrollTop>80){  
        this.active = i+1  
        }  
        }else{  
        this.active = this.arrDom.length;  
        }  
        
        }  
        },
      mounted(){  
        //记录每个内容对用的dom数组  
        this.arrDom = document.getElementsByClassName("line-title");  
        window.addEventListener('scroll', this.handleScroll);  
        },  
            
        destroyed(){  
        window.removeEventListener('scroll', this.handleScroll);  
        },
  }