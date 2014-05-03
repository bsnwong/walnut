##数据库说明
***
###1.用户表User
>#####1)说明：存储引擎为InnoDB
>#####2)表设计
<table>
    <tr>
        <td>字段名</td>
        <td>字段长度</td>
        <td>字段类型</td>
        <td>字段说明</td>
        <td>备注</td>
    </tr>
    <tr>
        <td>id</td>
        <td></td>
        <td>bigint</td>
        <td>自增长</td>
        <td></td>
    </tr>
    <tr>
        <td>name</td>
        <td>30</td>
        <td>varchar</td>
        <td>姓名</td>
        <td></td>
    </tr>
    <tr>
        <td>email</td>
        <td>50</td>
        <td>varchar</td>
        <td>邮箱</td>
        <td>主键</td>
    </tr>
    <tr>
        <td>password</td>
        <td>32</td>
        <td>varchar</td>
        <td>密码</td>
        <td>大于6位，小于等于32位</td>
    </tr>
    <tr>
        <td>type</td>
        <td></td>
        <td>enum</td>
        <td>用户类型</td>
        <td>具有管理员权限的用户(type:0)/普通用户(type:1)</td>
    </tr>
    <tr>
        <td>school_num</td>
        <td>15</td>
        <td>char</td>
        <td>学号</td>
        <td></td>
    </tr>
    <tr>
        <td>college</td>
        <td>10</td>
        <td>varchar</td>
        <td>学院</td>
        <td>代号表示</td>
    </tr>
    <tr>
        <td>school</td>
        <td>10</td>
        <td>varchar</td>
        <td>学校</td>
        <td>代号表示</td>
    </tr>
    <tr>
        <td>major</td>
        <td>10</td>
        <td>varchar</td>
        <td>专业</td>
        <td>代号表示</td>
    </tr>
    <tr>
        <td>created_at</td>
        <td></td>
        <td>date</td>
        <td>创建时间</td>
        <td></td>
    </tr><tr>
        <td>updated_at</td>
        <td></td>
        <td>date</td>
        <td>更新时间</td>
        <td></td>
    </tr>
    <tr>
        <td>sex</td>
        <td></td>
        <td>enum</td>
        <td>性别(男/女/其他)</td>
        <td>男(type:1)女(type:2)其他(type:0)</td>
    </tr>
</table>
***
###2.学校信息表School_info
>#####1)说明：存储引擎为InnoDB
>#####2)表设计
<table>
    <tr>
        <td>字段名</td>
        <td>字段长度</td>
        <td>字段类型</td>
        <td>字段说明</td>
        <td>备注</td>
    </tr>
    <tr>
        <td>id</td>
        <td></td>
        <td>bigint</td>
        <td>自增长</td>
        <td></td>
    </tr>
    <tr>
        <td>code</td>
        <td>10</td>
        <td>int</td>
        <td>代号</td>
        <td></td>
    </tr>
    <tr>
        <td>name</td>
        <td>50</td>
        <td>varchar</td>
        <td>名称</td>
        <td>包括学校/学院/专业</td>
    </tr>
    <tr>
        <td>parent_node</td>
        <td></td>
        <td>bigint</td>
        <td>父节点</td>
        <td>当值为0时，表示顶端节点，该值对应id中的值</td>
    </tr> 
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>   
</table>



***
<table>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr> 
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>   
</table>
















