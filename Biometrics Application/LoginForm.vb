
Public Class LoginForm

    Private Sub cmdlogin_Click(sender As Object, e As EventArgs) Handles cmdlogin.Click
        verify(txtuname.Text, txtpassword.Text)
    End Sub

    Sub verify(ByVal uname, ByVal passw)
        con.Close()
        con.ConnectionString = "Server=" + server + ";port=" + port + ";uid=" + username + ";password=" + password + ";database=" + dbname + ";"

        With cmd
            .CommandText = "SELECT * FROM tb_user WHERE user_name = @uname AND pass_word = @passw AND userlevel = 'Admin'"
            .Connection = con
            .Parameters.AddWithValue("@uname", uname)
            .Parameters.AddWithValue("@passw", passw)
        End With
        Try
            con.Open()
            dr = cmd.ExecuteReader
            cmd.Parameters.Clear()

            If dr.HasRows Then

                If lblflag.Text = "register" Then
                    con.Close()
                    RegisterForm.Show()
                ElseIf lblflag.Text = "menuform" Then
                    VerificationForm.Close()
                    MenuForm.Show()
                ElseIf lblflag.Text = "dbconfig" Then
                    DBConfig.Show()
                End If
                Me.Close()
            Else
                lblerrormessage.Visible = True
            End If

        Catch ex As Exception
            MessageBox.Show(ex.Message.ToString)
        Finally
            con.Close()
        End Try
    End Sub

    Private Sub Button1_Click(sender As Object, e As EventArgs) Handles Button1.Click
        Me.Close()
    End Sub
End Class