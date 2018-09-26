' NOTE: This form is a base for the EnrollmentForm and the VerificationForm,
'	All changes in the CaptureForm will be reflected in all its derived forms.

Public Class CaptureForm
  Implements DPFP.Capture.EventHandler

  Private Capturer As DPFP.Capture.Capture

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
    StatusLine.Text = status
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
End Class