<?php
namespace Sasuzu\MeCab\Models;

class MeCab
{
    const COMMAND = 'mecab';
    private $text = '';
    private $tmpFile= '';
    private $result = array();
    private $resultData = array();

    /*
     * 実行メインクラス
     */
    public function parse($text)
    {
        $this->text = $text;

        $this->outPutTmpFile();
        $this->execCommand();
        $this->analyse();
        $this->deleteTmpFile();

        return $this->resultData;
    }

    /*
     * tmpファイルの生成
     */
    private function outPutTmpFile()
    {
        $this->tmpFile = tempnam(sys_get_temp_dir(), 'mecab-'. date('Ymd-h:i:s'). '-');
        $current = file_get_contents($this->tmpFile);
        $current .= $this->text;

        if (!file_put_contents($this->tmpFile, $current)) {
            throw new \Exception('Error: output tmpfile.');
        }
        return true;
    }

    /*
     * mecabコマンドでファイルを解析する
     */
    private function execCommand()
    {
        $commandCode = '';

        // mecabコマンドをtmpファイルに向けて実行
        exec(self::COMMAND ." ". $this->tmpFile, $this->result, $commandCode);

        if ($commandCode === 127) {
            // コマンドが存在しない
            throw new \Exception('Error: not found mecab command.');
        }
        if ($commandCode !== 0) {
            // その他不明なエラー
            throw new \Exception('Error: unknown command.');
        }
        return true;
    }

    /*
     * 解析結果をパースし、JSON形式へ変更する
     */
    private function analyse()
    {
        $result = $this->result;
        $resultData = array();
        if ($result && count($result) > 0) {
            for ($i=0; $i<count($result) -1; $i++) { // 最後は改行コードなので除外する
                $strBuf = explode("\t", $result[$i]);
                if (isset($strBuf[0]) && isset($strBuf[1])) {
                    $resultData[$i]['surface'] = $strBuf[0];
                    $resultData[$i]['feature'] = explode(",", $strBuf[1]);
                }
            }
        }
        $resultData = json_encode($resultData);
        $this->resultData = $resultData;

        return true;
    }

    /*
     * tmpファイルを削除する
     */
    private function deleteTmpFile()
    {
        if (!unlink($this->tmpFile)) {
            throw new \Exception('Error: not delete tmpfile.');
        }
        return true;
    }
}
