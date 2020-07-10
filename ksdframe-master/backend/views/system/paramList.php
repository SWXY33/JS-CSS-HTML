<style type="text/css">
    .el-dialog__body {
        padding-bottom: 50px;
    }
</style>
<div id="app" v-loading.fullscreen.lock="fullScreenLoading" @keyup="keySearch">
    <el-row class="container main-content" >
        <el-col :span="24" class="main">
            <section class="content-container fix-content">

                <el-col :span="24" class="toolbar" style="padding-bottom: 0px;">
                    <el-form :inline="true" :model="filters">
                        <el-form-item>
                            <el-select v-model="keytype" placeholder="请选择查询条件" style="width: 120px">
                                <el-option
                                        v-for="item in options"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value"
                                        :disabled="item.disabled">
                                </el-option>
                            </el-select>
                        </el-form-item>
                        <el-form-item>
                            <el-input v-model="keyword" placeholder="请输入查询内容" style="width:150px" autofocus></el-input>
                        </el-form-item>
                        <el-form-item>
                            <el-button type="primary" id="search" v-on:click="getSearchParamOrder" icon="search">查询</el-button>
                        </el-form-item>
                        <el-form-item class="fr">
                            <el-button type="danger" id="add" v-on:click="showAddForm" icon="plus">新增参数</el-button>
                        </el-form-item>
                    </el-form>

                </el-col>
                <!-- data -->
                <el-col>
                    <el-row :gutter="24">

                        <el-col :span="24">
                            <!-- table -->
                            <el-table :data="ParamList" highlight-current-row v-loading="listLoading" :max-height=tableHeight fit>
                                <el-table-column prop="id" label="id" width="80">
                                </el-table-column>
                                <el-table-column prop="name" label="name" width="240">
                                </el-table-column>
                                <el-table-column prop="code" label="code" width="240">
                                </el-table-column>
                                <el-table-column prop="type" label="type" width="240">
                                </el-table-column>
                                <el-table-column prop="value" label="value" show-overflow-tooltip width="340">
                                </el-table-column>
                                <el-table-column prop="desc" label="desc">
                                </el-table-column>
                                <el-table-column prop="sortOrder" label="sortOrder" width="120">
                                </el-table-column>
                                <el-table-column label="操作" width="140" fixed="right">
                                    <template scope="scope">
                                        <el-button type="text" style="color:#FF4949" size="small" @click="showEdit(scope.row.id)">修改</el-button>
                                        <el-button type="text" style="color:#FF4949" size="small" @click="delParam(scope.row.id)">删除</el-button>
                                    </template>
                                </el-table-column>
                            </el-table>
                            <!--新增界面-->
                            <el-dialog title="新增参数" :visible.sync="addParam" :close-on-click-modal="false">
                                <template>
                                    <el-form :model="addBase" label-width="100px" :rules="addBaseRules" ref="addBase">
                                        <el-form-item label="name" prop="name">
                                            <el-input v-model="addBase.name" class="agent-input" style="width: 400px;"></el-input>
                                        </el-form-item>
                                        <el-form-item label="code" prop="code">
                                            <el-input v-model="addBase.code" class="agent-input" style="width: 400px;"></el-input>
                                        </el-form-item>
                                        <el-form-item label="type" prop="type">
                                            <el-input v-model="addBase.type" class="agent-input"></el-input>
                                        </el-form-item>
                                        <el-form-item label="value" prop="value">
                                            <el-input v-model="addBase.value" type="textarea" class="agent-input"></el-input>
                                        </el-form-item>
                                        <el-form-item label="desc" prop="desc">
                                            <el-input v-model="addBase.desc" class="agent-input" style="width: 400px;"></el-input>
                                        </el-form-item>
                                        <el-form-item label="sortOrder" prop="sortOrder">
                                            <el-input v-model="addBase.sortOrder" class="agent-input"></el-input>
                                        </el-form-item>
                                        <el-form-item class="fr">
                                            <el-button type="primary" @click="addSubmit()">保存</el-button>
                                        </el-form-item>
                                    </el-form>
                                </template>

                            </el-dialog>

                            <!--修改页面-->
                            <el-dialog title="修改参数" :visible.sync="editList" :close-on-click-modal="false">
                                <template>
                                    <el-form :model="editData" label-width="100px"  ref="editData">
                                        <el-form-item label="name">
                                            <el-input v-model="editData.name" class="agent-input" disabled></el-input>
                                        </el-form-item>
                                        <el-form-item label="code">
                                            <el-input v-model="editData.code" class="agent-input"></el-input>
                                        </el-form-item>
                                        <el-form-item label="value">
                                            <el-tooltip class="item" effect="dark" :content="editData.desc" placement="bottom">
                                                <el-input v-model="editData.value" type="textarea" class="agent-input"></el-input>
                                            </el-tooltip>
                                        </el-form-item>
                                        <el-form-item class="fr">
                                            <el-button type="primary" @click="editSubmit()">修改</el-button>
                                        </el-form-item>
                                    </el-form>
                                </template>
                            </el-dialog>
                        </el-col>
                    </el-row>
                </el-col>
                <!-- data -->

                <!--分页条-->
                <el-col :span="24" class="toolbar text-right">
                    <el-pagination
                            @current-change="handleCurrentChange"
                            @size-change="handleSizeChange"
                            :current-page="currentPage"
                            :page-sizes="[20, 50, 100]"
                            :page-size="pageSize"
                            layout="total, sizes, prev, pager, next, jumper"
                            :total="total">
                    </el-pagination>
                </el-col>
            </section>
        </el-col>
    </el-row>
