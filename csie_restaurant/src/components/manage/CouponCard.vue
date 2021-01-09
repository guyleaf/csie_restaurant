<template>
    <div>
        <b-card overlay class='m-2' style="min-width:360px; height:220px">
            <b-card-title>{{code}} 
                <a v-if="Date.parse(expire) < new Date()" style="font-weight:bold; font-size:15px; color:#DDDDDD; background-color:#880000;">已過期</a></b-card-title>
            <!-- 0 for免運 1for滿XXX折扣 2for套餐組合><-->
            <b-card-text v-if="type === 0">
                <a>滿{{limitMoney}}元 </a><a style="color:red;">免運費</a>
            </b-card-text>
            <b-card-text v-if="type === 1">
                <a>滿{{limitMoney}}元 </a><a style="color:red;">{{showDiscount}}%off</a>
            </b-card-text>
            <b-card-text v-if="type === 2">
                <a v-for="(product, index) in products" :key="product.product_id">
                    {{product.quantity}} {{product.name}}
                    <a v-if="index != products.length-1 ">+</a>  
                </a>
                <a style="color:red;">{{showDiscount}}%off</a>
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
                     <b-form-group
                        v-if="typeSelected==2"
                        label="優惠商品"
                        >
                        <div :id="'coupon_product_'+num" class="row cp_pd" v-for="num in couponProductNum" :key="num">
                            <div class="col-md-8 ">
                                <b-form-input :id="'option_'+num" :list="'my-list-id_'+num" ></b-form-input>
                                    <datalist :id="'my-list-id_'+num" >
                                    <option v-for="product in allProducts" :key="product.id" > {{product.name}}</option>
                                </datalist>
                            </div>
                            <div class="col-md-4">
                                <b-form-spinbutton :id="'sb_'+num" min="1" max="100" :v-model="spinValue"></b-form-spinbutton>
                            </div>
                        </div>
                        <b-button variant="outline-primary" @click="addCouponProduct">新增優惠商品</b-button>
                    </b-form-group>
                    <a v-if="typeSelected==1 || typeSelected==2">折扣(請輸入小數)</a><b-form-input v-if="typeSelected ==1||typeSelected ==2" v-model="discount" :placeholder="discount+discountHint" type="text" style="width:50%;" required></b-form-input>
                    <div class="mt-3" style="display:flex; justify-content:space-around;">
                        <div style="display:inline-flex; flex-wrap:nowrap;"> 
                            <div class="mt-2 mr-3">開始時間 </div>
                            <div>
                                <date-picker v-if="Date.parse(start) > new Date()" v-model="startDate" :placeholder="start" :config="options"></date-picker>
                                <date-picker v-else disabled :placeholder="start" v-model="startDate" :config="options"></date-picker>
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
        startDate: this.start,
        expireDate: this.expire,
        money: this.limitMoney,
        id: this.coupon_id,
        info:[],    
        couponAll:{'coupon':{}, "coupon_items":null },
        showDiscount: Math.round((1-this.discount)*100),
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
        couponProductNum:1,
        spinValue:1,
      }
    },
    props:{
        coupon_id: Number,
        code: String,
        products: Array,
        discount: String,
        limitMoney: String,
        start: String,
        expire: String,
        type: Number,
        allProducts: Array,
        allProductName: Array,
    },
    created:{

    },
    computed:{
    },
    methods:{
        showModal(){
            this.$refs['my-modal'].show();
        },
        checkForm(){
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
        },
        confirmModal(){
            //api update
            this.checkForm();
            
            if(this.money == undefined) this.money = null; 
            if(parseInt(this.typeSelected) == 0) this.discount = 1;
            this.couponAll['coupon'] = {id:this.coupon_id, code:this.code, start_time:this.start, end_time:this.expire, numberOfUsage: 100, //FIXME numberOfUsae
                                    type:parseInt(this.typeSelected), discount:parseFloat(this.discount), limit_money:this.money };
            if(this.typeSelected ==2 ){
                this.info=[];
                for (let i = 1; i<this.couponProductNum+1; i++){
                    let name = document.querySelector('#option_'+i).value
                    let spinValue = document.querySelector('#sb_'+i).value
                    let index = this.allProductName.indexOf(name)
                    console.log(index, this.allProducts[index].name);
                    console.log(index, this.allProducts[index].id);
                    console.log(index, spinValue);
                    this.info.push({coupon_id:this.coupon_id ,product_id:this.allProducts[index].id, quantity:parseInt(spinValue)})
                    // couponAll['coupon_items'].push({product_id:this.allProducts[index].id, quantity:spinValue})
                }
                this.couponAll['coupon_items'] = this.info;
            }
            // console.log('updateCoupon2:', this.couponAll);
            //api
            // this.$emit('updateAPI', this.couponAll)
            this.$http.post('/seller/coupons/update',this.couponAll,{
                headers: {
                'Authorization': 'Bearer ' + this.$store.getters['auth/token'],
                }
            }).then(response=>{
                this.$emit('recallCouponAPI')
                console.log('update Success');
                // this.recall();
            })
            .catch(error=>{
                console.log(error.response)
            })
        },
        cancelModal(){
            this.$refs['my-modal'].hide();
        },
        deleteCoupon(){
            //api delete
            let couponDelete = {"coupon":{id: this.coupon_id} };
            this.$http.post('/seller/coupons/delete', couponDelete,{
                headers: {
                'Authorization': 'Bearer ' + this.$store.getters['auth/token'],
                }
            }).catch(error=>{
                console.log(error.response)
            })
            console.log('afterDelete',couponDelete);
        },
        addCouponProduct(){
            this.couponProductNum +=1;
        },
        recall(){
            this.$http.post('/seller/coupons/add',couponAll,{
                headers: {
                'Authorization': 'Bearer ' + this.$store.getters['auth/token'],
                }
            }).then(response =>{
                console.log('recall Success')
            }).catch(error=>{
                console.log(error.response)
            })
        },
    },
    updated(){ //data()有值改動就會觸發  //created裡面才產生的值不會觸發
        console.log('sth change');
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
.cp_pd{
    margin-bottom:1%;
}
</style>