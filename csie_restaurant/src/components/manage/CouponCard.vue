<template>
    <div>
        <b-card overlay class='m-2' style="min-width:360px; height:220px">
            <b-card-title>{{code}}</b-card-title>
            <!-- 0 for免運 1for滿XXX折扣 2for套餐組合><-->
            <b-card-text v-if="type === 0">
                <a>滿{{limitMoney}}元 </a><a style="color:red;">免運費</a>
            </b-card-text>
            <b-card-text v-if="type === 1">
                <a>滿{{limitMoney}}元 </a><a style="color:red;">{{discount*100}}%off</a>
            </b-card-text>
            <b-card-text v-if="type === 2">
                <a v-for="(product, index) in products" :key="product.product_id">
                    {{product.quantity}} {{product.name}}
                    <a v-if="index != products.length-1 ">+</a>  
                </a>
                <a style="color:red;">{{discount*100}}%off</a>
            </b-card-text>
            <b-card-text>開始:{{start}}</b-card-text>
            <b-card-text>結束:{{expire}}</b-card-text>
            <b-card-footer footer-bg-variant="gray" footer-border-variant="white" class="couponCardHeader">
                <b-row class='brow'>
                    <b-button-group class="bgoption">
                        <b-button size='sm' block  class="boption" variant="primary" @click="showModal">修改</b-button>
                        <b-button size='sm' block  class="boption" variant="danger"  @click="deleteCoupon">刪除</b-button>
                    </b-button-group>
                </b-row>
                <!-- <b-icon icon="list" :id="'target-'+this.foodId" font-scale="1.2"/> -->
            </b-card-footer>
        </b-card>
        <b-modal id="modal-lg" size="lg" ref="my-modal" hide-header hide-footer hide-header-close>
            <div class="container">
                <div class="m-2">
                    <h4>優惠卷: {{code}}</h4>
                    <br>
                    <b-form-group class="mb-3"
                    label="優惠類型"
                    label-for="type-input"
                    invalid-feedback="type is required">
                    <b-form-radio-group v-model="typeSelected">
                    <div style="display:flex; justify-content:space-around;">
                        <b-form-radio value="0">滿額免運費</b-form-radio>
                        <b-form-radio value="1">滿額打折</b-form-radio>
                        <b-form-radio value="2">優惠套餐</b-form-radio>
                    </div>
                    </b-form-radio-group>
                    </b-form-group>
                    <a v-if="typeSelected==0">滿額</a><b-form-input v-if="typeSelected==0" v-model="money" :placeholder="limitMoney+shipFreeHint" type="text" style="width:50%;" required></b-form-input>
                    <a v-if="typeSelected==1">滿額</a><b-form-input v-if="typeSelected==1" v-model="money" :placeholder="limitMoney+limitHint" type="text" style="width:50%;" required></b-form-input>
                    <a v-if="typeSelected==1">折扣</a><b-form-input v-if="typeSelected==1" v-model="discount" :placeholder="discount+discountHint" typeSelected="text" style="width:50%;" required></b-form-input>
                     <b-form-group
                        v-if="typeSelected==2"
                        label="新增商品"
                        >
                        <div :id="'coupon_product_'+num" class="row cp_pd" v-for="num in productNum" :key="num">
                            <div class="col-md-8 ">
                                <b-form-input :id="'option_'+num" :list="'my-list-id_'+num" v-model="option"></b-form-input>
                                    <datalist :id="'my-list-id_'+num" >
                                    <option v-for="size in sizes" :key="size" > {{size}}</option>
                                </datalist>
                            </div>
                            <div class="col-md-4">
                                <b-form-spinbutton :id="'sb_'+num" min="1" max="100" :v-model="spinValue"></b-form-spinbutton>
                            </div>
                        </div>
                    </b-form-group>
                    <div class="mt-3" style="display:flex; justify-content:space-around;">
                        <div style="display:inline-flex; flex-wrap:nowrap;"> 
                            <div class="mt-2 mr-3">開始時間 </div>
                            <div>
                                <date-picker v-if="Date.parse(start) > new Date()" v-model="startDate" :placeholder="start" :config="options"></date-picker>
                                <date-picker v-else disabled :placeholder="start" :config="options"></date-picker>
                            </div>
                        </div>
                        <div style="display:inline-flex; flex-wrap:nowrap;">
                            <div class="mt-2 mr-3">結束時間</div>
                            <div><date-picker v-model="expireDate" :placeholder="expire" :config="options"></date-picker></div>
                        </div>
                    </div>
                    <div class="row m-2" style="justify-content:space-around">
                        <b-button variant="primary" @click="confirmModal" size="sm">修改</b-button>
                        <b-button variant="info" @click="cancelModal" size="sm">取消</b-button>
                    </div>
                </div>
            </div> 
        </b-modal>
    </div>
