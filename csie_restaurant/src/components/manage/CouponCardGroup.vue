<template>
    <div class="container">
        <div style="background-color:white">
            <div class='tag mt-5'>優惠卷  <b-button squared class="ml-5" size="sm" variant="outline-danger" @click="openModal">新增</b-button> </div>
            <div class='couponField mb-5' style='display:flex; flex-direction:row; '>
                <div v-for="coupon in couponCards" :key="coupon['coupon'].id">
                    <CouponCard :coupon_id="coupon['coupon'].id" :code="coupon['coupon'].code" :products="coupon['coupon_items']" :discount="coupon['coupon'].discount" 
                    :limitMoney="coupon['coupon'].limit_money" :start="coupon['coupon'].start_time" :expire="coupon['coupon'].end_time" :type="coupon['coupon'].type"
                    :allProducts="allProducts"
                    v-on="{updateCoupon:updateCoupon, deleteCoupon:deleteCoupon}"/>
                </div>
            </div>
        </div>
        <b-modal id="modal-lg" size="lg" ref="my-modal" hide-header hide-footer hide-header-close body-bg-variant="secondary">
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
                    <a v-if="typeSelected==0">滿額</a><b-form-input v-if="typeSelected==0" v-model="money" placeholder="XX元免運費" type="text" style="width:50%;" required></b-form-input>
                    <a v-if="typeSelected==1">滿額</a><b-form-input v-if="typeSelected==1" v-model="money" placeholder="XX元打折" type="text" style="width:50%;" required></b-form-input>
                    <b-form-group label="優惠商品" v-if="typeSelected==2">
                        <div class="row mt-2" v-for="(item, index) in couponItems" v-bind:key="index">
                            <div class="col-md-6">
                                <b-form-select v-model="item.selected" :options="productOption" @change="setPrice(index,item.selected)"></b-form-select>
                            </div>
                            <div class="col-md-4">
                                <b-form-spinbutton :id="'sb_'+num" min="1" max="100" v-model="item.spinValue" @change="setTotal"></b-form-spinbutton>
                            </div>
                            <div class="col-md-2 mt-1">{{item.price*item.spinValue}}元</div>
                        </div>
                        <b-button variant="outline-primary" @click="addcouponItems">新增優惠商品</b-button> <a>{{total}}</a>
                    </b-form-group>
                    <a v-if="typeSelected==1 || typeSelected==2">折扣(請輸入小數)</a><b-form-input v-if="typeSelected ==1||typeSelected ==2" v-model="discount" placeholder="請輸入小數" type="text" style="width:50%;" required></b-form-input>
                    <div style="display:flex; justify-content:space-around;">
                        <div style="display:inline-flex; flex-wrap:nowrap;"> 
                            <div class="mt-2 mr-3">開始時間 </div>
                            <div>
                                <date-picker v-model="startDate" :config="dateOption"></date-picker>
                            </div>
                        </div>
                        <div style="display:inline-flex; flex-wrap:nowrap;">
                            <div class="mt-2 mr-3">結束時間</div>
                            <div><date-picker v-model="expireDate" :config="dateOption"></date-picker></div>
                        </div>
                    </div>
                    <div class="row m-2" style="justify-content:space-around">
                        <b-button variant="primary" @click="confirmModal" size="sm">新增</b-button>
                        <b-button variant="info" @click="cancelModal" size="sm">取消</b-button>
                    </div>
                </div>
            </div> 
        </b-modal>
    </div>
</template>

