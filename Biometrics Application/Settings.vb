Imports MySql.Data.MySqlClient

Module Settings

    Public con As New MySqlConnection
    Public cmd As New MySqlCommand
    Public da As New MySqlDataAdapter
    Public dr As MySqlDataReader

    Public server = My.Settings.IPadd.ToString
    'Public username = My.Settings.userName.ToString
    'Public password = My.Settings.passw.ToString
    Public username = My.Settings.userName.ToString
    Public password = My.Settings.passw.ToString
    Public dbname = My.Settings.DbName.ToString
    'Public port = My.Settings.Port.ToString
    Public port = "3306"
    Public root = My.Settings.Root.ToString
    Public accessSetting = "ALL"

End Module
