
  
<template>
    <section>
        <b-field> 
<table>
  <tr>
    <td>
<div class="box  is-flex">
  <article class="media">
    <div class="media-left">
      <figure class="image is-64x64">
        <img src="https://www.flaticon.com/svg/vstatic/svg/33/33308.svg?token=exp=1607607373~hmac=4cd7739d7a77eb2357fa26b1dddb4f22" alt="Image" @click="updateData">
      </figure>
    </div>
    <div class="media-content">
      <div class="content">
        <p v-if="this.online.length > 0">
          <strong>ONLINE</strong><br>
          <a style="color:green; font-size:20px">•</a> {{online[0].pocet}}</p>
      </div>
      
    </div>
  </article>
</div>
    </td>
  </tr>

</table>
        </b-field>
        <div>
        </div>
  <div>
            <b-field grouped>
            <div style="width:100%" >
            <GChart
                type="ColumnChart"
                :data="chartData"
                :options="chartOptions"
                :events="chartEvents"
                :resizeDebounce="500"
                
            />
            
            </div>
            </b-field>
</div>
    </section>
 
</template>

<script>
import { GChart } from "vue-google-charts";
export default {
  
  components: {
    GChart
  },
   props: {
            faculties: {
                type: Array,
                required: true
                
            },
            hodnota: {
                type: Array,
                required: true
            },
            online: {
                type: Array,
                required: true
            },

        },
        
  data () {
    return {
      data: [],
      chartDataHeader: [
    ],
      chartDataRows: [
         [ ]
    ],
      updatedChartData: [],
      chartOptions: {
        chart: {
          title: 'Počet eventov na fakulte',
          
          
        },
        legend: { position: 'top', maxLines: 3 },
        height: 500,
        responsive: true,
        maintainAspectRatio: false
      },
       self: this,
       chartEvents: {
        select: function() {
              
            }
      }
    }
  },
  computed: {
    chartData () {
      this.updateData();
      return [ this.chartDataHeader, ...this.chartDataRows ]
    },
  
  chartData2 () {
      return [ this.chartDataHeader, ...this.chartDataRows ]
    }
  },
  methods: {
    updateData () {
      this.chartDataHeader = this.faculties;
               this.chartDataRows = [this.hodnota];
  },
  },
 watch:{
   
    
    
    online(){
              if (this.online.length > 0) {
                  this.data = this.online;
                }


    },
    faculties() {
                if (this.hodnota.length > 0) {
                   this.chartDataHeader = this.faculties;
               this.chartDataRows = [this.hodnota];
               this.updateData();
                }
            }
 },
  created () {
    this.updateData();
    this.chartDataRows = [this.hodnota];
    this.chartDataHeader = this.faculties;
  },

  
};
</script>
