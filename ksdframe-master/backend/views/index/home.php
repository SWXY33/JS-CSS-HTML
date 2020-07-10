<style type="text/css">
    ::-webkit-scrollbar{
        display:none;
    }
</style>
<div id="app" style="height: 950px;">
  <el-row class="container main-content">

  </el-row>
</div>

<script>
var frame = AppFrame({//AppFrame在/backend/views/layouts/header.php 中 var AppFrame = function(data){}
    data:{
        filters: {
            name: ''
        }
    },
    methods: {
        openTab:function(id){
            window.parent.parent.document.getElementById(id).click();
        }

    },      
    mounted:function() {
    },

})

</script>
