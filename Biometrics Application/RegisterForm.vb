Imports System.IO

Public Class RegisterForm
    Private Sub EnrollButton_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles EnrollButton.Click
        Dim Enroller As New EnrollmentForm()
        AddHandler Enroller.OnTemplate, AddressOf OnTemplate
        Enroller.ShowDialog()
    End Sub

    Private Sub CloseButton_Click(ByVal sender As System.Object, ByVal e As System.EventArgs)
        Me.Close()
    End Sub

    Private Sub OnTemplate(ByVal template)
        Invoke(New FunctionCall(AddressOf _OnTemplate), template)
    End Sub

    Private Sub _OnTemplate(ByVal template)
        Me.Template = template
        ' VerifyButton.Enabled = (Not template Is Nothing)
        ' SaveButton.Enabled = (Not template Is Nothing)
        If Not template Is Nothing Then
            MessageBox.Show("The fingerprint template is ready.", "Fingerprint Enrollment")
            Button1.Enabled = True
        Else
            MessageBox.Show("The fingerprint template is not valid. Repeat fingerprint enrollment.", "Fingerprint Enrollment")
        End If
    End Sub


    Private Template As DPFP.Template

    Private Sub Button1_Click(sender As Object, e As EventArgs) Handles Button1.Click
        Dim fingerprintData As MemoryStream = New MemoryStream
        con.Close()
        Template.Serialize(fingerprintData)
        fingerprintData.Position = 0
        Dim br As BinaryReader = New BinaryReader(fingerprintData)
        Dim bytes() As Byte = br.ReadBytes(CType(fingerprintData.Length, Int32))
        ' Dim fpstring As String = System.Text.ASCIIEncoding.ASCII.GetString(bytes)

        Dim flag As Integer
        Dim AccessID As String
        Dim refnumber As Integer
        AccessID = txtAccessID.Text
        refnumber = lblrefno.Text
        If rbtPrimary.Checked = True Then
            flag = 1
        Else
            flag = 2
        End If

        If Not Template Is Nothing Then
            con.ConnectionString = "Server=" + server + ";port=" + port + ";uid=" + username + ";password=" + password + ";database=" + dbname + ";"
            With cmd
                .CommandText = "SELECT * FROM tbl_bio WHERE refno = @refnumber AND fpType = @flag"
                .Connection = con
                .Parameters.AddWithValue("@refnumber", refnumber)
                .Parameters.AddWithValue("@flag", flag)
            End With

            Try
                con.Open()
                dr = cmd.ExecuteReader
                cmd.Parameters.Clear()
                If dr.HasRows Then
                    DeleteBio(AccessID, flag, refnumber)
                    InsertBio(AccessID, bytes, flag, refnumber)
                Else
                    InsertBio(AccessID, bytes, flag, refnumber)
                End If

            Catch ex As Exception
                MessageBox.Show(ex.Message.ToString)
            Finally
                con.Close()
            End Try

            Button1.Enabled = False
            If txtSearch.Text <> "" Then
                SearchPersonnel(txtSearch.Text)
            Else
                GetAllBio()
            End If
        End If

    End Sub

    Private Sub Button2_Click(sender As Object, e As EventArgs)
        Dim Verifier As New VerificationForm()
        Verifier.Verify(Template)
    End Sub


    Sub DeleteBio(ByVal accessID, ByVal flag, ByVal refno)
        con.Close()
        With cmd
            .CommandText = "DELETE FROM tbl_bio WHERE refno = @refno AND fpType = @flag"
            .Connection = con
            .Parameters.AddWithValue("@refno", refno)
            .Parameters.AddWithValue("@flag", flag)
        End With

        Try
            con.Open()
            cmd.ExecuteNonQuery()
            cmd.Parameters.Clear()
        Catch ex As Exception
            MessageBox.Show(ex.Message.ToString)
        End Try
    End Sub

    Sub InsertBio(ByVal accessID, ByVal bytes, ByVal flag, ByVal refno)
        con.Close()
        With cmd
            .CommandText = "INSERT INTO tbl_bio (AccessID,fpData,fpType,refno) VALUES (@accessID,@fp,@flag,@refno)"
            .Connection = con
            .Parameters.AddWithValue("@accessID", accessID)
            .Parameters.AddWithValue("@fp", bytes)
            .Parameters.AddWithValue("@flag", flag)
            .Parameters.AddWithValue("@refno", refno)
        End With
        Try
            con.Open()
            cmd.ExecuteNonQuery()
            cmd.Parameters.Clear()
            MessageBox.Show("Successful")
        Catch ex As Exception
            MessageBox.Show(ex.Message.ToString)
        End Try
    End Sub

    Sub GetAllBio()
        Dim index As Integer = 0
        Dim pRem As String
        Dim sRem As String
        con.Close()
        DataGridView1.Rows.Clear()
        con.ConnectionString = "Server=" + server + ";port=" + port + ";uid=" + username + ";password=" + password + ";database=" + dbname + ";"
        With cmd
            .CommandText = "SELECT AccessID as aID,Fullname,Position,(SELECT COUNT(*) FROM tbl_bio WHERE refno = EntryID AND fptype = 1) as fprimary,(SELECT COUNT(*) FROM tbl_bio WHERE refno = EntryID AND fptype = 2) as fsecondary,Image,AgencyCompany,ProjectAssigned,AccessArea,Status,EntryID FROM tbl_personnel ORDER by FUllname ASC"
            .Connection = con
        End With

        Try
            con.Open()
            dr = cmd.ExecuteReader
            While dr.Read = True
                If dr.GetValue(3) > 0 Then
                    pRem = "REGISTERED"
                Else
                    pRem = "NOT REGISTERED"
                End If

                If dr.GetValue(4) > 0 Then
                    sRem = "REGISTERED"
                Else
                    sRem = "NOT REGISTERED"
                End If

                DataGridView1.Rows.Insert(index, New Object() {index + 1, dr.GetValue(0), dr.GetValue(1), dr.GetValue(2), dr.GetValue(6), dr.GetValue(7), dr.GetValue(8), dr.GetValue(5), pRem, sRem, dr.GetValue(9), dr.GetValue(10)})
                DataGridView1.Rows(index).Cells(1).Style.Alignment = DataGridViewContentAlignment.MiddleCenter
                DataGridView1.Rows(index).Cells(5).Style.Alignment = DataGridViewContentAlignment.MiddleCenter
                DataGridView1.Rows(index).Cells(6).Style.Alignment = DataGridViewContentAlignment.MiddleCenter
                If pRem = "REGISTERED" Then
                    DataGridView1.Rows(index).Cells(8).Style.BackColor = Color.Green
                    DataGridView1.Rows(index).Cells(8).Style.ForeColor = Color.White
                Else
                    DataGridView1.Rows(index).Cells(8).Style.BackColor = Color.Maroon
                    DataGridView1.Rows(index).Cells(8).Style.ForeColor = Color.White
                End If

                If sRem = "REGISTERED" Then
                    DataGridView1.Rows(index).Cells(9).Style.BackColor = Color.Green
                    DataGridView1.Rows(index).Cells(9).Style.ForeColor = Color.White
                Else
                    DataGridView1.Rows(index).Cells(9).Style.BackColor = Color.Maroon
                    DataGridView1.Rows(index).Cells(9).Style.ForeColor = Color.White
                End If

                index = index + 1
            End While
        Catch ex As Exception
            MessageBox.Show(ex.Message.ToString)
        Finally
            con.Close()
        End Try


    End Sub

    Private Sub RegisterForm_Load(sender As Object, e As EventArgs) Handles MyBase.Load
        GetAllBio()
        WebBrowser1.Url = New Uri("http://" + server + "/" + root + "/getImage.php")
    End Sub



    Sub SearchPersonnel(ByVal SearchQuery As String)
        con.Close()
        DataGridView1.Rows.Clear()
        Dim pRem As String
        Dim sRem As String
        Dim index As Integer = 0

        With cmd
            .CommandText = "SELECT AccessID as aID,Fullname,Position,(SELECT COUNT(*) FROM tbl_bio WHERE refno = EntryID AND fptype = 1) as fprimary,(SELECT COUNT(*) FROM tbl_bio WHERE refno = EntryID AND fptype = 2) as fsecondary,Image,AgencyCompany,ProjectAssigned,AccessArea,Status,EntryID FROM tbl_personnel WHERE AccessID LIKE @query OR FullName LIKE @query ORDER by FUllname ASC"
            .Connection = con
            .Parameters.AddWithValue("@query", "%" + SearchQuery + "%")
        End With
        Try
            con.Open()
            dr = cmd.ExecuteReader
            cmd.Parameters.Clear()
            While dr.Read = True
                If dr.GetValue(3) > 0 Then
                    pRem = "REGISTERED"
                Else
                    pRem = "NOT REGISTERED"
                End If

                If dr.GetValue(4) > 0 Then
                    sRem = "REGISTERED"
                Else
                    sRem = "NOT REGISTERED"
                End If

                DataGridView1.Rows.Insert(index, New Object() {index + 1, dr.GetValue(0), dr.GetValue(1), dr.GetValue(2), dr.GetValue(6), dr.GetValue(7), dr.GetValue(8), dr.GetValue(5), pRem, sRem, dr.GetValue(9), dr.GetValue(10)})

                DataGridView1.Rows(index).Cells(1).Style.Alignment = DataGridViewContentAlignment.MiddleCenter
                DataGridView1.Rows(index).Cells(5).Style.Alignment = DataGridViewContentAlignment.MiddleCenter
                DataGridView1.Rows(index).Cells(6).Style.Alignment = DataGridViewContentAlignment.MiddleCenter
                If pRem = "REGISTERED" Then
                    DataGridView1.Rows(index).Cells(8).Style.BackColor = Color.Green
                    DataGridView1.Rows(index).Cells(8).Style.ForeColor = Color.White
                Else
                    DataGridView1.Rows(index).Cells(8).Style.BackColor = Color.Maroon
                    DataGridView1.Rows(index).Cells(8).Style.ForeColor = Color.White
                End If

                If sRem = "REGISTERED" Then
                    DataGridView1.Rows(index).Cells(9).Style.BackColor = Color.Green
                    DataGridView1.Rows(index).Cells(9).Style.ForeColor = Color.White
                Else
                    DataGridView1.Rows(index).Cells(9).Style.BackColor = Color.Maroon
                    DataGridView1.Rows(index).Cells(9).Style.ForeColor = Color.White
                End If

                index = index + 1
            End While
        Catch ex As Exception
            MessageBox.Show(ex.Message.ToString)
        End Try
    End Sub

    Private Sub txtSearch_TextChanged(sender As Object, e As EventArgs) Handles txtSearch.TextChanged
        If txtSearch.Text = "" Then
            GetAllBio()
        Else
            SearchPersonnel(txtSearch.Text)
        End If
    End Sub


    Private Sub Button3_Click(sender As Object, e As EventArgs) Handles Button3.Click
        Me.Close()
        MenuForm.Show()
    End Sub


    Private Sub DataGridView1_MouseClick(sender As Object, e As MouseEventArgs) Handles DataGridView1.MouseClick
        Dim AccessID = DataGridView1(1, DataGridView1.CurrentRow.Index).Value.ToString
        Dim FullName = DataGridView1(2, DataGridView1.CurrentRow.Index).Value.ToString
        Dim Image = DataGridView1(7, DataGridView1.CurrentRow.Index).Value.ToString
        Dim position = DataGridView1(3, DataGridView1.CurrentRow.Index).Value.ToString
        Dim company = DataGridView1(4, DataGridView1.CurrentRow.Index).Value.ToString
        Dim project = DataGridView1(5, DataGridView1.CurrentRow.Index).Value.ToString
        Dim area = DataGridView1(6, DataGridView1.CurrentRow.Index).Value.ToString
        Dim refno = DataGridView1(11, DataGridView1.CurrentRow.Index).Value.ToString

        If Image <> "" Then
            WebBrowser1.Url = New Uri("http://" + server + "/" + root + "/getImage.php?image=" + Image + "")
        Else
            WebBrowser1.Url = New Uri("http://" + server + "/" + root + "/getImage.php")
        End If

        txtAccessID.Text = AccessID
        txtFullname.Text = FullName
        txtposition.Text = position
        txtcompany.Text = company
        txtproject.Text = project
        txtaccessarea.Text = area
        lblrefno.Text = refno
    End Sub
End Class