' NOTE: This form is inherited from the CaptureForm,
' so the VisualStudio Form Designer may not load this properly
' (at least until you build the project).
' If you want to make changes in the form layout - do it in the base CaptureForm.
' All changes in the CaptureForm will be reflected in all derived forms 
' (i.e. in the EnrollmentForm and in the VerificationForm)

Public Class EnrollmentForm
  Inherits CaptureForm

  Public Event OnTemplate(ByVal template)

  Private Enroller As DPFP.Processing.Enrollment

  Protected Overrides Sub Init()
    MyBase.Init()
    MyBase.Text = "Fingerprint Enrollment"
    Enroller = New DPFP.Processing.Enrollment()     ' Create an enrollment.
    UpdateStatus()
  End Sub

  Protected Overrides Sub Process(ByVal Sample As DPFP.Sample)
    MyBase.Process(Sample)

    ' Process the sample and create a feature set for the enrollment purpose.
    Dim features As DPFP.FeatureSet = ExtractFeatures(Sample, DPFP.Processing.DataPurpose.Enrollment)

    ' Check quality of the sample and add to enroller if it's good
    If (Not features Is Nothing) Then
      Try
        MakeReport("The fingerprint feature set was created.")
        Enroller.AddFeatures(features)        ' Add feature set to template.
      Finally
        UpdateStatus()

        ' Check if template has been created.
        Select Case Enroller.TemplateStatus
          Case DPFP.Processing.Enrollment.Status.Ready    ' Report success and stop capturing
            RaiseEvent OnTemplate(Enroller.Template)
            SetPrompt("Click Close, and then click Fingerprint Verification.")
            StopCapture()

          Case DPFP.Processing.Enrollment.Status.Failed   ' Report failure and restart capturing
            Enroller.Clear()
            StopCapture()
            RaiseEvent OnTemplate(Nothing)
            StartCapture()

        End Select
      End Try
    End If
  End Sub

  Protected Sub UpdateStatus()
    ' Show number of samples needed.
    SetStatus(String.Format("Fingerprint samples needed: {0}", Enroller.FeaturesNeeded))
  End Sub

End Class
