
Public Class AccessArea

    Private Sub AccessArea_Load(sender As Object, e As EventArgs) Handles MyBase.Load
        con.Close()
        con.ConnectionString = "Server=" + server + ";port=" + port + ";uid=" + username + ";password=" + password + ";database=" + dbname + ";"

        With cmd
            .CommandText = "SELECT * FROM tbl_arealist ORDER BY AreaName"
            .Connection = con
        End With

        Try
            con.Open()
            dr = cmd.ExecuteReader
            While dr.Read = True
                ComboBox1.Items.Add(dr.GetValue(1).ToString)
            End While
        Catch ex As Exception
            MessageBox.Show(ex.Message.ToString)
        End Try
        ComboBox1.Text = accessSetting
    End Sub

    Private Sub cmdUpdate_Click(sender As Object, e As EventArgs) Handles cmdUpdate.Click
        My.Settings.accessArea = ComboBox1.Text
        My.Settings.Save()
        Me.Close()
    End Sub

    Private Sub Button1_Click(sender As Object, e As EventArgs) Handles Button1.Click
        Me.Close()
    End Sub
End Class