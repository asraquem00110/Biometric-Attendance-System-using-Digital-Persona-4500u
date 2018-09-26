' NOTE: This form is inherited from the CaptureForm,
' so the VisualStudio Form Designer may not load this properly
' (at least until you build the project).
' If you want to make changes in the form layout - do it in the base CaptureForm.
' All changes in the CaptureForm will be reflected in all derived forms 
' (i.e. in the EnrollmentForm and in the VerificationForm)

Public Class VerificationForm
  Inherits CaptureForm

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

  Protected Overrides Sub Process(ByVal Sample As DPFP.Sample)
    MyBase.Process(Sample)

    ' Process the sample and create a feature set for the enrollment purpose.
    Dim features As DPFP.FeatureSet = ExtractFeatures(Sample, DPFP.Processing.DataPurpose.Verification)

    ' Check quality of the sample and start verification if it's good
    If Not features Is Nothing Then
      ' Compare the feature set with our template
      Dim result As DPFP.Verification.Verification.Result = New DPFP.Verification.Verification.Result()
      Verificator.Verify(features, Template, result)
      UpdateStatus(result.FARAchieved)
      If result.Verified Then
        MakeReport("The fingerprint was VERIFIED.")
      Else
        MakeReport("The fingerprint was NOT VERIFIED.")
      End If
    End If
  End Sub

  Protected Sub UpdateStatus(ByVal FAR As Integer)
    ' Show "False accept rate" value
    SetStatus(String.Format("False Accept Rate (FAR) = {0}", FAR))
  End Sub

End Class
