<template>
    <div>
        <b-tabs content-class="mt-3">
            <b-tab v-for="(item,index) in tabs" :key="index" :title="item.title" :name="index" @click="jump(index)"></b-tab>
        </b-tabs>
        <div class="scroll-content">
            <div class="item-content">
                <p style="height:40px" v-for="item in [0,1,2,3,4,5,6,7,8,9,10]" :key="item">1</p>
            </div>
            <div class="item-content">
                <p style="height:40px" v-for="item in [0,1,2,3,4,5,6,7,8,9,10]" :key="item">2</p>
            </div>
            <div class="item-content">
                <p style="height:40px" v-for="item in [0,1,2,3,4,5,6,7,8,9,10]" :key="item">3</p>
            </div>
        </div>
    </div>
</template>


<script>
  export default {
      name:'CategoryTab',
    data() {
      return {
          isActive: 0,
         tabs: [
          {
            title: 'First'
          },
          {
            title: 'Second'
          },
          {
            title: 'Third'
          }
        ],
        }
    },
    methods: {
        jump(index) 
        {
            let scrollItems = document.querySelectorAll('.item-content')
            let totalY = scrollItems[index].offsetTop - document.body.scrollTop
            let distance = document.documentElement.scrollTop
            let step = totalY / 50
            document.documentElement.scrollTop=distance
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
            let scrollItems = document.querySelectorAll('.item-content')
            let scrollTop =document.documentElement.scrollTop
            for(var i=scrollItems.length-1;i>=0;i--)
            {
                var ItmeY = scrollItems[i].offsetTop - document.body.scrollTop
                if(scrollTop>ItmeY) 
                {
                    this.isActive=i
                    break
                }
            }
            let tab = document.querySelectorAll('.nav-item>a')
            console.log(tab)
            for(i=tab.length-1;i>=0;i--)   if(tab[i].className.indexOf("active") >= 0){tab[i].classList.remove("active") } 
            tab[this.isActive].classList.add("active")

        },
    },
    mounted () {
    window.addEventListener('scroll', this.handleScroll)
    },
    destroyed () {
    window.removeEventListener('scroll', this.handleScroll)
    },
}
</script>