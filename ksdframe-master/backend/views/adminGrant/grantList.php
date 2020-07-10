<div id="app">
<el-row class="container main-content" >
    <el-col :span="24" class="main">
        <section class="content-container fix-content">

            <el-col :span="24" class="toolbar">
                <div class="fr">
                    <el-button type="danger" icon="el-icon-plus" size="small" @click="addGrant">新增权限</el-button>
                </div>
                <div class="fl top-search">
                    <el-button-group>
                      <el-input placeholder="请输入查询内容" v-model="keyword" class="input-with-select" size="small">
                        <el-select slot="prepend" placeholder="请选择" size="small" v-model="keytype">
                          <el-option label="权限名称" value="name"></el-option>
                        </el-select>
                        <el-button slot="append" icon="el-icon-search" size="small" @click="getAdminGrant()"></el-button>
                      </el-input>
                    </el-button-group>
                </div>
            </el-col>

            <!--列表-->
            <el-table  :data="adminGrantList" fit highlight-current-row v-loading="listLoading"  style="width: 100%;" :max-height=tableHeight>
                <el-table-column type="index" label="序号" width="100">
                </el-table-column>
                <el-table-column prop="name" label="权限名称" width="240">
                </el-table-column>
                <el-table-column prop="parentIdName" label="上级权限" width="240">
                </el-table-column>
                <el-table-column prop="typeName" label="权限类型" width="240">
                </el-table-column>
                <el-table-column prop="tag" label="权限标签" width="240">
                </el-table-column>
                <el-table-column prop="url" label="权限路径" width="320">
                </el-table-column>
                <el-table-column prop="orderby" label="排序">
                </el-table-column>
                <el-table-column label="操作" width="140" fixed="right">
                    <template scope="scope">
                        <el-button type="text" size="small" @click="updateGrant(scope.row.adminGrantId)">编辑</el-button>
                        <el-button type="text" size="small" @click="removeGrant(scope.row.adminGrantId)">删除</el-button>
                    </template>
                </el-table-column>
            </el-table>

            <!--工具条-->
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
            currentPage:1,
            total: 1,
            pageSize:20,
            page: 1,
            bbb:true,
            grantType:'',
            showType:'',
            input: '',
            adminGrantList:[],
            editBase:[],
            listLoading: false,
            tableHeight:'',
            addAdminUser:false,
            editAdminUser:false,
            activeName: 'first',
            data: '',
            nouse:false,
            show:true,
            keytype:'name',
            keyword:'',

        topList: AppData.adminGrantTopList,

            showList: [{
                    value: '1',
                label: '显示'
            },{
                value: '0',
                    label: '不显示'
            }],
            showTypes: [{
                    value: '1',
                label: '显示'
            },{
                value: '0',
                    label: '隐藏'
            }],
            typeList:[{
                    value: '0',
                label: '菜单权限'
            },{
                value: '1',
                    label: '操作权限'
            },{
                value: '2',
                    label: '数据权限'
            },{
                value: '3',
                    label: '字段权限'
            }],
            addBase: {
                name:'',
                parentId:'',
                orderby:'',
                tag:'',
                url:'',
                icon:'',
                show:'',
                type:''
            },

        },
        methods: {
            handleCurrentChange:function(val) {
                this.getAdminGrantList(val,this.pageSize);
            },
            handleSizeChange:function(val) {
                    this.pageSize = val;
                    this.currentPage = 1;
                    this.getAdminGrantList(1,val);
            },
            addGrant:function(){
                var that = this;
                var frameId = '';
                var buttonList = [
                    {
                        label:'保存',
                        callback:function(contentWindow){
                            contentWindow.appFrameObject.onSubmit(function(data){
                                that.msgSuccess('添加完成');
                                that.getAdminGrantList();
                                AppDialog.close(frameId);
                            });
                        }
                    },
                    {
                        label:'取消',
                        callback:function(contentWindow){
                            AppDialog.close(frameId);
                        }
                    }
                ];
                frameId = AppDialog.openFrame(AppCommon.getUrl('/adminGrant/addGrant'),'新增权限',buttonList);
            },
            updateGrant:function(adminGrantId){
                var that = this;
                var frameId = '';
                var buttonList = [
                    {
                        label:'保存',
                        callback:function(contentWindow){
                            contentWindow.appFrameObject.onSubmit(function(data){
                                that.msgSuccess('更新完成');
                                that.getAdminGrantList();
                                AppDialog.close(frameId);
                            });
                        }
                    },
                    {
                        label:'取消',
                        callback:function(contentWindow){
                            AppDialog.close(frameId);
                        }
                    }
                ];
                frameId = AppDialog.openFrame(AppCommon.getUrl('/adminGrant/addGrant?adminGrantId='+adminGrantId),'编辑权限',buttonList);
            },
            addSubmit:function(){
                var self = this;
                var para = Object.assign({}, this.addBase);
                if(this.test['num'] =="0"){
                    self.$message({
                        message: "模块名已存在，请重新填写",
                    });
                    return;
                }
                if(this.Tag['num'] =="0"){
                    self.$message({
                        message: "该标签已存在，请重新填写",
                    });
                    return;
                }
                this.$refs.addBase.validate((valid) => {
                    if (valid) {
                        var self = this;
                        AjaxLoader.post(AppCommon.getUrl('/adminGrant/add'),{para},function(data){
                            self.$message({
                                    showClose: true,
                                    message: data,
                                    type: 'success'
                                });
                        });
                        this.addAdminUser = false;
                        this.resetForm();
                    }else{
                        console.log("submit error");
                    }
                })
            },
            getAdminGrant:function(){
                var keytype = this.keytype;
                var keyword = this.keyword;
                this.getAdminGrantList(1,this.pageSize,keytype,keyword);
            },
            getAdminGrantList:function(page,pageSize,keytype,keyword){
                var self = this;
                this.listLoading = true;
                var page = page || this.page;
                var pageSize = pageSize || this.pageSize;
                AjaxLoader.post(AppCommon.getUrl('/adminGrant/getList'),{'keyword':keyword,'keytype':keytype,'page':page,'pageSize':pageSize},function(data){
                    self.adminGrantList = data['adminGrantList'];
                    self.total = data['total'];
                    self.listLoading = false;
                });
            },
            adminGrantAdd:function(){
                this.addAdminUser = true;
            },
            removeGrant:function(row){
                var self=this;
                this.$confirm('确认删除选中记录吗？', '提示', {
                        type: 'warning'
                    }).then(() => {
                        AjaxLoader.post(AppCommon.getUrl('/adminGrant/removeGrant'),{'adminGrantId':row},function(data){
                            self.$message({
                                type: 'success',
                                message: '删除成功'
                            })
                            self.getAdminGrantList();
                        });
                    }).catch(() => {
                });
            },

        resetForm:function() {
            location.reload();
        }
        },
        mounted:function(){
            this.getAdminGrantList();
            var tableHeight = document.documentElement.clientHeight - 150;
            this.tableHeight = tableHeight;
        }
    })
  </script>