</div>

<script>
    var frame = AppFrame({
        data:{
            filters: {
                name: ''
            },
            keySearch:'',
            addParam:false,
            fullScreenLoading: true,
            ParamList: [],
            addBase:{
                'parentId':'',
                'value':'',
                'name':'',
                'code':'',
                'type':'',
                'sortOrder':'',
                'desc':'',
            },
            parentList:[],
            goodsList:[],
            addBaseRules: {},
            tableHeight:500,
            currentPage:1,
            datas: '',
            total: 1,
            pageSize:20,
            page: 1,
            listLoading: false,
            orderOptions: [],
            keytype: 'code',
            keyword:'',
            options: [
                {
                    value: 'name',
                    label: 'name'
                },
                {
                    value: 'code',
                    label: 'code'
                },
                {
                    value: 'value',
                    label: 'value'
                },
                {
                    value: 'type',
                    label: 'type'
                },
            ],
            editList:false,
            editData:{
                'id':'',
                'code':'',
                'value':'',
                'desc':'',
            },
        },
        methods: {
            getSearchParamOrder:function(){
                var keytype = this.keytype;
                var keyword = this.keyword;
                this.getParamList(1,this.pageSize,keytype,keyword);
            },
            handleCurrentChange:function(page) {
                this.getParamList(page,this.pageSize);
            },
            handleSizeChange:function(val) {
                this.pageSize = val;
                this.currentPage = 1;
                this.getParamList(1,val);
            },
            getParamList:function(page,pageSize,keytype,keyword){//获取列表
                var self = this;
                this.listLoading = true;
                AjaxLoader.post(AppCommon.getUrl('/system/getParamList'),{'page':page,'pageSize':pageSize,'keytype':keytype,'keyword':keyword},function(data){
                    self.ParamList = data['list'];
                    self.total = data['count'];
                    self.listLoading = false;
                    self.fullScreenLoading = false;
                });
            },
            addSubmit:function(){
                var paramData = Object.assign({}, this.addBase);
                var self = this;
                AjaxLoader.post(AppCommon.getUrl('/system/addParam'),{paramData},function(res){
                    self.addParam = false;
                    if (res) {
                        self.msgSuccess('参数修改成功！');
                        location.reload();
                    }

                });
            },
            showAddForm:function () {
                this.addParam = true;
            },
            showEdit:function(id){
                var self = this;
                this.editList= true;
                AjaxLoader.post(AppCommon.getUrl('/system/edit'),{'id':id},function(data){
                    self.editData = data;
                    self.editData.id= id;
                });

            },
            editSubmit:function(){
                var self = this;
                AjaxLoader.post(AppCommon.getUrl('/system/editSubmit'),this.editData,function(res){
                    self.msgSuccess('参数修改成功！');
                    location.reload();
                });
            },
            delParam:function(id){
                var self = this;
                this.$confirm('确认删除该参数吗？', '提示', {
                    type: 'warning'
                }).then(() => {
                    AjaxLoader.post(AppCommon.getUrl('/system/delParam'),{'id':id},function(res){
                        self.msgSuccess('删除成功');
                        self.getParamList();
                    });
                }).catch(() => {

                });
            },
        },
        mounted:function() {
            this.getParamList();
            var tableHeight = document.documentElement.clientHeight - 160;
            this.tableHeight = tableHeight;
        }

    })
</script>