<script>
import CouponCard from "@/components/manage/CouponCard.vue";
import datePicker from 'vue-bootstrap-datetimepicker';
import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';
export default {
    name: "CouponCardGroup",
    components: {
        CouponCard,
        datePicker,
    },
    props:{
    },
    data()
    {
        return{
            total: 0,
            selectedProduct:'',
            startDate: '',
            expireDate: '',
            discount: 0,
            money: 0,
            info:[],
            typeSelected:null,
            code:'',
            couponCards:[] , 
            dateOption: {
                format: 'YYYY-MM-DD hh:mm:ss',
                sideBySide: true,
                useCurrent: false,
            },
            couponItems:[ { selected: null, spinValue:1, price:0 } ],
            productOption:[],
            
        }
    }, 
    methods:{
        updateCoupon(msg){            this.$http.post('/seller/coupons/update', msg,{
                headers: {
                'Authorization': 'Bearer ' + this.$store.getters['auth/token'],
                }
            }).then(response=>{
                this.$alert("更改成功","","success");
                
                let index = this.couponCards.findIndex( i=> i['coupon'].id === msg['coupon'].id)
                let updateInfo = msg;
                if(msg['coupon'].type == 2){
                    for(let i=0; i<msg['coupon_items'].length; i++) updateInfo['coupon_items'][i].name = itemName[i];
                }
                console.log('update',updateInfo);
                this.couponCards.splice(index, 1, updateInfo);
            })
            .catch(error=>{
                this.$alert("更改失敗","","error");
                console.log(msg);
                console.log(error.response)
            })
            // console.log(this.couponCards[index]);
        },
        deleteCoupon(msg){
            this.$http.post('/seller/coupons/delete', msg,{
                headers: {
                'Authorization': 'Bearer ' + this.$store.getters['auth/token'],
                }
            }).then(response=>{
                this.$alert("刪除成功","","success");
            }).catch(error=>{
                this.$alert("刪除失敗","","error");
                console.log(error.response)
            })
            let index = this.couponCards.findIndex( i=> i['coupon'].id === msg['coupon'].id)
            this.couponCards.splice(index,1);
        },
        addCoupon(msg){
            this.$http.post('/seller/coupons/add',msg,{
                headers: {
                'Authorization': 'Bearer ' + this.$store.getters['auth/token'],
                }
            }).then(response =>{
                this.$alert("新增成功","","success");
                let newCoupon = msg;
                newCoupon['coupon'].id = response.data['coupon_id'];
                // console.log(newCoupon);
                this.couponCards.push(newCoupon);
            }).catch(error=>{
                this.$alert("新增失敗","","error");
                console.log(error.response)
            })
        },
        openModal(){
            this.code = this.makeCode();
            this.productOption=[];
            this.typeSelected = null;
            this.couponItems = [ { selected: null, spinValue:1, price:0 } ];
            this.total = 0;
            let id =this.$store.getters['auth/user'].id
            this.$http.get('restaurants/'+id+'/products')
            .then(response => {
                // console.log('openModalAPI');
                let data=response.data;
                for (let i=0;i<data.length;i++){
                    this.productOption.push({value:data[i].id, text:data[i].name, price:data[i].price});
                }
                console.log(this.productOption)
                this.productOption = this.productOption.sort(function (a, b) {
                    return a.name - b.name
                });
            })
            
            this.$refs['my-modal'].show();
        },
        makeCode() {
            let result           = '';
            let characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            let charactersLength = characters.length;
            for ( var i = 0; i < 6; i++ ) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            return result;
        },
        confirmModal(){
            //FIXME 防呆input錯誤
            let couponAll = {'coupon':{}, "coupon_items":null };
            if(this.money == undefined) this.money = null; 
            if(parseInt(this.typeSelected) == 0) this.discount = 1;
            couponAll['coupon'] = {id:null, code:this.code, start_time:this.startDate, end_time:this.expireDate, numberOfUsage: 100, //FIXME numberOfUsae
                                    type:parseInt(this.typeSelected), discount:parseFloat(this.discount), limit_money:parseInt(this.money) }
            if(this.typeSelected ==2 ){
                this.info = [];
                for (let i = 0; i<this.couponItems.length; i++){
                    this.info.push({product_id:this.couponItems[i].selected, quantity:this.couponItems[i].spinValue})
                }
                couponAll['coupon_items'] = this.info;
            }
            // console.log('showCOupon',couponAll);
            this.addCoupon(couponAll);
            this.$refs['my-modal'].hide();
        },
        cancelModal(){
            this.$refs['my-modal'].hide();
        },
        addcouponItems(){
            this.couponItems.push({ selected: null, spinValue:1, price:0 })
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
        },
        
    },
    
    created(){
        this.$http.get('/seller/coupons', {
            headers: {
                'Authorization': 'Bearer ' + this.$store.getters['auth/token'],
            }
        }).then(response => {
            this.couponCards = response.data;
            console.log('getCoupons');
            // console.log(this.couponCards);
        }).catch(error=>{
            console.log('getCouponsFAIL');
            console.log(error.response)
        })
    },
}
</script>

<style scoped>
.cp_pd{
    margin-bottom:1%;
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

.couponField{
    overflow-x: scroll;
    overflow-y: hidden;
    padding:  1%;
    border-color: #000000;
    height: 280px;
}
</style>