</template>

<script>
import datePicker from 'vue-bootstrap-datetimepicker';
import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';
export default {
    name: 'CouponCard',
    components:{
        datePicker,
    },
    data() {
      return {
        info:{},    
        shipFreeHint:'元免運費',
        limitHint:'元',
        discountHint:'(請輸入小數)',
        typeSelected: this.type,
        options: {
            format: 'YYYY-MM-DD hh:mm:ss',
            sideBySide: true,
            useCurrent: false,
        },
        couponProduct:[],
        spinValue:1,
        productNum:3,    
        sizes: ['Small', 'Medium', 'Large', 'Extra Large']
      }
    },
    props:{
        id: Number,
        code: String,
        products: Array,
        discount: Number,
        limitMoney: Number,
        start: Date,
        expire: Date,
        type: Number,
    },
    created:{
        
    },
    computed:{
    },
    methods:{
        /*show(){
            console.log(code);
            
                    code: String,
        products: Array,
        discount: Number,
        limitMoney: Number,
        start: Date,
        expire: Date,
        type: Number,
        }*/
        showModal(){
            this.$refs['my-modal'].show();
        },
        confirmModal(){
            //api update
            if(Date.parse(this.start) > new Date()){  //兩個時間都要填寫
                if (this.startDate > this.expireDate){
                    this.$fire({
                        type: 'warning',
                        title: '日期錯誤',
                        text: '結束時間必須大於開始時間',
                    })
                    return
                }
                if(this.startDate == undefined) {this.$fire({type: 'warning',title: '填寫錯誤',text: '請填寫開始時間',})
                    return
                }
                if(this.expireDate == undefined) {this.$fire({type: 'warning',title: '填寫錯誤',text: '請填寫結束時間',})
                    return
                }
                this.start = this.startDate;
                this.expire = this.expireDate;
                this.$refs['my-modal'].hide();
            }
            else{ //只填結束時間
                if (Date.parse(this.expireDate) < new Date()){
                    this.$fire({
                        type: 'warning',
                        title: '日期錯誤',
                        text: '結束時間必須大於現在',
                    })
                    return
                }
                if(this.expireDate == undefined ) {
                    this.$fire({
                        type: 'warning',
                        title: '填寫錯誤',
                        text: '請填寫結束時間',
                    })
                    return
                }
                this.expire = this.expireDate;
                this.$refs['my-modal'].hide();
            }
            for (let i = 1; i<this.productNum+1; i++){
                let option = document.querySelector('#option_'+i).value
                let spinValue = document.querySelector('#sb_'+i).value
                this.couponProduct.push({option:option, spinValue:spinValue})
            }
            console.log(this.couponProduct)
    /*"coupon": {
      "id": 12,
      "code": "bPhZha",
      "start_time": "2020-10-09 16:00:00",
      "end_time": "2020-10-09 16:00:00",
      "type": 2,
      "discount": "0.8",
      "limit_money": null
    },
    "coupon_items": [
      {
        "coupon_id": 12,
        "product_id": 7,
        "quantity": 1,
        "name": "蜂蜜鬆餅"
      }
    ]
  },*/
            this.info = {'coupon':{code:this.code, start_time:this.start, end_time:this.expire, type:this.type, discount:this.discount, limit_money:this.limitMoney}}
            //api
            this.$http.post('/seller/coupons/update',this.info,{
                headers: {
                'Authorization': 'Bearer ' + this.$store.getters['auth/token'],
                }
            }).catch(error=>{
                console.log(error.response)
            })
        },
        cancelModal(){
            this.$refs['my-modal'].hide();
        },
        deleteCoupon(){
            //api delete
        }
    }
}
</script>

<style scoped>
.couponCardHeader{
    padding: 0rem;
    z-index: 101;
}
.bgoption{
    padding:0px; 
    width:100%;
}
.boption{
    margin:0;
}
</style>