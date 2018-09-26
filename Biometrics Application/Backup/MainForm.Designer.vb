<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Class MainForm
    Inherits System.Windows.Forms.Form

    'Form overrides dispose to clean up the component list.
    <System.Diagnostics.DebuggerNonUserCode()> _
    Protected Overrides Sub Dispose(ByVal disposing As Boolean)
        If disposing AndAlso components IsNot Nothing Then
            components.Dispose()
        End If
        MyBase.Dispose(disposing)
    End Sub

    'Required by the Windows Form Designer
    Private components As System.ComponentModel.IContainer

    'NOTE: The following procedure is required by the Windows Form Designer
    'It can be modified using the Windows Form Designer.  
    'Do not modify it using the code editor.
    <System.Diagnostics.DebuggerStepThrough()> _
    Private Sub InitializeComponent()
		Dim label1 As System.Windows.Forms.Label
		Dim Bevel As System.Windows.Forms.Label
		Me.CloseButton = New System.Windows.Forms.Button
		Me.LoadButton = New System.Windows.Forms.Button
		Me.SaveButton = New System.Windows.Forms.Button
		Me.VerifyButton = New System.Windows.Forms.Button
		Me.EnrollButton = New System.Windows.Forms.Button
		label1 = New System.Windows.Forms.Label
		Bevel = New System.Windows.Forms.Label
		Me.SuspendLayout()
		'
		'label1
		'
		label1.Anchor = CType(((System.Windows.Forms.AnchorStyles.Top Or System.Windows.Forms.AnchorStyles.Left) _
					Or System.Windows.Forms.AnchorStyles.Right), System.Windows.Forms.AnchorStyles)
		label1.BorderStyle = System.Windows.Forms.BorderStyle.Fixed3D
		label1.Location = New System.Drawing.Point(11, 186)
		label1.Name = "label1"
		label1.Size = New System.Drawing.Size(361, 3)
		label1.TabIndex = 12
		'
		'Bevel
		'
		Bevel.Anchor = CType(((System.Windows.Forms.AnchorStyles.Top Or System.Windows.Forms.AnchorStyles.Left) _
					Or System.Windows.Forms.AnchorStyles.Right), System.Windows.Forms.AnchorStyles)
		Bevel.BorderStyle = System.Windows.Forms.BorderStyle.Fixed3D
		Bevel.Location = New System.Drawing.Point(11, 90)
		Bevel.Name = "Bevel"
		Bevel.Size = New System.Drawing.Size(361, 3)
		Bevel.TabIndex = 9
		'
		'CloseButton
		'
		Me.CloseButton.Anchor = CType((System.Windows.Forms.AnchorStyles.Bottom Or System.Windows.Forms.AnchorStyles.Right), System.Windows.Forms.AnchorStyles)
		Me.CloseButton.DialogResult = System.Windows.Forms.DialogResult.Cancel
		Me.CloseButton.Location = New System.Drawing.Point(297, 203)
		Me.CloseButton.Name = "CloseButton"
		Me.CloseButton.Size = New System.Drawing.Size(75, 23)
		Me.CloseButton.TabIndex = 13
		Me.CloseButton.Text = "Close"
		Me.CloseButton.UseVisualStyleBackColor = True
		'
		'LoadButton
		'
		Me.LoadButton.Anchor = CType(((System.Windows.Forms.AnchorStyles.Top Or System.Windows.Forms.AnchorStyles.Left) _
					Or System.Windows.Forms.AnchorStyles.Right), System.Windows.Forms.AnchorStyles)
		Me.LoadButton.Location = New System.Drawing.Point(11, 142)
		Me.LoadButton.Name = "LoadButton"
		Me.LoadButton.Size = New System.Drawing.Size(361, 30)
		Me.LoadButton.TabIndex = 11
		Me.LoadButton.Text = "Read Fingerprint Template"
		Me.LoadButton.UseVisualStyleBackColor = True
		'
		'SaveButton
		'
		Me.SaveButton.Anchor = CType(((System.Windows.Forms.AnchorStyles.Top Or System.Windows.Forms.AnchorStyles.Left) _
					Or System.Windows.Forms.AnchorStyles.Right), System.Windows.Forms.AnchorStyles)
		Me.SaveButton.Enabled = False
		Me.SaveButton.Location = New System.Drawing.Point(11, 106)
		Me.SaveButton.Name = "SaveButton"
		Me.SaveButton.Size = New System.Drawing.Size(361, 30)
		Me.SaveButton.TabIndex = 10
		Me.SaveButton.Text = "Save Fingerprint Template"
		Me.SaveButton.UseVisualStyleBackColor = True
		'
		'VerifyButton
		'
		Me.VerifyButton.Anchor = CType(((System.Windows.Forms.AnchorStyles.Top Or System.Windows.Forms.AnchorStyles.Left) _
					Or System.Windows.Forms.AnchorStyles.Right), System.Windows.Forms.AnchorStyles)
		Me.VerifyButton.Enabled = False
		Me.VerifyButton.Location = New System.Drawing.Point(11, 47)
		Me.VerifyButton.Name = "VerifyButton"
		Me.VerifyButton.Size = New System.Drawing.Size(361, 30)
		Me.VerifyButton.TabIndex = 8
		Me.VerifyButton.Text = "Fingerprint Verification"
		Me.VerifyButton.UseVisualStyleBackColor = True
		'
		'EnrollButton
		'
		Me.EnrollButton.Anchor = CType(((System.Windows.Forms.AnchorStyles.Top Or System.Windows.Forms.AnchorStyles.Left) _
					Or System.Windows.Forms.AnchorStyles.Right), System.Windows.Forms.AnchorStyles)
		Me.EnrollButton.Location = New System.Drawing.Point(11, 11)
		Me.EnrollButton.Name = "EnrollButton"
		Me.EnrollButton.Size = New System.Drawing.Size(361, 30)
		Me.EnrollButton.TabIndex = 7
		Me.EnrollButton.Text = "Fingerprint Enrollment"
		Me.EnrollButton.UseVisualStyleBackColor = True
		'
		'MainForm
		'
		Me.AutoScaleDimensions = New System.Drawing.SizeF(6.0!, 13.0!)
		Me.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font
		Me.CancelButton = Me.CloseButton
		Me.ClientSize = New System.Drawing.Size(383, 237)
		Me.Controls.Add(Me.CloseButton)
		Me.Controls.Add(label1)
		Me.Controls.Add(Me.LoadButton)
		Me.Controls.Add(Me.SaveButton)
		Me.Controls.Add(Bevel)
		Me.Controls.Add(Me.VerifyButton)
		Me.Controls.Add(Me.EnrollButton)
		Me.FormBorderStyle = System.Windows.Forms.FormBorderStyle.FixedSingle
		Me.MaximizeBox = False
		Me.MinimizeBox = False
		Me.Name = "MainForm"
		Me.StartPosition = System.Windows.Forms.FormStartPosition.CenterScreen
		Me.Text = "Fingerprint Enrollment and Verification Sample"
		Me.ResumeLayout(False)

	End Sub
    Private WithEvents CloseButton As System.Windows.Forms.Button
    Private WithEvents LoadButton As System.Windows.Forms.Button
    Private WithEvents SaveButton As System.Windows.Forms.Button
    Private WithEvents VerifyButton As System.Windows.Forms.Button
    Private WithEvents EnrollButton As System.Windows.Forms.Button

End Class
