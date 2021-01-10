<template>
    <div>
        <b-card overlay class='m-2' style="min-width:360px; height:220px">
            <b-card-title>{{code}} 
                <a v-if="Date.parse(expire) < new Date()" style="font-weight:bold; font-size:15px; color:#DDDDDD; background-color:#880000;">已過期</a>
                <a v-if="Date.parse(start) > new Date()" style="font-weight:bold; font-size:15px; color:white; background-color:#003E3E;">尚未開始</a>
                <a v-if="Date.parse(expire)>new Date() && Date.parse(start)<new Date()" style="font-weight:bold; font-size:15px; color:white; background-color:#2828FF;">生效中</a>
                <a style="margin-left:30px; font-size:10px">每人可用次數：</a><a style="font-weight:bold; font-size:18px;">{{usage}}</a>
            </b-card-title>
            <!-- 0 for免運 1for滿XXX折扣 2for套餐組合><-->
            <b-card-text v-if="type == 0">
                <a>滿{{limitMoney}}元 </a><a style="color:red;">免運費</a>
            </b-card-text>
            <b-card-text v-if="type == 1">
                <a>滿{{limitMoney}}元 </a><a style="color:red;">{{showDiscount}}%off</a>
            </b-card-text>
            <b-card-text v-if="type == 2">
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
                    <h4>優惠卷: {{code}}</h4>
                    <br>
                    <b-form-group class="mb-3"
                    label="優惠類型"
                    label-for="type-input"
                    invalid-feedback="type is required">
                    <b-form-radio-group v-model="type">
                    <div style="display:flex; justify-content:space-around;">
                        <b-form-radio value="0">滿額免運費</b-form-radio>
                        <b-form-radio value="1">滿額打折</b-form-radio>
                        <b-form-radio value="2">優惠套餐</b-form-radio>
                    </div>
                    </b-form-radio-group>
                    </b-form-group>
                    <div class="row" v-if="type==0">
                        <div class="col-md-1 mt-2">滿額</div>
                        <b-form-input class="col-md-2" v-model="limitMoney" placeholder="XX元免運費" type="text" required></b-form-input>
                        <div class="col-md-1 mt-0 ml-0">使用次數</div>
                        <b-form-input class="col-md-3" v-model="numberOfUsage" placeholder="每人可用次數" type="text" required></b-form-input>
                    </div>
                    <div class="row" v-if="type==1">
                        <div class="col-md-1 mt-2">滿額</div>
                        <b-form-input class="col-md-2" v-model="limitMoney" placeholder="XX元打折" type="text"  required></b-form-input>
                        <div class="col-md-1 mt-2">折扣</div>
                        <b-form-input class="col-md-2" v-model="discount" placeholder="請輸入小數" type="text" required></b-form-input>
                        <div class="col-md-1 mt-0 ml-0">使用次數</div>
                        <b-form-input class="col-md-3" v-model="numberOfUsage" placeholder="每人可用次數" type="text" required></b-form-input>
                    </div>
                    <b-form-group label="優惠商品" v-if="type==2">
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
                            <div class="col-md-1 mt-0 ml-0">使用次數</div>
                            <b-form-input class="col-md-3" v-model="numberOfUsage" placeholder="每人可用次數" type="text" required></b-form-input>
                            <h2 class="col-md-3">折價後金額</h2>
                            <h2 class="col-md-2">{{Math.round(total*discount)}}</h2>
                        </div>
                    </b-form-group>
                                      <div class="mt-3" style="display:flex; justify-content:space-around;">
                        <div style="display:inline-flex; flex-wrap:nowrap;"> 
                            <div class="mt-2 mr-3">開始時間 </div>
                            <div>
                                <date-picker v-if="Date.parse(start) > new Date()" v-model="start" :placeholder="start" :config="dateOption"></date-picker>
                                <date-picker v-else disabled :placeholder="start" v-model="start" :config="dateOption"></date-picker>
                            </div>
                        </div>
                        <div style="display:inline-flex; flex-wrap:nowrap;">
                            <div class="mt-2 mr-3">結束時間</div>
                            
                            <div><date-picker v-model="expire" :placeholder="expire" :config="dateOption"></date-picker></div>
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
        typeSelected: this.type,
        dis: this.discount,
        startDate: this.start,
        expireDate: this.expire,
        money: this.limitMoney,
        usage: this.numberOfUsage, 
        couponAll:{'coupon':{}, "coupon_items":null },

        dateOption: {            format: 'YYYY-MM-DD hh:mm:ss',
            sideBySide: true,
            useCurrent: false,
        },
        couponItems:[ { selected: null, spinValue:1, price:0 } ],
        productOption:[],
        showDiscount: Math.round((1-this.discount)*100),
      }
    },
    props:{
        code: String,
        coupon_id: Number,
        type: Number,
        discount: Number,
        limitMoney: String,
        start: String,
        expire: String,
        numberOfUsage: Number,
        products: Array,
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
                
                if(this.type==2){
                    this.couponItems =[];
                    for(let i=0; i<this.products.length; i++){
                        let item = this.productOption.find(element => element.value == this.products[i].product_id);
                        // console.log(item)
                        this.couponItems.push({selected:this.products[i].product_id, spinValue:this.products[i].quantity, price:item.price, name:item.text})
                    }
                    console.log('ALLCOUPON',this.couponItems);
                    this.setTotal()
                } 
            })
            this.$refs['my-modal'].show();
        },
        confirmModal(){
            //api update
            
            if(Date.parse(this.start) > new Date()){  //兩個時間都要填寫
                if (this.start > this.expire){
                    this.$fire({
                        type: 'warning',
                        title: '日期錯誤',
                        text: '結束時間必須大於開始時間',
                    })
                    this.start =this.startDate;
                    this.expire=this.expireDate
                    return
                }
            }
            else{ //只填結束時間
                if (Date.parse(this.expire) < new Date()){
                    this.$fire({
                        type: 'warning',
                        title: '日期錯誤',
                        text: '結束時間必須大於現在',
                    })
                    // this.start =this.startDate;
                    this.expire=this.expireDate
                    return
                }    
            }
            let couponAll = {'coupon':{}, 'coupon_items': null};
            if(this.type == 0) this.discount = 1;
            
            couponAll['coupon'] = {id:this.coupon_id, code:this.code, start_time:this.start, end_time:this.expire, numberOfUsage: this.numberOfUsage, 
                                    type:this.type, discount:this.discount, limit_money: this.limitMoney }
            
            if(this.type ==2 ){
                let items = [];
                this.couponAll['coupon'].limit_money=null;
                for (let i = 0; i<this.couponItems.length; i++){
                    if(this.couponItems[i].selected !=null){
                        items.push({coupon_id:this.coupon_id, product_id:this.couponItems[i].selected, quantity:this.couponItems[i].spinValue, name:this.couponItems[i].text})
                        console.log(this.couponItems[i].text);
                    }
                }
                couponAll['coupon_items'] = items;
                console.log('COUPONALL', couponAll)
            }
            // update local value;
            this.typeSelected = this.type;
            this.dis = this.discount;
            this.money = this.limitMoney;
            this.startDate = this.start;
            this.expireDate = this.expire;
            this.usage = this.numberOfUsage;
            this.showDiscount= Math.round((1-this.discount)*100),
            this.$emit('updateCoupon', couponAll);
            console.log('emiittt')
            this.$refs['my-modal'].hide();
        },
        cancelModal(){
            //reset to initial value
            this.type = this.typeSelected;
            this.discount = this.dis;
            this.limitMoney = this.money;
            this.start = this.startDate;
            this.exprire = this.expireDate;
            this.numberOfUsage = this.usage;
            this.$refs['my-modal'].hide();
        },
        deleteTHIS(){
            //api delete
            this.$confirm("確定要刪除？","","question").then(() =>{
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