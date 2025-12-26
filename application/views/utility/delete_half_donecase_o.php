<style>
    A:active     {TEXT-DECORATION: none; COLOR: #0000AA}  
    A:link       {TEXT-DECORATION: none; COLOR: #0000AA}
    A:visited    {TEXT-DECORATION: none; COLOR: #0000AA}
    A:hover      {TEXT-DECORATION: underline; COLOR: #FF0000}
    td			 {FONT-FAMILY:ms sans serif;FONT-SIZE:8;COLOR:BLUE}
    .HEADING     { cursor: hand; font-family: Verdana,Arial,San Serif; font-size: 11px; color: #0033FF; 
                   background-color: #DDDDDD; font-weight: none;
                   border: 1px solid #000000;  }
    .SUBHEADING  { cursor: hand; font-family: Verdana,Arial,San Serif; font-size: 11px; color: #AAAAAA; 
                   background-color: lightyellow; font-weight: none; 
                   border: 1px solid #000000;  }               
    .LINKSOFF    { display: none; font-family: Verdana,Arial,San Serif; font-size: 12px; color: #000080 }
    .LINKSON     { display: inline; font-family: Verdana,Arial,San Serif; font-size: 12px; color: #000080 }
</style>
<script language="Javascript">
    function delconfirm() {
        var case_no = document.getElementById("case_no");
        if (case_no.value == "") {
            alert("Please enter a Case No.");
            return false;
        }
        var a;
        a = confirm("Are you sure you want to Delete the Case no " + case_no.value + " Permanently?")
        if (a == true)
            return true;
        else
            return false;
    }

</script>



<div class="row login">

    <div class="col-lg-12 ">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="well well-sm ">
                <center>
                    <h3 style="text-align: center; font-size: 28px">Office Half Done Case Deletion (Complete)</h3>
                    <h2 style="text-align: center; color: #fff; font-size: 34px"></h2>
                </center>
            </div>

            <div class="panel panel-form">
                <div class="panel-body">
                    <form name='frmDelete' method='post' action='<?php echo base_url() . "index.php/Utility/delete_half_done"; ?>'>
                        <table class='table table-bordered'>
                            <tr>
                                <td width="249" style="border-left-style: solid; border-left-width: 1; border-right-style: none; border-right-width: medium; border-top: 1px solid #6699FF; border-bottom-style: none; border-bottom-width: medium" valign="bottom" align="right">
                                    <font size="3" face="Verdana">Enter the Case No:</font>
                                <td width="337" style="border-left-style: none; border-left-width: medium; border-right-style: none; border-right-width: medium; border-top: 1px solid #6699FF; border-bottom-style: none; border-bottom-width: medium" valign="bottom">
                                    <input type="text" name="case_no" id="case_no" value="" size="50">						
                                </td>
                            </tr>
                        </table>
                        <p style="color:red;" class='center'>Please enter valid Half Done office case no.</p>
                        <table class='table table-bordered'>
                            <tr>
                                <td align=center>
                                    <input type="Submit" name="del_button" Value=" Delete !" onClick="return delconfirm();" style="color: #FF0000; font-weight: bold">
                                </td>
                            </tr>
                        </table>
                        <center>
                        <table style="WIDTH:600px;">
                            <tr>
                                <td align="center">
                                    <hr width="600px" color="#3399cc">
                                    <font face="Verdana" size="2">
                                    <a href="<?php echo base_url(); ?>index.php/home">[Home]</a></font>
                                </td>
                            </tr>
                        </table>
                        </center>
                    </form>	
                </div>
            </div>

        </div>
    </div>

</div>


<!--
























<%@ Language=VBScript %>
<%option explicit%>
<%Response.Buffer = true%>
#include file="../common/adovbs.inc"
#include file="../common/connection.asp"
 #include file="../common/check_auth.asp"
<%
if Session("u_code") = "" then
Response.Redirect "logout.asp"
end if
dim rs,TotFailure
set rs = Server.CreateObject("ADODB.Recordset")
TotFailure=0

%>


<HTML>
    <HEAD>
        <title>Dharitree Deletion Module</title>




        <% call load_iPlugin("../") %>
    </HEAD>

    <BODY leftmargin="0" topmargin="0" onLoad="plugin_load()" onUnload="return plugin_unload()">
    <center>


        <%
        dim objism,i
        set objism=server.CreateObject("ISMConverter.clsISMConverter")

        '================================================================================================================
        'ACTUAL DELETEION STARTS
        '================================================================================================================
        If Request.ServerVariables("REQUEST_METHOD")= "POST" then
        dim dcode,sdcode,ccode,mcode,lno,vcode,case_no
        case_no = Request.Form("case_no")
        dcode = Session("Dist_code")
        sdcode = Session("Subdiv_code")
        ccode = Session("Cir_code")
        mcode = Session("Mouza_Pargona_code")
        lno = Session("lot_no")
        vcode = Session("Vill_townprt_code")

        conn.BeginTrans
        ' rs.open "

        rs.open "select * from Petition_Basic where case_no='" & case_no & "'",conn,1,1

        'response.Write("select * from Petition_Basic where case_no='" & case_no & "'")
        'response.End()
        If Not RS.EOF Then
        conn.execute("exec Delete_Half_done_case_completly '"& case_no & "'")
        else
        TotFailure= 1
        End If 
        rs.close


        If TotFailure=0 then
        conn.CommitTrans
        %>
        <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#FF9933" width="39%" id="AutoNumber2" bgcolor="#FFFFCC">
            <tr>
                <td width="100%" style="border-right-style: none; border-right-width: medium" colspan="2">
                    <font face="ASBW-TTDurga" color="#FF0000" style="font-size: 16pt">
                    Case No <% Response.write case_no %> is Deleted Successfully.
                    </font>
                </td>
            </tr>
        </table>

        <%  else
        conn.RollbackTrans%>
        <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#FF9933" width="39%" id="Table1" bgcolor="#FFFFCC">
            <tr>
                <td width="100%" style="border-right-style: none; border-right-width: medium" colspan="2">
                    <font face="ASBW-TTDurga" color="#FF0000" style="font-size: 16pt">
                    Unable to Delete the Case no.<% Response.write case_no %>
                    </font>
                </td>
            </tr>
        </table>


        <%end if%>

        <%	end if				

        'DELETION ENDS
        '================================================================================================================
        %>	

    </CENTER>	
</BODY>
</HTML>
<%set rs=nothing
set conn=nothing
%>-->