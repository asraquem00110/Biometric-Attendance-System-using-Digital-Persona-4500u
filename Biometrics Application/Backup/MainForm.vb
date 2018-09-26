Delegate Sub FunctionCall(ByVal param)

Public Class MainForm

  Private Sub EnrollButton_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles EnrollButton.Click
    Dim Enroller As New EnrollmentForm()
    AddHandler Enroller.OnTemplate, AddressOf OnTemplate
    Enroller.ShowDialog()
  End Sub

  Private Sub VerifyButton_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles VerifyButton.Click
    Dim Verifier As New VerificationForm()
    Verifier.Verify(Template)
  End Sub

  Private Sub SaveButton_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles SaveButton.Click
    Dim save As New SaveFileDialog()
    save.Filter = "Fingerprint Template File (*.fpt)|*.fpt"
    If save.ShowDialog() = Windows.Forms.DialogResult.OK Then
      ' Write template into the file stream
      Using fs As IO.FileStream = IO.File.Open(save.FileName, IO.FileMode.Create, IO.FileAccess.Write)
        Template.Serialize(fs)
      End Using
    End If

  End Sub

  Private Sub LoadButton_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles LoadButton.Click
    Dim open As New OpenFileDialog()
    open.Filter = "Fingerprint Template File (*.fpt)|*.fpt"
    If open.ShowDialog() = Windows.Forms.DialogResult.OK Then
      Using fs As IO.FileStream = IO.File.OpenRead(open.FileName)
        Dim template As New DPFP.Template(fs)
        OnTemplate(template)
      End Using
    End If
  End Sub

  Private Sub CloseButton_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles CloseButton.Click
    Close()
  End Sub

  Private Sub OnTemplate(ByVal template)
    Invoke(New FunctionCall(AddressOf _OnTemplate), template)
  End Sub

  Private Sub _OnTemplate(ByVal template)
    Me.Template = template
    VerifyButton.Enabled = (Not template Is Nothing)
    SaveButton.Enabled = (Not template Is Nothing)
    If Not template Is Nothing Then
      MessageBox.Show("The fingerprint template is ready for fingerprint verification.", "Fingerprint Enrollment")
    Else
      MessageBox.Show("The fingerprint template is not valid. Repeat fingerprint enrollment.", "Fingerprint Enrollment")
    End If
  End Sub


  Private Template As DPFP.Template
End Class
