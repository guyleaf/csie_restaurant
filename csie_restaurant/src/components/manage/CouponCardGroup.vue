<template>
    <div class="container">
        <div style="background-color:white">
            <div class='tag mt-5'>優惠卷  <b-button squared class="ml-5" size="sm" variant="outline-danger" @click="addCoupon">新增</b-button> </div>
            <div class='couponField mb-5' style='display:flex; flex-direction:row; '>
                <div v-for="coupon in couponCards" :key="coupon['coupon'].id">
                    <CouponCard :id="coupon['coupon'].coupon_id" :code="coupon['coupon'].code" :products="coupon['coupon_items']" :discount="coupon['coupon'].discount" 
                    :limitMoney="coupon['coupon'].limit_money" :start="coupon['coupon'].start_time" :expire="coupon['coupon'].end_time" :type="coupon['coupon'].type"/>
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
                        <b-form-radio value="0">滿額免運費</b-form-radio>
                        <b-form-radio value="1">滿額打折</b-form-radio>
                        <b-form-radio value="2">優惠套餐</b-form-radio>
                    </div>
                    </b-form-radio-group>
                    </b-form-group>
                    <a v-if="typeSelected==0">滿額</a><b-form-input v-if="typeSelected==0" v-model="money" :placeholder="limitMoney+shipFreeHint" type="text" style="width:50%;" required></b-form-input>
                    <a v-if="typeSelected==1">滿額</a><b-form-input v-if="typeSelected==1" v-model="money" :placeholder="limitMoney+limitHint" type="text" style="width:50%;" required></b-form-input>
                    <a v-if="typeSelected==1">折扣</a><b-form-input v-if="typeSelected==1" v-model="discount" :placeholder="discount+discountHint" type="text" style="width:50%;" required></b-form-input>
                    <b-form-group
                        label="新增商品"
                        v-if="typeSelected==2"
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
                    <div style="display:flex; justify-content:space-around;">
                        <div style="display:inline-flex; flex-wrap:nowrap;"> 
                            <div class="mt-2 mr-3">開始時間 </div>
                            <div>
                                <date-picker v-model="startDate" :config="options"></date-picker>
                            </div>
                        </div>
                        <div style="display:inline-flex; flex-wrap:nowrap;">
                            <div class="mt-2 mr-3">結束時間</div>
                            <div><date-picker v-model="expireDate" :config="options"></date-picker></div>
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
            typeSelected:null,
            code:'',
            couponCards:[] , 
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
    methods:{
        addCoupon(){
            this.code = this.makeCode();
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
            for (let i = 1; i<this.productNum+1; i++){
                let option = document.querySelector('#option_'+i).value
                let spinValue = document.querySelector('#sb_'+i).value
                this.couponProduct.push({option:option, spinValue:spinValue})
            }
            console.log(this.couponProduct)
            this.$refs['my-modal'].hide();
        },
        cancelModal(){
            this.$refs['my-modal'].hide();
        }
    },
    created(){
        let id =this.$store.getters['auth/user'].id
        this.$http.get('restaurants/' + id + '/coupons' + '?include_expired=1'). //FIXME  ?include_expired=1要移除
        then(response => {
            let data=response.data;
            this.couponCards = data;
        });
    },
    computed(){
        
        
    }
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