
<div id="app">
  <el-row class="container main-content" >
        <el-col :span="24" class="main">
            <section class="content-container fix-content">
                <!--工具条-->
                <el-col :span="24" class="toolbar">
                    <div class="fl">
                        <el-button type="danger" icon="el-icon-plus" size="small" @click="addRole">新增角色</el-button>
                    </div>
                    <div class="fr top-search">
                        <el-button-group>
                          <el-input placeholder="请输入查询内容" v-model="keyword" class="input-with-select" size="small">
                            <el-select slot="prepend" placeholder="请选择" size="small" v-model="keytype">
                              <el-option label="角色名称" value="name"></el-option>
                            </el-select>
                            <el-button slot="append" icon="el-icon-search" size="small" @click="getAccountList()"></el-button>
                          </el-input>
                        </el-button-group>
                    </div>
                </el-col>
              <!-- tools -->

              <!--列表-->
              <el-table  :data="roleList" highlight-current-row v-loading="listLoading"  style="width: 100%;" :max-height=tableHeight>
                  <el-table-column prop="adminRoleId" label="角色ID" width="80">
                  </el-table-column>
                  <el-table-column prop="name" label="角色名" width="120">
                  </el-table-column>
                  <el-table-column prop="tagListName" show-overflow-tooltip label="权限列表">
                  </el-table-column>
                  <el-table-column prop="content" label="备注" width="220">
                  </el-table-column>
                  <el-table-column label="操作" width="140" fixed="right">
                      <template scope="scope">
                          <el-button type="text" size="small" @click="updateRole(scope.row.adminRoleId)">编辑</el-button>
                          <el-button type="text" size="small" @click="del(scope.row.adminRoleId)">删除</el-button>
                      </template>
                  </el-table-column>
              </el-table>
              <!--列表-->
              
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
          listLoading: false,
          addRoleFrom:false,
          title:'',
          roleList:[],
          roleDatakindName:[],
          nouse:false,
          tableHeight:500,
          currentPage:1,
          total: 1,
          kindName:[],
          pageSize:20,
          page: 1,
          keytype:'name',
          keyword:'',
          regiontype:'',
          queryString:'',
          checkAll: true,
          role: [],
          isIndeterminate: true,
        },
        methods: {  
            handleCurrentChange:function(val) {
                this.getRoleList(val,this.pageSize);
            },
            handleSizeChange:function(val) {
                this.pageSize = val;
                this.currentPage = 1;
                this.getRoleList(1,val);
            },
            getRoleList:function(keytype,keyword,region,province,city,district){
                var self = this;
                this.listLoading = true;
                AjaxLoader.post(AppCommon.getUrl('/adminRole/getRoleList'),{'keytype':keytype,'keyword':keyword},function(data){
                    self.roleList = data['list'];
                    self.total = data['total'];
                    self.listLoading = false;
                })
            },
            addRole:function(){
                var that = this;
                var frameId = '';
                var buttonList = [
                    {
                        label:'保存',
                        callback:function(contentWindow){
                            contentWindow.appFrameObject.onSubmit(function(data){
                                that.msgSuccess('添加完成');
                                that.getRoleList();
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
                frameId = AppDialog.openFrame(AppCommon.getUrl('/adminRole/addRole'),'新增角色',buttonList);
            },
            updateRole:function(adminRoleId){
                var that = this;
                var frameId = '';
                var buttonList = [
                    {
                        label:'保存',
                        callback:function(contentWindow){
                            contentWindow.appFrameObject.onSubmit(function(data){
                                that.msgSuccess('修改完成');
                                that.getRoleList();
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
                frameId = AppDialog.openFrame(AppCommon.getUrl('/adminRole/addRole?adminRoleId='+adminRoleId),'修改角色',buttonList);
            },
            del:function(adminRoleId){
                var self=this;
                if (adminRoleId == 1) {
                    return this.msgError('超级管理员禁止删除!');
                }
                this.$confirm('确认删除选中记录吗？', '提示', {
                    type: 'warning'
                }).then(() => {
                        AjaxLoader.post(AppCommon.getUrl('/adminRole/DelAdminRole'),{'adminRoleId':adminRoleId},function(data){
                        self.$message({
                                type: 'success',
                                message: '删除成功'
                                })
                        self.getRoleList();
                        });
                    }).catch(() => {
                });
            },
        },
        mounted:function() {
            this.getRoleList();
        },

    })
</script>
