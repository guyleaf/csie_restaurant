<script>
import { Bar } from 'vue-chartjs'

export default {
  extends: Bar,
  name: "Histogram",
  data(){
    return {
        foodData:[
          {foodName:"薯條",data: 30},
          {foodName:"漢堡",data: 20},
          {foodName:"飲料",data: 10},
          {foodName:"雞塊",data: 12},
          {foodName:"雞塊",data: 12},
          {foodName:"雞塊",data: 12},
          {foodName:"雞塊",data: 12},
          {foodName:"雞塊",data: 12},
          {foodName:"雞塊",data: 12},
          {foodName:"雞塊",data: 12},
          {foodName:"雞塊",data: 12},
        ],
      }
  },
  mounted () {
    this.renderChart({
        labels: this.getLabelname(),
        datasets: [
        {
          label: '銷售報表',
          backgroundColor: '#f87979',
          data: this.getLabelData(0,50),
        }],
    })
  },
  methods:{
      getLabelname(){
          let labels=[]
          // console.log(this.foodData.length);
          for (let i=0;i<this.foodData.length;i++) labels.push(this.foodData[i].foodName);
          // console.log(labels)
          return labels
      },
      getLabelData(min,max){
          let labels=[]
          // console.log(this.foodData.length);
          for (let i=0;i<this.foodData.length;i++) labels.push(this.foodData[i].data);
          labels.push(min)
          labels.push(max)
          // console.log(labels)
          return labels
      }
  }
}
</script>
