Delegate Sub FunctionCall(ByVal param)

Public Class MenuForm
    Dim accessSetting = My.Settings.accessArea.ToString

    Private Sub CloseButton_Click(ByVal sender As System.Object, ByVal e As System.EventArgs)
        Me.Close()
    End Sub


    Private Template As DPFP.Template

    Private Sub Button1_Click(sender As Object, e As EventArgs) Handles Button1.Click
        con.Close()
        Dim Verifier As New VerificationForm()
        Verifier.Verify(Template)
    End Sub

    Private Sub Button2_Click(sender As Object, e As EventArgs) Handles Button2.Click
        LoginForm.lblflag.Text = "register"
        LoginForm.Show()
        LoginForm.lblerrormessage.Visible = False
        LoginForm.txtuname.Text = ""
        LoginForm.txtpassword.Text = ""
        ' RegisterForm.Show()
    End Sub

    Private Sub Button3_Click(sender As Object, e As EventArgs) Handles Button3.Click
        Dim question As String = MessageBox.Show("Are you sure you want to Exit?", "System", MessageBoxButtons.YesNo, MessageBoxIcon.Question)
        If question = DialogResult.Yes Then
            Me.Close()
        End If
    End Sub

    Private Sub LinkLabel1_LinkClicked(sender As Object, e As LinkLabelLinkClickedEventArgs)
        AccessArea.Show()
    End Sub

    Private Sub Button4_Click(sender As Object, e As EventArgs) Handles Button4.Click
        DBConfig.Show()
    End Sub
End Class