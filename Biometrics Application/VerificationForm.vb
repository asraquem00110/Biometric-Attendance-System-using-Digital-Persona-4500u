'NOTE: THIS FORM INHERITS MAINPANEL
'Use Template or features in getting hexvalue

Imports System.IO

Public Class VerificationForm
    Inherits MainPanel
    Private Template As DPFP.Template
    Private Verificator As DPFP.Verification.Verification

    Public Sub Verify(ByVal template As DPFP.Template)
        Me.Template = template
        ShowDialog()
    End Sub

    Protected Overrides Sub Init()
        MyBase.Init()
        MyBase.Text = "Fingerprint Verification"
        Verificator = New DPFP.Verification.Verification()
        UpdateStatus(0)
    End Sub

    Public Shared Function ByteArrayToHex(ByVal byteArray As Byte())

        Dim strTemplate As String
        Dim strTmplt As String
        Dim lowBound As Integer = byteArray.GetLowerBound(0)
        Dim upBound As Integer = byteArray.GetUpperBound(0)

        For i As Integer = lowBound To upBound
            strTmplt = String.Format("{0:X2}", byteArray(i))
            strTemplate += strTmplt
        Next
        Return strTemplate

    End Function

    Protected Overrides Sub Process(ByVal Sample As DPFP.Sample)
        con.Close()
        MyBase.Process(Sample)
        ' Process the sample and create a feature set for the enrollment purpose.
        Dim features As DPFP.FeatureSet = ExtractFeatures(Sample, DPFP.Processing.DataPurpose.Verification)

        'If Not Template Is Nothing Then
        ' Check quality of the sample and start verification if it's good
        If Not features Is Nothing Then
            ' Compare the feature set with our template
            Dim accessSetting = My.Settings.accessArea.ToString

            con.ConnectionString = "Server=" + server + ";port=" + port + ";uid=" + username + ";password=" + password + ";database=" + dbname + ";"
            ' GET ALL PERSONNELS 
            'cmd.CommandText = "SELECT a.AccessID,a.FullName,a.DateHired,a.Position,a.AgencyCompany,a.ProjectAssigned,a.ContactNo,a.AccessArea,a.Remarks,b.fpData,a.Image,a.Status,a.EntryID FROM tbl_personnel a RIGHT JOIN tbl_bio b ON a.EntryID = b.refno"

            If accessSetting <> "ALL" And accessSetting <> "" Then
                cmd.CommandText = "SELECT a.AccessID,a.FullName,a.DateHired,a.Position,a.AgencyCompany,a.ProjectAssigned,a.ContactNo,a.AccessArea,a.Remarks,b.fpData,a.Image,a.Status,a.EntryID FROM tbl_personnel a RIGHT JOIN tbl_bio b ON a.EntryID = b.refno WHERE a.Status <> 'Resigned' AND a.Status <> 'Terminated' AND a.AccessArea LIKE '%" + accessSetting + "%'"
            Else
                cmd.CommandText = "SELECT a.AccessID,a.FullName,a.DateHired,a.Position,a.AgencyCompany,a.ProjectAssigned,a.ContactNo,a.AccessArea,a.Remarks,b.fpData,a.Image,a.Status,a.EntryID FROM tbl_personnel a RIGHT JOIN tbl_bio b ON a.EntryID = b.refno WHERE a.Status <> 'Resigned' AND a.Status <> 'Terminated'"
            End If

            cmd.Connection = con
            Dim MemStream As IO.MemoryStream
            Dim fpBytes As Byte()
            Dim AccessID As String = ""
            Dim resultMessage As String = ""
            Try
                con.Open()
                dr = cmd.ExecuteReader
                While dr.Read = True
                    fpBytes = dr.GetValue(9)
                    MemStream = New IO.MemoryStream(fpBytes)
                    Dim template As New DPFP.Template(MemStream)
                    'template.DeSerialize(MemStream)
                    Dim result As DPFP.Verification.Verification.Result = New DPFP.Verification.Verification.Result()
                    Verificator.Verify(features, template, result)
                    UpdateStatus(result.FARAchieved)
                    If result.Verified Then
                        Dim timenow = DateTime.Now.ToString("hh:mm")
                        resultMessage = "the fingerprint was verified."
                        AccessID = dr.GetValue(0)
                        Exit While
                    Else
                        resultMessage = "the fingerprint was not verified."
                    End If
                End While
                MakeReport(resultMessage)

                If (AccessID.Length <> 0) Then
                    Dim TimeData = DateTime.Now().ToString("yyyy-MM-dd HH:mm:ss")
                    Dim Timenow = DateTime.Now().ToString("hh:mm:ss")
                    Dim statusdes As String
                    DisplayFname(dr.GetValue(1).ToString.ToUpper())
                    DisplayDateHired(dr.GetValue(2).ToString.ToUpper())
                    DisplayPosition(dr.GetValue(3).ToString.ToUpper())
                    DisplayAgency(dr.GetValue(4).ToString.ToUpper())
                    DisplayContact(dr.GetValue(6).ToString.ToUpper())
                    DisplayProject(dr.GetValue(5).ToString.ToUpper())
                    DisplayAccessArea(dr.GetValue(7).ToString.ToUpper())

                    ' settings accessarea

                    Dim areaAllowed = dr.GetValue(7).split(",")


                    If dr.GetValue(11).ToString <> "" Then
                        statusdes = dr.GetValue(11).ToString
                    ElseIf accessSetting <> "ALL" And accessSetting <> "" Then
                        For x As Integer = 0 To areaAllowed.length - 1
                            If areaAllowed(x) = accessSetting Then
                                statusdes = "ACCESS GRANTED"
                                Exit For
                            Else
                                statusdes = "ACCESS DENIED"
                            End If
                        Next
                    Else
                        statusdes = "ACCESS GRANTED"
                    End If

                    DisplayRemark(statusdes)

                    DisplayImage(dr.GetValue(10).ToString)
                    DisplayAccessID(AccessID.ToString.ToUpper)
                    TimeDatalogs(AccessID, TimeData, dr.GetValue(8), dr.GetValue(1), dr.GetValue(7), statusdes, dr.GetValue(6), dr.GetValue(4), Timenow, dr.GetValue(12).ToString)
                Else
                    DisplayRemark("ACCESS DENIED")
                    DisplayFname("")
                    DisplayDateHired("")
                    DisplayPosition("")
                    DisplayAgency("")
                    DisplayContact("")
                    DisplayProject("")
                    DisplayAccessArea("")
                    DisplayImage("")
                    DisplayAccessID("")
                    DisplayTimeData("")
                End If

            Catch ex As Exception
                MakeReport(ex.Message.ToString)
                DisplayRemark(ex.Message.ToString)
            Finally
                con.Close()
            End Try




            'Dim result As DPFP.Verification.Verification.Result = New DPFP.Verification.Verification.Result()
            'Verificator.Verify(features, Template, result)
            'UpdateStatus(result.FARAchieved)
            'If result.Verified Then
            '    MakeReport("the fingerprint was verified.")
            'Else
            '    MakeReport("the fingerprint was not verified.")
            'End If
        End If
        'Else
        'MessageBox.Show("No Template")
        'End If
    End Sub

    Sub TimeDatalogs(ByVal AccessID, ByVal TimeData, ByVal Remarks, ByVal Fullname, ByVal AccessArea, ByVal Status, ByVal ContactPerson, ByVal Company, ByVal TimeNow, ByVal refno)
        con.Close()
        Dim TimeDes As String

        Dim query As String
        If (cmdTimeIN.BackColor = Color.Green) Then
            TimeDes = "IN"
        Else
            TimeDes = "OUT"
        End If

        Dim datenow = DateTime.Now().ToString("yyyy-MM-dd")

        query = "INSERT INTO tbl_in_out (AccessID,TimeRecord,TimeFlag,Remarks,Fullname,AccessArea,Status,ContactPerson,Company,refno) VALUES ('" + AccessID + "','" + TimeData + "','" + TimeDes + "','" + Remarks + "','" + Fullname + "','" + AccessArea + "','" + Status + "','" + ContactPerson + "','" + Company + "','" + refno + "')"
        With cmd
            .CommandText = query
            .Connection = con
        End With
        Try
            con.Open()
            cmd.ExecuteNonQuery()
        Catch ex As Exception
            MessageBox.Show(ex.Message.ToString)
        End Try
        DisplayTimeData(TimeDes + " || " + TimeNow)

        ' query = "SELECT IDno,TIME(TimeIn),TIME(TimeOut) FROM tbl_in_out WHERE AccessID = '" + AccessID + "' AND refno = '" + refno + "' AND (DATE(TimeIn) = '" + datenow + "' OR DATE(TimeOut) = '" + datenow + "')"
        '  With cmd
        '   .CommandText = query
        '   .Connection = con
        'End With

        'Try
        'con.Open()
        'dr = cmd.ExecuteReader
        'If dr.HasRows Then
        'dr.Read()
        'Dim id As Integer = dr.GetValue(0)
        'con.Close()
        'cmd.CommandText = "UPDATE tbl_in_out SET " + TimeDes + "='" + TimeData + "' WHERE IDno = " + id.ToString + ""
        'cmd.Connection = con
        'Try
        'con.Open()
        'cmd.ExecuteNonQuery()
        'Catch ex As Exception
        'MessageBox.Show(ex.Message.ToString)
        'End Try
        'Else
        'con.Close()
        'query = "INSERT INTO tbl_in_out(AccessID," + TimeDes + ",Remarks,FullName,AccessArea,Status,ContactPerson,Company,refno) VALUES ('" + AccessID + "','" + TimeData + "','" + Remarks + "','" + Fullname + "','" + AccessArea + "','" + Status + "','" + ContactPerson + "','" + Company + "','" + refno + "')"
        'cmd.CommandText = query

        'Try
        'con.Open()
        'cmd.ExecuteNonQuery()
        'Catch ex As Exception
        'MessageBox.Show(ex.Message.ToString)
        'End Try

        'End If


        ' make counter , After 10 seconds details will be cleared * MainPanel.vb
        ' RefreshDetails(1)
        ' Catch ex As Exception
        'MessageBox.Show(ex.Message.ToString)
        ' Finally
        'con.Close()
        ' End Try
    End Sub



    Protected Sub UpdateStatus(ByVal FAR As Integer)
        ' Show "False accept rate" value
        SetStatus(String.Format("False Accept Rate (FAR) = {0}", FAR))
    End Sub


    Sub GetPersonnel(ByVal AccessID)
        con.Close()
        With cmd
            .CommandText = "SELECT * FROM tbl_personnel WHERE AccessID = @accessID"
            .Connection = con
            .Parameters.AddWithValue("@accessID", AccessID)
        End With
        Try
            con.Open()
            dr = cmd.ExecuteReader
            cmd.Parameters.Clear()
            While dr.Read = True
                DisplayFname(dr.GetValue(3).ToString.ToUpper())
                DisplayDateHired(dr.GetValue(7).ToString.ToUpper())
                DisplayPosition(dr.GetValue(8).ToString.ToUpper())
                DisplayAgency(dr.GetValue(9).ToString.ToUpper())
                DisplayContact(dr.GetValue(11).ToString.ToUpper())
                DisplayProject(dr.GetValue(10).ToString.ToUpper())
                DisplayAccessArea(dr.GetValue(12).ToString.ToUpper())
                DisplayRemark(dr.GetValue(15).ToString.ToUpper())
            End While
        Catch ex As Exception
            MessageBox.Show(ex.Message.ToString)
        End Try
    End Sub




    Private Sub InitializeComponent()
        Me.SuspendLayout()
        '
        'VerificationForm
        '
        Me.AutoScaleDimensions = New System.Drawing.SizeF(6.0!, 13.0!)
        Me.ClientSize = New System.Drawing.Size(987, 790)
        Me.Location = New System.Drawing.Point(0, 0)
        Me.Name = "VerificationForm"
        Me.TopMost = True
        Me.ResumeLayout(False)

    End Sub
End Class
