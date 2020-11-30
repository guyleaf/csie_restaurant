<template>
    <div class='container'>
        <div class='row '>
            <div class='tag'>
                13213232131
            </div>
        </div>
        <div class='row'>
           <div class='desField'>
               <div class='desStyle'>
                   {{description}}
               </div>
           </div>
        </div>
    </div>
</template>

<script>
    export default {
    name: 'ShopDescription',
    props:{
        description:String
        
    }
}
</script>

<style scoped>
.container{
    margin: 2% 5% 2% 5%;
    
}

.desField{
    background-color: #FFFFFF !important;
    overflow-x: visible;
    overflow-y: scroll;
    width :90%;
    height: 200px;
}
.desStyle{
    padding:2%;
    font-size: 24px;
}
.tag{
    background-color: #FFFFFF !important;
    margin: 1% 0 1% 0;
    padding-left: 10%;
}
</style>


