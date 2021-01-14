<template>
    <div class="container">
        <div style="background-color:white">
            <div class='tag mt-5'>優惠卷  <b-button squared class="ml-5 nooutline" size="sm" variant="outline-danger" @click="openModal">新增</b-button> </div>
            <div class='couponField mb-5' style='display:flex; flex-direction:row; '>
                <div v-for="coupon in couponCards" :key="coupon['coupon'].id">
                    <CouponCard :coupon_id="coupon['coupon'].id" :code="coupon['coupon'].code" :products="coupon['coupon_items']" :discount="parseFloat(coupon['coupon'].discount)" 
                    :numberOfUsage="parseInt(coupon['coupon'].numberOfUsage,10)" :limitMoney="parseInt(coupon['coupon'].limit_money,10)" 
                    :start="coupon['coupon'].start_time" :expire="coupon['coupon'].end_time" :type="coupon['coupon'].type" 
                    v-on="{updateCoupon:updateCoupon, deleteCoupon:deleteCoupon}"/>
                </div>
            </div>
        </div>
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
                        <b-form-radio value=0>滿額免運費</b-form-radio>
                        <b-form-radio value=1>滿額打折</b-form-radio>
                        <b-form-radio value=2>優惠套餐</b-form-radio>
                    </div>
                    </b-form-radio-group>
                    </b-form-group>
                    <div class="row" v-if="typeSelected==0">
                        <div class="col-md-1 mt-2">滿額</div>
                        <b-form-input class="col-md-2" v-model="money" placeholder="XX元免運費" min="0" type="number" required></b-form-input>
                        <div class="col-md-1 mt-0 ml-0">使用次數</div>
                        <b-form-input class="col-md-3" v-model="usage" placeholder="每人可用次數" min="1" type="number" required></b-form-input>
                    </div>
                    <div class="row" v-if="typeSelected==1">
                        <div class="col-md-1 mt-2">滿額</div>
                        <b-form-input class="col-md-2" v-model="money" placeholder="XX元打折" min="0" type="number" required></b-form-input>
                        <div class="col-md-1 mt-2">折扣</div>
                        <b-form-input class="col-md-2" v-model="discount" placeholder="請輸入小數" step="0.1" max="1" min="0" type="number" required></b-form-input>
                        <div class="col-md-1 mt-0 ml-0">使用次數</div>
                        <b-form-input class="col-md-3" v-model="usage" placeholder="每人可用次數" min="1" type="number" required></b-form-input>
                    </div>
                    <b-form-group label="優惠商品" v-if="typeSelected==2">
                        <div class="row mt-2" v-for="(item, index) in couponItems" v-bind:key="index">
                            
                            <div class="col-md-7">
                                <b-form-select v-model="item.selected" :options="productOption" @change="setPrice(index,item.selected)"></b-form-select>
                            </div>
                            
                            <div class="col-md-3">
                                <b-form-spinbutton :id="'sb_'+index" min="1" max="100" v-model="item.spinValue" @change="setTotal"></b-form-spinbutton>
                            </div>
                            <div class="col-md-1 mt-1">${{item.price*item.spinValue}}</div>
                        </div>
                        <div class="row ml-2 mt-2">
                            <b-button class="col-md-3 nooutline" variant="outline-primary" @click="addcouponItems">新增欄位</b-button>
                            <b-button class="col-md-3 ml-4 nooutline" variant="outline-danger" @click="deletecouponItems">移除欄位</b-button> 
                            <h2 class="col-md-2 mt-2 ml-5">總金額</h2>
                            <h2 class="col-md-1 mt-2" style="text-decoration:line-through;">{{total}}</h2>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-1 mt-2">折扣</div>
                            <b-form-input class="col-md-2" v-model="discount" placeholder="請輸入小數" step="0.1" max="1" min="0" type="number" required></b-form-input>
                            <div class="col-md-1 mt-0 ml-0">使用次數</div>
                            <b-form-input class="col-md-3" v-model="usage" placeholder="每人可用次數" min="1" type="number" required></b-form-input>
                            <h2 class="col-md-3">折價後金額</h2>
                            <h2 class="col-md-2">{{Math.round(total*discount)}}</h2>
                        </div>
                    </b-form-group>
                    <div class="mt-3" style="display:flex; justify-content:space-around;">
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
                        <b-button variant="primary" @click="checkValue" size="sm">新增</b-button>
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
    data()
    {
        return{
            total: 0,
            usage: 1,
            startDate: '',
            expireDate: '',
            discount: 1,
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
        updateCoupon(msg){
            this.$http.post('/seller/coupons/update', msg,{             
                headers: {
                'Authorization': 'Bearer ' + this.$store.getters['auth/token'],
                }
            }).then(response=>{
                this.$alert("更改成功","","success");
                var newCoupon = msg;
                if(newCoupon['coupon'].type == 2){
                    for(let i=0; i<newCoupon['coupon_items'].length;i++){
                        let item = this.productOption.find(element => element.value == newCoupon['coupon_items'][i].product_id);
                        newCoupon['coupon_items'][i].name = item.text;
                    }
                }
                let index = this.couponCards.findIndex(i => i['coupon'].id === newCoupon['coupon'].id)
                this.couponCards.splice(index, 1, newCoupon);
            })
            .catch(error=>{
                // this.$alert("更改失敗","","error");
                // console.log(error.response)
            })
        },       
        deleteCoupon(msg){
            this.$http.post('/seller/coupons/delete', msg,{
                headers: {
                'Authorization': 'Bearer ' + this.$store.getters['auth/token'],
                }
            }).then(response=>{
                this.$alert("刪除成功","","success");
            }).catch(error=>{
                // this.$alert("刪除失敗","","error");
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
				var newCoupon = msg;
                newCoupon['coupon'].id = response.data['coupon_id'];
                if(newCoupon['coupon'].type == 2){
                    for(let i=0; i<newCoupon['coupon_items'].length;i++){
                        let item = this.productOption.find(element => element.value == newCoupon['coupon_items'][i].product_id);
                        newCoupon['coupon_items'][i].name = item.text;
                    }
                }
                this.couponCards.push(newCoupon);      
            }).catch(error=>{
                // this.$alert("新增失敗","","error");
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
                let data=response.data;
                for (let i=0;i<data.length;i++){
                    this.productOption.push({value:data[i].id, text:data[i].name, price:data[i].price});
                }
                // console.log(this.productOption)
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
        checkValue(){
            if(this.typeSelected == null){
                this.$fire({
                    type: 'warning',
                    title: '填寫錯誤',
                    text: '必須選擇一種類型',
                })
            }
            else if(this.typeSelected ==2 && (this.couponItems.length == 0 || this.couponItems[0].selected == null)){
                this.$fire({
                    type: 'warning',
                    title: '填寫錯誤',
                    text: '必須選擇至少一種商品',
                })
            }
            else if(this.startDate == '' && this.expireDate==''){
                this.$fire({
                    type: 'warning',
                    title: '填寫錯誤',
                    text: '必須填寫開始和結束時間',
                })
            }
            else if(this.startDate == ''){
                this.$fire({
                    type: 'warning',
                    title: '填寫錯誤',
                    text: '必須填寫開始時間',
                })
            }
            else if(this.expireDate==''){
                this.$fire({
                    type: 'warning',
                    title: '填寫錯誤',
                    text: '必須填寫結束時間',
                })
            }
            else if(this.money <= 0 && this.typeSelected !=2){  
                this.$fire({
                    type: 'warning',
                    title: '數值錯誤',
                    text: '滿額必須大於0',
                })
                this.money = 1;
            }
            else if(this.discount >= 1 && this.typeSelected !=0){  
                this.$fire({
                    type: 'warning',
                    title: '數值錯誤',
                    text: '折扣必須小於1',
                })
                this.discount = 0.9;
            }
            else if(this.dis == 0 && this.typeSelected !=0){  
                this.$fire({
                    type: 'warning',
                    title: '數值錯誤',
                    text: '折扣必須大於0',
                })
                this.dis = 0.1;
            }
            else if(this.usage <= 0){  
                this.$fire({
                    type: 'warning',
                    title: '數值錯誤',
                    text: '使用次數必須大於0',
                })
                this.usage = 1;
            }
            else if(Date.parse(this.startDate) > Date.parse(this.expireDate)){ 
                this.$fire({
                    type: 'warning',
                    title: '日期錯誤',
                    text: '結束時間必須大於開始時間',
                })
            }
            else if (Date.parse(this.expireDate) < new Date()){
                this.$fire({
                    type: 'warning',
                    title: '日期錯誤',
                    text: '結束時間必須大於現在',
                })
            }
            else this.confirmModal();
        },
        confirmModal(){
            let couponAll = {'coupon':{}, "coupon_items":null };
            if(this.money == undefined) this.money = null; 
            if(this.typeSelected == 0) this.discount = 1;
            couponAll['coupon'] = {id:null, code:this.code, start_time:this.startDate, end_time:this.expireDate, numberOfUsage: this.usage, //FIXME numberOfUsae
                                    type:parseInt(this.typeSelected,10), discount:parseFloat(this.discount), limit_money:parseInt(this.money,10) }
            if(this.typeSelected ==2 ){
                this.info = [];
                this.productName = [];
                for (let i = 0; i<this.couponItems.length; i++){
                    if(this.couponItems[i].selected !=null){
                        this.info.push({product_id:this.couponItems[i].selected, quantity:this.couponItems[i].spinValue})
                    }
                }
                couponAll['coupon_items'] = this.info;
            }
            this.addCoupon(couponAll);
            this.$refs['my-modal'].hide();
        },
        cancelModal(){
            this.$refs['my-modal'].hide();
        },
        addcouponItems(){
            this.couponItems.push({ selected: null, spinValue:1, price:0 })
        },
        deletecouponItems(){
            this.couponItems.splice(-1,1);
            this.setTotal();
        },
        setPrice(index, selected){
            let optionIndex = this.productOption.findIndex(i => i.value === selected)
            this.couponItems[index].price = this.productOption[optionIndex].price;
            this.setTotal();
        },
        setTotal(){
            this.total = 0;
            for(let i=0; i<this.couponItems.length; i++){
                this.total += this.couponItems[i].price * this.couponItems[i].spinValue;
            }
        },
        
    },
    
    created(){
        this.productOption=[];
        this.typeSelected = null;
        this.total = 0;
        let id =this.$store.getters['auth/user'].id
        this.$http.get('restaurants/'+id+'/products')
        .then(response => {
            let data=response.data;
            for (let i=0;i<data.length;i++){
                this.productOption.push({value:data[i].id, text:data[i].name, price:data[i].price});
            }
            this.productOption = this.productOption.sort(function (a, b) {
                return a.name - b.name
            });
        })

        this.$http.get('/seller/coupons', {
            headers: {
                'Authorization': 'Bearer ' + this.$store.getters['auth/token'],
            }
        }).then(response => {
            this.couponCards = response.data;
            //排序 未來的擺在前面
            this.couponCards = this.couponCards.sort(function(a,b){
                return Date.parse(b['coupon'].start_time) - Date.parse(a['coupon'].start_time)
            })
            // console.log(this.couponCards);
        })
    },
}
</script>

<style scoped>
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
.nooutline{
    outline: none !important;
    box-shadow: none !important;
}
</style>