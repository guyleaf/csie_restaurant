<template>
    <b-nav-form class="ml-auto">
        <b-dropdown :text="text">
            <b-dropdown-item @click="search(1)">今天</b-dropdown-item>
            <b-dropdown-item @click="search(7)">最近7天</b-dropdown-item>
            <b-dropdown-item @click="search(30)">最近30天</b-dropdown-item>
        </b-dropdown>
    </b-nav-form>
</template>

<script>
export default {
    name: "Dropdown",
    data(){
        return{
            text:"查詢時間"
        }
    },
    methods: {
        search(day){
            let dropdown = document.querySelector('.b-dropdown>button>#text')
            if(day==1)  this.text="今天"
            if(day==7)  this.text="最近7天"
            if(day==30)  this.text="最近30天"
        }
    },
}
</script>
