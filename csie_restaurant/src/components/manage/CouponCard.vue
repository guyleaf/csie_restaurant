<template>
    <div>
        <b-card overlay class='m-2' style="min-width:360px; height:220px">
            <b-card-title>{{code}}</b-card-title>
            <!-- 0 for免運 1for滿XXX折扣 2for套餐組合><-->
            <b-card-text v-if="type === 0">
                <a style="color:red;">免運費</a>
            </b-card-text>
            <b-card-text v-if="type === 1">
                <a>滿{{money}}元</a> <a style="color:red;">{{discount}}%off</a>
            </b-card-text>
            <b-card-text v-if="type === 2">
                <a v-for="(product, index) in products" :key="product.product_id">
                    {{product.quantity}} {{product.name}}
                    <a v-if="index != products.length-1 ">+</a>  
                </a>
                <a style="color:red;">{{discount}}%off</a>
            </b-card-text>
            <b-card-text>開始:{{start}}</b-card-text>
            <b-card-text>結束:{{expire}}</b-card-text>
            <b-card-footer footer-bg-variant="gray" footer-border-variant="white" class="foodCardHeader">
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
                    <b-form-group
                    label="優惠類型"
                    label-for="type-input"
                    invalid-feedback="type is required"
                    :state="typeState">
                    <b-form-radio v-model="typeSelected" :aria-describedby="ariaDescribedby" name="some-radios" value="1">滿額折扣</b-form-radio>
                    <b-form-radio v-model="typeSelected" :aria-describedby="ariaDescribedby" name="some-radios" value="2">優惠套餐</b-form-radio>
                    <b-form-input v-if="typeSelected==='1'"
                        ref="type-input"
                        v-model="money"
                        :state="typeState"   type="text"
                        required></b-form-input>
                    </b-form-group>
                    <b-form-group
                    label="折扣"
                    label-for="discount-input"
                    invalid-feedback="discount is required"
                    :state="priceState">
                    <b-form-input
                        ref="discount-input"
                        v-model="discount"
                        :state="discountState" type="text"
                        required>{{ discount }}</b-form-input>
                    </b-form-group>
                    <a v-if="Date.parse(start) > new Date()">開始時間</a>
                    <date-picker v-if="Date.parse(start) > new Date()" v-model="startDate" :config="options"></date-picker>
                    <a>結束時間</a>
                    <date-picker v-model="expireDate" :config="options"></date-picker>
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
        typeSelected:'',
        options: {
          sideBySide: true,
          useCurrent: false,
        }    
      }
    },
    props:{
        code: String,
        products: Array,
        discount: Number,
        money: Number,
        start: Date,
        expire: Date,
        type: Number,
    },
    created:{
    },
    computed:{
    },
    methods:{
        showModal(){
            this.$refs['my-modal'].show();
        },
        confirmModal(){
            //api update
            this.$refs['my-modal'].hide();
            let from1 = this.startDate.indexOf('T');
            let to1 = this.startDate.indexOf('+');
            this.start = this.startDate.substring(0, from1) + '  '+ this.startDate.substring(from1+1,to1);
            let from2 = this.startDate.indexOf('T');
            let to2 = this.startDate.indexOf('+');
            this.expire = this.expireDate.substring(0, from2) + '  '+ this.expireDate.substring(from2+1,to2)
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
.foodCardHeader{
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