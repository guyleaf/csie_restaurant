<template>
    <div>
        <b-tabs content-class="mt-3" class="CategoryTab">
            <b-tab v-for="(item,index) in foodCategory" :key="index" :title="item.foodCategory" :name="index" @click="jump(index)"></b-tab>
        </b-tabs>
    </div>
</template>


<script>
  export default {
      name:'CategoryTab',
      props:{
          foodCategory:Array,
      },
    data() {
      return {
          isActive: 0,
          lastScrollY: 0,
          tabs: [],
        }
    },
    methods: {
        jump(index) 
        {
            let scrollItems = document.querySelectorAll('#category')
            let header = document.querySelectorAll('nav')
            let tabClass = document.querySelector('.CategoryTab')
            let tabBar = tabClass.querySelector('ul')
            let totalY = scrollItems[index].offsetTop-tabBar.clientHeight
            console.log(totalY)
            let distance = document.documentElement.scrollTop
            let step = Math.abs(totalY-distance) / 50
            if (totalY > distance) 
            {
                smoothDown(document.documentElement)
            } 
            else 
            {
                let newTotal = distance - totalY
                step = newTotal / 50
                smoothUp(document.documentElement)
            }
            function smoothDown(element) 
            {
                if (distance < totalY) 
                {
                    distance += step
                    element.scrollTop = distance
                    setTimeout(smoothDown.bind(this, element), 10)
                } 
                else element.scrollTop = totalY
            }
            function smoothUp(element) 
            {
                if (distance > totalY) 
                {
                    distance -= step
                    element.scrollTop = distance
                    setTimeout(smoothUp.bind(this, element), 10)
                } 
            else element.scrollTop = totalY
            }
        },
        handleScroll () 
        {
            let scrollItems = document.querySelectorAll('#category')
            let header = document.querySelectorAll('nav')
            let scrollTop =document.documentElement.scrollTop
            for(var i=scrollItems.length-1;i>=0;i--)
            {
                var ItmeY = scrollItems[i].offsetTop
                if(scrollTop>=ItmeY-400) 
                {
                    this.isActive=i
                    break
                }
            }
            let tabClass = document.querySelector('.CategoryTab')
            let mainheader = document.querySelector('.html>.navigation')
            let headerHeight= mainheader.clientHeight.toString() +'px'
            let tabBar = tabClass.querySelector('ul')
            let tab = tabClass.querySelectorAll('.nav-item>a')
            let couponTab = document.querySelector('#couponTab')
            var st = scrollTop;
            if(scrollTop>couponTab.offsetTop+couponTab.clientHeight && st <= this.lastScrollY) {tabBar.classList.add("categoryTabs"); tabBar.style.top=headerHeight; tabBar.style.width=mainheader.clientWidth.toString() + 'px'}
            else {tabBar.classList.remove("categoryTabs"); tabBar.style.top=""; tabBar.style.width=""}
            this.lastScrollY = st;
            for(i=tab.length-1;i>=0;i--)   if(tab[i].className.indexOf("active") >= 0){tab[i].classList.remove("active") } 
            if(tab[this.isActive]!=null) tab[this.isActive].classList.add("active")
            
        },
    },
    created(){
        for(let i=0;i<this.foodCategory.length;i++)
            this.tabs.push({title:this.foodCategory[i].tag})
    },
    mounted () {
    window.addEventListener('scroll', this.handleScroll)
    },
    destroyed () {
    window.removeEventListener('scroll', this.handleScroll)
    },
}
</script>