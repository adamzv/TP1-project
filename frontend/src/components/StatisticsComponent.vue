<template>
    <section>
        <b-field>
        </b-field>
        <b-field>
            
    
            <GChart
                type="ColumnChart"
                :data="chartData"
                :options="chartOptions"
                :events="chartEvents"
            />
             <GChart
                type="PieChart"
                :data="chartData"
                :options="chartOptions"
            />
        </b-field>


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
            }
        },
        
  data () {
    return {
      chartDataHeader: [
    ],
      chartDataRows: [
         [  ]
    ],
      updatedChartData: [],
      chartOptions: {
        chart: {
          title: 'Počet eventov na fakulte',
          
          
        },
        height:500,
        width:800
      },
       chartEvents: {
        select: () => {          
          
          alert('BAF');
        }
      }
    }
  },
  computed: {
    chartData () {
      return [ this.chartDataHeader, ...this.chartDataRows ]
    },
  
  chartData2 () {
      return [ this.chartDataHeader, ...this.chartDataRows ]
    }
  },
  methods: {
   
  },
 watch:{
    faculties() {
                if (this.hodnota.length > 0) {
                   this.chartDataHeader = this.faculties;
               this.chartDataRows = [this.hodnota];
                }
            }

 },
  created () {
    this.chartDataRows = [this.hodnota];
    this.chartDataHeader = this.faculties;
  }
};
</script>
