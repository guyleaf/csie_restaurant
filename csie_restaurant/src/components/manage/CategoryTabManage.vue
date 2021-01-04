<template>
    <div>
        <b-row>
            <b-col md="8"><CategoryTab :foodCategory='foodCategory'/></b-col>
            <b-col md="4">
                <button @click="addTab">+</button>
            </b-col>
        </b-row>
    </div>
</template>

<script>
import CategoryTab from "@/components/CategoryTab.vue";
  export default {
      name:'CategoryTabManage',
      props:{
          foodCategory:Array,
      },
      components:{
          CategoryTab,
      },
    data() {
      return {
        }
    },
    // methods: {
    //     jump(index) 
    //     {
    //         let scrollItems = document.querySelectorAll('h1')
    //         let header = document.querySelectorAll('nav')
    //         let totalY = scrollItems[index].offsetParent.offsetTop+scrollItems[index].offsetTop+header[0].clientHeight
    //         let distance = document.documentElement.scrollTop
    //         let step = totalY / 50
    //         document.documentElement.scrollTop=distance
    //         if (totalY > distance) 
    //         {
    //             smoothDown(document.documentElement)
    //         } 
    //         else 
    //         {
    //             let newTotal = distance - totalY
    //             step = newTotal / 50
    //             smoothUp(document.documentElement)
    //         }
    //         function smoothDown(element) 
    //         {
    //             if (distance < totalY) 
    //             {
    //                 distance += step
    //                 element.scrollTop = distance
    //                 setTimeout(smoothDown.bind(this, element), 10)
    //             } 
    //             else element.scrollTop = totalY
    //         }
    //         function smoothUp(element) 
    //         {
    //             if (distance > totalY) 
    //             {
    //                 distance -= step
    //                 element.scrollTop = distance
    //                 setTimeout(smoothUp.bind(this, element), 10)
    //             } 
    //         else element.scrollTop = totalY
    //         }
    //     },
    //     handleScroll () 
    //     {
    //         let scrollItems = document.querySelectorAll('h1')
    //         let header = document.querySelectorAll('nav')
    //         let scrollTop =document.documentElement.scrollTop
    //         for(var i=scrollItems.length-1;i>=0;i--)
    //         {
    //             var ItmeY = scrollItems[i].offsetParent.offsetTop+scrollItems[i].offsetTop+header[0].clientHeight
    //             if(scrollTop>ItmeY) 
    //             {
    //                 this.isActive=i
    //                 break
    //             }
    //         }
    //         let tabClass = document.querySelector('.CategoryTab')
    //         let tab = tabClass.querySelectorAll('.nav-item>a')
    //         for(i=tab.length-1;i>=0;i--)   if(tab[i].className.indexOf("active") >= 0){tab[i].classList.remove("active") } 
    //         tab[this.isActive].classList.add("active")

    //     },
    // },
    mounted () {
    window.addEventListener('scroll', this.handleScroll)
    },
    destroyed () {
    window.removeEventListener('scroll', this.handleScroll)
    },
}
</script>