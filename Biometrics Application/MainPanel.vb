Imports DPFP
Public Class MainPanel

    Implements DPFP.Capture.EventHandler
    Private Capturer As DPFP.Capture.Capture
    Private Template As DPFP.Template


    Protected Overridable Sub Init()
        Try
            Capturer = New DPFP.Capture.Capture()                   ' Create a capture operation.

            If (Not Capturer Is Nothing) Then
                Capturer.EventHandler = Me                              ' Subscribe for capturing events.
            Else
                SetPrompt("Can't initiate capture operation!")
            End If
        Catch ex As Exception
            MessageBox.Show("Can't initiate capture operation!", "Error", MessageBoxButtons.OK, MessageBoxIcon.Error)
        End Try
    End Sub

    Protected Overridable Sub Process(ByVal Sample As DPFP.Sample)
        DrawPicture(ConvertSampleToBitmap(Sample))
    End Sub

    Protected Function ConvertSampleToBitmap(ByVal Sample As DPFP.Sample) As Bitmap
        Dim convertor As New DPFP.Capture.SampleConversion()  ' Create a sample convertor.
        Dim bitmap As Bitmap = Nothing              ' TODO: the size doesn't matter
        convertor.ConvertToPicture(Sample, bitmap)        ' TODO: return bitmap as a result
        Return bitmap
    End Function

    Protected Function ExtractFeatures(ByVal Sample As DPFP.Sample, ByVal Purpose As DPFP.Processing.DataPurpose) As DPFP.FeatureSet
        Dim extractor As New DPFP.Processing.FeatureExtraction()    ' Create a feature extractor
        Dim feedback As DPFP.Capture.CaptureFeedback = DPFP.Capture.CaptureFeedback.None
        Dim features As New DPFP.FeatureSet()
        extractor.CreateFeatureSet(Sample, Purpose, feedback, features) ' TODO: return features as a result?
        If (feedback = DPFP.Capture.CaptureFeedback.Good) Then
            Return features
        Else
            Return Nothing
        End If
    End Function

    Protected Sub StartCapture()
        If (Not Capturer Is Nothing) Then
            Try
                Capturer.StartCapture()
                SetPrompt("Using the fingerprint reader, scan your fingerprint.")
            Catch ex As Exception
                SetPrompt("Can't initiate capture!")
            End Try
        End If
    End Sub

    Protected Sub StopCapture()
        If (Not Capturer Is Nothing) Then
            Try
                Capturer.StopCapture()
            Catch ex As Exception
                SetPrompt("Can't terminate capture!")
            End Try
        End If
    End Sub


    Private Sub CaptureForm_Load(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MyBase.Load
        Init()
        StartCapture()
        cmdTimeIN.BackColor = Color.Green
        lbltime.Text = DateTime.Now.ToString("MMMM dd, yyyy   hh:mm:ss")
        WebBrowser1.Url = New Uri("http://" + server + "/" + root + "/getImage.php")
    End Sub

    Private Sub CaptureForm_FormClosed(ByVal sender As System.Object, ByVal e As System.Windows.Forms.FormClosedEventArgs) Handles MyBase.FormClosed
        StopCapture()
    End Sub

    Sub OnComplete(ByVal Capture As Object, ByVal ReaderSerialNumber As String, ByVal Sample As DPFP.Sample) Implements DPFP.Capture.EventHandler.OnComplete
        MakeReport("The fingerprint sample was captured.")
        SetPrompt("Scan the same fingerprint again.")
        Process(Sample)
    End Sub

    Sub OnFingerGone(ByVal Capture As Object, ByVal ReaderSerialNumber As String) Implements DPFP.Capture.EventHandler.OnFingerGone
        MakeReport("The finger was removed from the fingerprint reader.")
    End Sub

    Sub OnFingerTouch(ByVal Capture As Object, ByVal ReaderSerialNumber As String) Implements DPFP.Capture.EventHandler.OnFingerTouch
        MakeReport("The fingerprint reader was touched.")
    End Sub

    Sub OnReaderConnect(ByVal Capture As Object, ByVal ReaderSerialNumber As String) Implements DPFP.Capture.EventHandler.OnReaderConnect
        MakeReport("The fingerprint reader was connected.")
    End Sub

    Sub OnReaderDisconnect(ByVal Capture As Object, ByVal ReaderSerialNumber As String) Implements DPFP.Capture.EventHandler.OnReaderDisconnect
        MakeReport("The fingerprint reader was disconnected.")
    End Sub

    Sub OnSampleQuality(ByVal Capture As Object, ByVal ReaderSerialNumber As String, ByVal CaptureFeedback As DPFP.Capture.CaptureFeedback) Implements DPFP.Capture.EventHandler.OnSampleQuality
        If CaptureFeedback = DPFP.Capture.CaptureFeedback.Good Then
            MakeReport("The quality of the fingerprint sample is good.")
        Else
            MakeReport("The quality of the fingerprint sample is poor.")
        End If
    End Sub

    Protected Sub SetStatus(ByVal status)
        Invoke(New FunctionCall(AddressOf _SetStatus), status)
    End Sub

    Private Sub _SetStatus(ByVal status)
        ' StatusLine.Text = status
    End Sub

    Protected Sub SetPrompt(ByVal text)
        Invoke(New FunctionCall(AddressOf _SetPrompt), text)
    End Sub

    Private Sub _SetPrompt(ByVal text)
        Prompt.Text = text
    End Sub

    Protected Sub MakeReport(ByVal status)
        Invoke(New FunctionCall(AddressOf _MakeReport), status)
    End Sub

    Private Sub _MakeReport(ByVal status)
        StatusText.AppendText(status + Chr(13) + Chr(10))
    End Sub

    Protected Sub DrawPicture(ByVal bmp)
        Invoke(New FunctionCall(AddressOf _DrawPicture), bmp)
    End Sub

    Private Sub _DrawPicture(ByVal bmp)
        Picture.Image = New Bitmap(bmp, Picture.Size)
    End Sub

    Protected Sub DisplayFname(ByVal fname)
        Invoke(New FunctionCall(AddressOf _DisplayFname), fname)
    End Sub

    Private Sub _DisplayFname(ByVal fname)
        lblFullname.Text = fname.ToString
    End Sub

    Protected Sub DisplayDateHired(ByVal datehired)
        Invoke(New FunctionCall(AddressOf _DisplayDateHired), datehired)
    End Sub

    Private Sub _DisplayDateHired(ByVal fname)
        lblDatehired.Text = fname.ToString
    End Sub

    Protected Sub DisplayPosition(ByVal position)
        Invoke(New FunctionCall(AddressOf _DisplayPosition), position)
    End Sub

    Private Sub _DisplayPosition(ByVal position)
        lblPosition.Text = position.ToString
    End Sub

    Protected Sub DisplayAgency(ByVal agency)
        Invoke(New FunctionCall(AddressOf _DisplayAgency), agency)
    End Sub

    Private Sub _DisplayAgency(ByVal agency)
        lblAgency.Text = agency.ToString
    End Sub

    Protected Sub DisplayContact(ByVal contact)
        Invoke(New FunctionCall(AddressOf _DisplayContact), contact)
    End Sub

    Private Sub _DisplayContact(ByVal contact)
        lblContact.Text = contact.ToString
    End Sub

    Protected Sub DisplayProject(ByVal project)
        Invoke(New FunctionCall(AddressOf _DisplayProject), project)
    End Sub

    Private Sub _DisplayProject(ByVal project)
        lblProject.Text = project.ToString
    End Sub


    Protected Sub DisplayAccessArea(ByVal area)
        Invoke(New FunctionCall(AddressOf _DisplayAccessArea), area)
    End Sub

    Private Sub _DisplayAccessArea(ByVal area)
        lblAccessArea.Text = area.ToString
    End Sub

    Protected Sub DisplayRemark(ByVal remark)
        Invoke(New FunctionCall(AddressOf _DisplayRemark), remark)
    End Sub

    Private Sub _DisplayRemark(ByVal remark)
        If remark = "NO RECORD FOUND" Then
            lblRemarks.ForeColor = Color.Red
        ElseIf remark = "ACCESS GRANTED" Then
            lblRemarks.ForeColor = Color.Green
        Else
            lblRemarks.ForeColor = Color.Red
        End If
        lblRemarks.Text = remark.ToString
    End Sub

    Protected Sub DisplayAccessID(ByVal AccessID)
        Invoke(New FunctionCall(AddressOf _DisplayAccessID), AccessID)
    End Sub

    Private Sub _DisplayAccessID(ByVal AccessID)
        lblAccessID.Text = AccessID.ToString
    End Sub

    Protected Sub DisplayTimeData(ByVal timeData)
        Invoke(New FunctionCall(AddressOf _DisplayTimeData), timeData)
    End Sub

    Private Sub _DisplayTimeData(ByVal timeData)
        lblTimeData.Text = timeData.ToString
    End Sub

    Protected Sub DisplayImage(ByVal image)
        Invoke(New FunctionCall(AddressOf _DisplayImage), image)
    End Sub

    Private Sub _DisplayImage(ByVal image)
        If image = "" Then
            WebBrowser1.Url = New Uri("http://" + server + "/" + root + "/getImage.php")
        Else
            WebBrowser1.Url = New Uri("http://" + server + "/" + root + "/getImage.php?image=" + image.ToString + "")
        End If
    End Sub

    Private Sub cmdTimeIN_Click(sender As Object, e As EventArgs) Handles cmdTimeIN.Click
        cmdTimeIN.BackColor = Color.Green
        cmdTimeOut.BackColor = Control.DefaultBackColor
    End Sub

    Private Sub cmdTimeOut_Click(sender As Object, e As EventArgs) Handles cmdTimeOut.Click
        cmdTimeIN.BackColor = Control.DefaultBackColor
        cmdTimeOut.BackColor = Color.Green
    End Sub

    Private Sub cmdRegister_Click(sender As Object, e As EventArgs) Handles cmdRegister.Click
        txtuname.Text = ""
        txtpassword.Text = ""
        lblerrormessage.Visible = False
        panelLogin.Visible = True
    End Sub

    Private Declare Function GetAsyncKeyState Lib "user32" (ByVal vKey As Long) As Integer

    Private Sub Timer1_Tick(sender As Object, e As EventArgs) Handles Timer1.Tick
        lbltime.Text = DateTime.Now.ToString("MMMM dd, yyyy   hh:mm:ss")
    End Sub




    Protected Sub RefreshDetails(ByVal refresh)
        Invoke(New FunctionCall(AddressOf _RefreshDetails), refresh)
    End Sub

    Private Sub _RefreshDetails(ByVal refresh)
        WebBrowser1.Url = New Uri("http://" + server + "/" + root + "/getImage.php")
        lblAccessID.Text = ""
        lblTimeData.Text = ""
        lblFullname.Text = ""
        lblDatehired.Text = ""
        lblPosition.Text = ""
        lblAgency.Text = ""
        lblContact.Text = ""
        lblProject.Text = ""
        lblAccessArea.Text = ""
        lblRemarks.Text = ""
    End Sub


    Private Sub Timer2_Tick(sender As Object, e As EventArgs) Handles Timer2.Tick
        If GetAsyncKeyState(73) Or GetAsyncKeyState(105) Then
            cmdTimeIN.BackColor = Color.Green
            cmdTimeOut.BackColor = Control.DefaultBackColor
        ElseIf GetAsyncKeyState(79) Or GetAsyncKeyState(111) Then
            cmdTimeIN.BackColor = Control.DefaultBackColor
            cmdTimeOut.BackColor = Color.Green
        End If
    End Sub

    Private Sub Button1_Click(sender As Object, e As EventArgs) Handles Button1.Click
        panelLogin.Visible = False
    End Sub

    Private Sub Button2_Click(sender As Object, e As EventArgs) Handles Button2.Click
        verifyPersonnel(txtuname.Text, txtpassword.Text)
    End Sub

    Sub verifyPersonnel(ByVal uname, ByVal passw)
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

End Class