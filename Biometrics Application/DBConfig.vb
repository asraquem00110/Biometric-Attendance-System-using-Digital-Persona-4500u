Public Class DBConfig

    Private Sub DBConfig_Load(sender As Object, e As EventArgs) Handles MyBase.Load
        txtipadd.Text = My.Settings.IPadd.ToString
        txtusername.Text = My.Settings.userName.ToString
        txtpassword.Text = My.Settings.passw.ToString
        txtDatabase.Text = My.Settings.DbName.ToString
        txtroot.Text = My.Settings.Root.ToString
    End Sub

    Private Sub cmdUpdate_Click(sender As Object, e As EventArgs) Handles cmdUpdate.Click
        My.Settings.IPadd = txtipadd.Text
        My.Settings.userName = txtusername.Text
        My.Settings.passw = txtpassword.Text
        My.Settings.DbName = txtDatabase.Text
        My.Settings.Root = txtroot.Text
        My.Settings.Save()
        Me.Close()
    End Sub

    Private Sub Button1_Click(sender As Object, e As EventArgs) Handles Button1.Click
        Me.Close()
    End Sub
End Class