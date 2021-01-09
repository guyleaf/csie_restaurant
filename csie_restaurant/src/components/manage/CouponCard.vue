<template>
    <div>
        <b-card overlay class='m-2' style="min-width:360px; height:220px">
            <b-card-title>{{code}} 
                <a v-if="Date.parse(expire) < new Date()" style="font-weight:bold; font-size:15px; color:#DDDDDD; background-color:#880000;">已過期</a>
                <a v-if="Date.parse(start) > new Date()" style="font-weight:bold; font-size:15px; color:white; background-color:#003E3E;">尚未開始</a>
                <a v-if="Date.parse(expire)>new Date() && Date.parse(start)<new Date()" style="font-weight:bold; font-size:15px; color:white; background-color:#2828FF;">生效中</a>
            </b-card-title>
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
                        <b-button class="nooutline boption" size='sm' block  variant="primary" @click="showModal">修改</b-button>
                        <b-button class="nooutline boption" size='sm' block  variant="danger"  @click="deleteTHIS">刪除</b-button>
                    </b-button-group>
                </b-row>
                <!-- <b-icon icon="list" :id="'target-'+this.foodId" font-scale="1.2"/> -->
            </b-card-footer>
        </b-card>
        <b-modal id="modal-lg" size="lg" ref="my-modal" hide-header hide-footer hide-header-close>
            <div class="container">
                <div class="m-2">
                    <h4>優惠卷: {{code}}</h4> <b-button @click="check">Check</b-button>
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
                    <div class="row" v-if="typeSelected==0">
                        <div class="col-md-1 mt-2">滿額</div>
                        <b-form-input class="col-md-2" v-model="money" placeholder="XX元免運費" type="text" required></b-form-input>
                        <div class="col-md-1 mt-0 ml-0">使用次數</div>
                        <b-form-input class="col-md-3" v-model="usage" placeholder="消費者可用次數" type="text" required></b-form-input>
                    </div>
                    <div class="row" v-if="typeSelected==1">
                        <div class="col-md-1 mt-2">滿額</div>
                        <b-form-input class="col-md-2" v-model="money" placeholder="XX元打折" type="text"  required></b-form-input>
                        <div class="col-md-1 mt-2">折扣</div>
                        <b-form-input class="col-md-2" v-model="discount" placeholder="請輸入小數" type="text" required></b-form-input>
                        <div class="col-md-1 mt-0 ml-0">使用次數</div>
                        <b-form-input class="col-md-3" v-model="usage" placeholder="消費者可用次數" type="text" required></b-form-input>
                    </div>
                    <b-form-group label="優惠商品" v-if="typeSelected==2">
                        <div class="row mt-2" v-for="(item, index) in couponItems" v-bind:key="index">
                            <div class="col-md-7">
                                <b-form-select v-model="item.selected" :options="productOption" @change="setPrice(index,item.selected)"></b-form-select>
                            </div>
                            <div class="col-md-3">
                                <b-form-spinbutton :id="'sb_'+num" min="1" max="100" v-model="item.spinValue" @change="setTotal"></b-form-spinbutton>
                            </div>
                            <div class="col-md-1 mt-1">${{item.price*item.spinValue}}</div>
                        </div>
                        <div class="row ml-2 mt-2">
                            <b-button class="col-md-3" variant="outline-primary" @click="addcouponItems">新增欄位</b-button>
                            <b-button class="col-md-3 ml-4" variant="outline-danger" @click="deletecouponItems">移除欄位</b-button> 
                            <h2 class="col-md-2 mt-2 ml-5">總金額</h2>
                            <h2 class="col-md-1 mt-2" style="text-decoration:line-through;">{{total}}</h2>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-1 mt-2">折扣</div>
                            <b-form-input class="col-md-2" v-model="discount" placeholder="請輸入小數" type="text" required></b-form-input>
                            <h2 class="col-md-3 ml-5">折價後金額</h2>
                            <h2 class="col-md-2">{{Math.round(total*discount)}}</h2>
                        </div>
                    </b-form-group>
                    <div class="mt-3" style="display:flex; justify-content:space-around;">
                        <div style="display:inline-flex; flex-wrap:nowrap;"> 
                            <div class="mt-2 mr-3">開始時間 </div>
                            <div>
                                <date-picker v-if="Date.parse(start) > new Date()" v-model="startDate" :placeholder="start" :config="dateOption"></date-picker>
                                <date-picker v-else disabled :placeholder="start" v-model="startDate" :config="dateOption"></date-picker>
                            </div>
                        </div>
                        <div style="display:inline-flex; flex-wrap:nowrap;">
                            <div class="mt-2 mr-3">結束時間</div>
                            <div><date-picker v-model="expireDate" :placeholder="expire" :config="dateOption"></date-picker></div>
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
        total: 0,
        usage: 0,
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
        dateOption: {
            format: 'YYYY-MM-DD hh:mm:ss',
            sideBySide: true,
            useCurrent: false,
        },
        couponItems:[ { selected: null, spinValue:1, price:0 } ],
        productOption:[],
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
    },
    created(){
    },
    computed:{
    },
    methods:{
        showModal(){
            this.productOption=[];
            this.couponItems = [ { selected: null, spinValue:1, price:0 } ];
            let id =this.$store.getters['auth/user'].id
            this.$http.get('restaurants/'+id+'/products')
            .then(response => {
                console.log('openModalAPI');
                let data=response.data;
                for (let i=0;i<data.length;i++){
                    this.productOption.push({value:data[i].id, text:data[i].name, price:data[i].price});
                }
                console.log('productOption:',this.productOption)
                this.productOption = this.productOption.sort(function (a, b) {
                    return a.name - b.name
                });
                console.log(this.type)
                if(this.type==2){
                    console.log('INNN',this.products.length)
                    this.couponItems =[];
                    for(let i=0; i<this.products.length; i++){
                        let item = this.productOption.find(element => element.value == this.products[i].product_id);
                        // console.log(item)
                        this.couponItems.push({selected:this.products[i].product_id, spinValue:this.products[i].quantity, price:item.price})
                    }
                    this.setTotal();
                    console.log('CREATED',this.couponItems);
                } 
            })
            this.$refs['my-modal'].show();
        },
        checkForm(){
            
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
            }
            
            if(this.money == undefined) this.money = null; 
            if(parseInt(this.typeSelected) == 0) this.discount = 1;
            this.couponAll['coupon'] = {id:this.coupon_id, code:this.code, start_time:this.start, end_time:this.expire, numberOfUsage: parseInt(this.usage,10), 
                                    type:parseInt(this.typeSelected,10), discount:parseFloat(this.discount), limit_money:parseInt(this.money,10) };
            if(this.typeSelected ==2 ){
                this.info = [];
                this.couponAll['coupon'].limit_money=null;
                for (let i = 0; i<this.couponItems.length; i++){
                    this.info.push({product_id:this.couponItems[i].selected, quantity:this.couponItems[i].spinValue})
                }
                this.couponAll['coupon_items'] = this.info;
            }
            this.$refs['my-modal'].hide();
            this.$emit('updateCoupon', this.couponAll)
        },
        cancelModal(){
            this.$refs['my-modal'].hide();
        },
        deleteTHIS(){
            //api delete
            this.$confirm("你確定要刪除？","","question").then(() =>{
                let couponDelete = {"coupon":{id: this.coupon_id} };
                this.$emit('deleteCoupon', couponDelete)
            })
        },
        addcouponItems(){
            this.couponItems.push({ selected: null, spinValue:1, price:0 })
        },
        deletecouponItems(){
            this.couponItems.splice(-1,1);
        },
        setPrice(index, selected){
            let optionIndex = this.productOption.findIndex(i => i.value === selected)
            this.couponItems[index].price = this.productOption[optionIndex].price;
            this.setTotal();
        },
        setTotal(){
            // console.log('total',this.total)
            this.total = 0;
            for(let i=0; i<this.couponItems.length; i++){
                this.total += this.couponItems[i].price * this.couponItems[i].spinValue;
            }
        }
    },
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
.nooutline{
    outline: none !important;
    box-shadow: none !important;
}
</style>