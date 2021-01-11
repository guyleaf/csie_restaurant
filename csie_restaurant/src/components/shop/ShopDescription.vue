<template>
    <div class='container' id="shopbody">
        <div class='row'>
            <div class='tag'>關於賣場</div>
        </div>
        <div class='row justify-content-start'>
            <div class='about col'>
                <b-card
                    overlay 
                    title="SHOP"
                    title-tag="h5"
                    :img-src= "imgPath"
                    img-alt="Card Image"
                    img-width="300"
                    img-height="150"
                    :sub-title="shopName"
                    sub-title-tag="h3"
                    text-variant="white"
                    sub-title-text-variant="white"
                    class="text-center"
                    style= "font-family: Lucida Console, Courier, monospace font-weight: bold;"
                    >
                </b-card>
                <div class='grid-container'>
                        <div class ='grid-item'>商品:{{commodity}}</div>
                        <div class ='grid-item'>粉絲:{{fans}}</div>
                        <div class ='grid-item'>評分:{{rate}}({{numberOfRatings}})</div>
                        <div class ='grid-item'>加入時間:{{joinDate}}</div>
                </div>
            </div>
            <div class='desField col-md-6'>
                <b-modal id="modal-lg" size="lg" ref="my-modal" hide-header hide-footer hide-header-close>
                    <div class="container" style="height:500px">
                        <div class="m-1" style="height:100%">
                            <b-form-group
                                label="Name"
                                label-for="name-input"
                                invalid-feedback="name is required" type="text"
                                >
                            </b-form-group>
                            <b-form-textarea
                                    no-resize
                                    id="textarea-plaintext"
                                    ref="name-input"
                                    style="height:80%"
                                    debounce="500"
                                    :value="description"
                                    required>
                                </b-form-textarea>
                        </div>
                    </div>
                </b-modal>
               <div class='desStyle' @click="showModal">
                   <b-form-textarea
                        no-resize
                        id="textarea-plaintext"
                        ref="name-input"
                        plaintext
                        style="height:100%; width:100%"
                        debounce="500"
                        :value="description"
                    />
               </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
    name: 'ShopInfo',
    props:{
        description:String,
        shopName: String,
        imgPath: String,
        fans: Number,
        joinDate: String,
        rate: Number,
        numberOfRatings: Number,
        // editable: Boolean,
    },
    data(){
        return{
            commodity:0,
        }
    },
    methods:{
        showModal() {
            this.$refs['my-modal'].show();
        },
    },
    created(){
        this.$bus.$on('productsNumber',num =>{
            this.commodity=num}
        )
    }
}
</script>

<style scoped>
.container{
    margin: 2% 0 2% 0;
}
.row{
    padding-left: 2%;
    padding-right:2%;
    background-color: #FFFFFF !important;
}
.desField{
    overflow-x: visible;
    overflow-y: scroll;
    padding:  1%;
    margin:0% 2% 3% 0;
    border-width: 2px;
    border-color: #000000;
    height: 250px;
}
.desStyle{
    line-height: 1.25rem;
    font-family: Arial, Helvetica, sans-serif;
    font-size: .675rem;
    height: 100%;
}
.tag{
    color: #d0011b;
    font-size: .675rem;
    font-family: Helvetica Neue,Helvetica,Arial,文泉驛正黑,WenQuanYi Zen Hei,Hiragino Sans GB,儷黑 Pro,LiHei Pro,Heiti TC,微軟正黑體,Microsoft JhengHei UI,Microsoft JhengHei,sans-serif;
    font-weight:bolder;
    margin-bottom: 0;
    background-color: #FFFFFF !important;
    padding:1% 0 0 1%;
}
.grid-container {
  display: grid;
  margin-left: 0%;
  grid-template-columns: 50% 50%;
  color: #FFFFFF;
  padding: 10px 0 10px 0;
}
.grid-item {
  padding: 5% 0 0 0 ;
  font-size: 20px;
  font-weight: bold;
  text-align:initial;
  color: #000000;
}


</style>


