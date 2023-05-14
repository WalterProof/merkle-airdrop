export const between = (min, max) =>
    Math.floor(Math.random() * (max - min) + min);

const SYNC_INTERVAL = 0;
const CONFIRM_TIMEOUT = 30000;

export const confirmOperation = async (
    tezos,
    opHash,
    { initializedAt, fromBlockLevel, signal } = {}
) => {
    if (!initializedAt) initializedAt = Date.now();
    if (initializedAt && initializedAt + CONFIRM_TIMEOUT < Date.now()) {
        throw new Error("Confirmation polling timed out");
    }

    const startedAt = Date.now();
    let currentBlockLevel;

    try {
        const currentBlock = await tezos.rpc.getBlock();
        currentBlockLevel = currentBlock.header.level;

        for (
            let i =
                fromBlockLevel !== null && fromBlockLevel !== void 0
                    ? fromBlockLevel
                    : currentBlockLevel;
            i <= currentBlockLevel;
            i++
        ) {
            const block =
                i === currentBlockLevel
                    ? currentBlock
                    : await tezos.rpc.getBlock({ block: i });

            const opEntry = await findOperation(block, opHash);
            if (opEntry) {
                return opEntry;
            }
        }
    } catch (err) {
        if (process.env.NODE_ENV === "development") {
            console.error(err);
        }
    }

    if (signal && signal.aborted) {
        throw new Error("Cancelled");
    }

    const timeToWait = Math.max(startedAt + SYNC_INTERVAL - Date.now(), 0);
    await new Promise((r) => setTimeout(r, timeToWait));

    return confirmOperation(tezos, opHash, {
        initializedAt,
        fromBlockLevel: currentBlockLevel
            ? currentBlockLevel + 1
            : fromBlockLevel,
        signal,
    });
};

async function findOperation(block, opHash) {
    for (let i = 3; i >= 0; i--) {
        for (const op of block.operations[i]) {
            if (op.hash === opHash) {
                return op;
            }
        }
    }
    return null;
}
